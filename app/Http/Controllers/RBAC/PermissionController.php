<?php
namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;

class PermissionController extends Controller
{

    public function __construct()
    {
        // $this->middleware(['auth', 'isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Permission::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required|max:40'
            ]);
            $name = $request['name'];
            $permission = new Permission();
            $permission->name = $name;
            $roles = $request['roles'];

            $permission->save();
            if (! empty($request['roles'])) {
                foreach ($roles as $role) {
                    $r = Role::where('id', '=', $role)->firstOrFail(); // Match input role to db record
                    $permission = Permission::where('name', '=', $name)->first();
                    $r->givePermissionTo($permission);
                }
            }
            DB::commit();
            $insertedPermission = Permission::findOrFail($permission->id);
            return $insertedPermission;
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    // /**
    // * Display the specified resource.
    // *
    // * @param int $id
    // * @return \Illuminate\Http\Response
    // */
    // public function show($id)
    // {
    // return redirect('permissions');
    // }

    // /**
    // * Show the form for editing the specified resource.
    // *
    // * @param int $id
    // * @return \Illuminate\Http\Response
    // */
    // public function edit($id)
    // {
    // $permission = Permission::find($id);

    // return view('permissions.edit', compact('permission'));
    // }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $permission = Permission::findOrFail($id);
            $this->validate($request, [
                'name' => 'required|max:40'
            ]);
            $input = $request->all();
            $permission->fill($input)->save();
            DB::commit();
            return Permission::findOrFail($id);
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $permission = Permission::findOrFail($id);

            if ($permission->name == "Administer roles & permissions") {
                return redirect()->route('permissions.index')->with('flash_message', 'Cannot delete this Permission!');
            }

            $permission->delete();
            DB::commit();
            return $permission;
        } catch (Exception $e) {
            DB::rollback();
        }
    }
}


