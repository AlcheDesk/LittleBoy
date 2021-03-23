<?php
namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Exception;

class RoleController extends Controller
{

    public function __construct()
    {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::all(); // Get all roles
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
            // Validate name and permissions field
            $this->validate($request, [
                'name' => 'required|unique:roles|max:10',
                'permissions' => 'required'
            ]);

            $name = $request['name'];
            $role = new Role();
            $role->name = $name;

            $permissions = $request['permissions'];

            $role->save();
            // Looping thru selected permissions
            foreach ($permissions as $permission) {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                // Fetch the newly created role and assign permission
                $role = Role::where('name', '=', $name)->first();
                $role->givePermissionTo($p);
            }
            DB::commit();
            return Role::findOrFail($role->id);
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
    // return Role::findById($id);
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
            $this->validate($request, [
                'name' => 'required|unique:roles|max:10',
                'permissions' => 'required'
            ]);
            $name = $request['name'];
            $role = new Role();
            $role->name = $name;
            $permissions = $request['permissions'];
            $role->save();
            foreach ($permissions as $permission) {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role = Role::where('name', '=', $name)->first();
                $role->givePermissionTo($p);
            }
            $user = Role::findById($id);
            DB::commit();
            return $user;
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
            $role = Role::findOrFail($id);
            $role->delete();
            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollback();
        }
    }
}

