<?php
namespace App\Http\Controllers\API\RBAC\Administrator;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
//use App\Models\RBAC\Role;

class AuthManagement extends Controller
{

    //
    public function selectByCondition(Request $request)
    {
        $user = $request->user();
        $id = $request->query('id');
        if ($id) {
            $groupPermissions = $user->roles()
                ->where('id', '=', $id)
                ->first()
                ->permissions()
                ->get();
            $permissions = Role::findOrFail(2)->permissions()->get();
            $diffPermissions = $permissions->diff($groupPermissions);
            $count = $diffPermissions->count();
            $data = [
                'data' => $diffPermissions,
                'error' => [],
                'metadata' => [
                    'count' => $count
                ]
            ];
            return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
        } else {
            $defaultPageSize = $user->getAllPermissions()->count();
            $pageSize = $request->query('pageSize', $defaultPageSize);
            $pageNumber = $request->query('pageNumber', 1);
            $searchName = $request->query('name', '');
            $orderBy = $request->query('orderBy', 'id desc');
            $perm = $user->getAllPermissions()->filter(function ($value, $key) use ($searchName) {
                if (! $searchName) {
                    return true;
                }
                if (strpos($value['name'], $searchName, 0) !== false) {
                    return true;
                }
            });

            $count = $perm->count();

            if (strpos($orderBy, 'desc', 0) !== false) {
                $permissions = $perm->sortByDesc(explode(' ', $orderBy)[0])
                    ->forPage($pageNumber, $pageSize)
                    ->flatten()
                    ->all();
            } else {
                $permissions = $perm->sortBy(explode(' ', $orderBy)[0])
                    ->forPage($pageNumber, $pageSize)
                    ->flatten()
                    ->all();
            }

            $data = [
                'data' => $permissions,
                'error' => [],
                'metadata' => [
                    'count' => $count
                ]
            ];
            return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
        }
    }

    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required|max:40|unique:permissions',
                'comment' => 'max:255'
            ]);
            $input = $request->all();
            $name = $request['name'];
            $comment = $request['comment'];
            $permission = new Permission();
            $permission->name = $name;
            $permission->comment = $comment;
            $permission->guard_name = 'web';

            $permission->save();

            DB::commit();

            $suRole = Role::where('name', '=', 'su')->firstOrFail();
            $suRole->givePermissionTo($permission);
            $administratorRole = Role::where('name', '=', 'administrator')->firstOrFail();
            $administratorRole->givePermissionTo($permission);

            $data = [
                'data' => $permission,
                'error' => [],
                'metadata' => []
            ];
            return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required|max:40',
                'comment' => 'max:255'
            ]);
            $id = $request['id'];
            $permission = Permission::findOrFail($id);
            $input = $request->all();
            $permission->fill($input)->save();
            $updatePermissions = Permission::findOrFail($id);
            DB::commit();
            $data = [
                'data' => $updatePermissions,
                'error' => [],
                'metadata' => []
            ];
            return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            DB::commit();
            $data = [
                'data' => $permission,
                'error' => [],
                'metadata' => []
            ];
            return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function getUserAndRoleMessage(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        if ($request->user()->name == 'meowlomo') {
            $roles = $permission->roles()
                ->get()
                ->unique('name')
                ->values()
                ->all();
        } else {
            $roles = $permission->roles()
                ->where('name', '!=', 'su')
                ->get()
                ->unique('name')
                ->values()
                ->all();
        }

        $users = collect([]);
        foreach ($roles as $role) {
            $users->push(Role::findOrFail($role->id)->users()
                ->get());
        }

        if ($request->user()->name == 'meowlomo') {
            $users = $users->flatten()
                ->unique('name')
                ->values()
                ->all();
        } else {
            $users = $users->flatten()
                ->where('name', '!=', 'meowlomo')
                ->unique('name')
                ->values()
                ->all();
        }

        $data = [
            'data' => [
                'users' => $users,
                'roles' => $roles
            ],
            'error' => [],
            'metadata' => []
        ];
        return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function getPermissionsNumberOfName(Request $request)
    {
        $name = $request->query('name');
        $permissionsCount = Permission::where('name', '=', $name)->count();
        $data = [
            'data' => [],
            'error' => [],
            'metadata' => [
                'count' => $permissionsCount
            ]
        ];
        return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
    }
}
