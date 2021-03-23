<?php
namespace App\Http\Controllers\API\RBAC\Administrator;

use App\Http\Controllers\Auth\Accounts\RoleController;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class GroupManagement extends Controller
{

    //
    public function selectByCondition(Request $request)
    {
        $user = $request->user();
//        $defaultPageSize = $user->roles()->count();
//        $roles = $user->roles()->get();

        $account_id = $user->current_account_id;
        $roleController = new RoleController();
        $role = $roleController->role_by_account($account_id);

        $defaultPageSize = $role->count();

        $pageSize = $request->query('pageSize', $defaultPageSize);
        $pageNumber = $request->query('pageNumber', 1);
        $searchName = $request->query('name', '');
        $orderBy = $request->query('orderBy', 'id desc');
        $role = $role->filter(function ($value, $key) use ($searchName) {
            if (! $searchName) {
                return true;
            }
            if (strpos($value['name'], $searchName, 0) !== false) {
                return true;
            }
        });

        $count = $role->count();

        if (strpos($orderBy, 'desc', 0) !== false) {
            $roles = $role->sortByDesc(explode(' ', $orderBy)[0])
                ->forPage($pageNumber, $pageSize)
                ->flatten()
                ->all();
        } else {
            $roles = $role->sortBy(explode(' ', $orderBy)[0])
                ->forPage($pageNumber, $pageSize)
                ->flatten()
                ->all();
        }

        $data = [
            'data' => $roles,
            'error' => [],
            'metadata' => [
                'count' => $count
            ]
        ];
        return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required|max:40',
                'comment' => 'max:255'
            ]);
            $input = $request->all();
            $name = $request['name'];
            $comment = $request['comment'];
            $role = new Role();
            $role->name = $name;
            $role->comment = $comment;
            $role->guard_name = 'web';

            $role->save();

            DB::commit();

            $meowlomoUser = User::where('name', '=', 'meowlomo')->firstOrFail();
            $meowlomoUser->assignRole($role->name);
            $administratorUser = User::where('name', '=', 'admin')->firstOrFail();
            $administratorUser->assignRole($role->name);

            //插入account，user，role的关联数据
            $roleController = new RoleController();
            $roleController->insert_role_relation(Auth::user()->id, Auth::user()->current_account_id, $name);

            $data = [
                'data' => $role,
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
            $role = Role::findOrFail($id);
            $input = $request->all();
            $role->fill($input)->save();
            $updateRole = Role::findOrFail($id);
            DB::commit();
            $data = [
                'data' => $updateRole,
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
        Log::info("====role==de===");
        DB::beginTransaction();
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            DB::commit();
            $data = [
                'data' => $role,
                'error' => [],
                'metadata' => []
            ];
            //删除account，user，role的关联数据
            DB::table('account_role')->where('role_id', $id)->delete();
            return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function getUserAndPermissionMessage(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions()
            ->get()
            ->unique('name')
            ->values()
            ->all();

        if ($request->user()->name == 'meowlomo') {
            $users = $role->users()
                ->get()
                ->unique('name')
                ->values()
                ->all();
        } else {
            /*$users = $role->users()
                ->get()
                ->where('name', '!=', 'meowlomo')
                ->unique('name')
                ->values()
                ->all();*/
            $current_account_id = Auth::user()->current_account_id;

            $roleController = new RoleController();
            $users =$roleController->select_user_by_role_and_account($current_account_id, $id);
            Log::info($users);
            $groupUsers = Auth::user();
            
            Log::info($groupUsers);
			$diffUsers = $users->diff($groupUsers);
            Log::info($diffUsers);
        }
        $data = [
            'data' => [
                'users' => $diffUsers,
                'permissions' => $permissions
            ],
            'error' => [],
            'metadata' => []
        ];
        return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function getPermissionsNumberOfName(Request $request)
    {
        $name = $request->query('name');
        $roleCount = Role::where('name', '=', $name)->count();
        $data = [
            'data' => [],
            'error' => [],
            'metadata' => [
                'count' => $roleCount
            ]
        ];
        return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function selectGroupPermissionsByCondition(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions()->get();
        $defaultPageSize = $role->permissions()->count();
        $pageSize = $request->query('pageSize', $defaultPageSize);
        $pageNumber = $request->query('pageNumber', 1);
        $searchName = $request->query('name', '');
        $orderBy = $request->query('orderBy', 'id desc');
        $permission = $permissions->filter(function ($value, $key) use ($searchName) {
            if (! $searchName) {
                return true;
            }
            if (strpos($value['name'], $searchName, 0) !== false) {
                return true;
            }
        });

        $count = $permission->count();

        if (strpos($orderBy, 'desc', 0) !== false) {
            $permissions = $permission->sortByDesc(explode(' ', $orderBy)[0])
                ->forPage($pageNumber, $pageSize)
                ->flatten()
                ->all();
        } else {
            $permissions = $permission->sortBy(explode(' ', $orderBy)[0])
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

    public function associateRoleAndPermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $permissionsId = $request['ids'];
        $role->givePermissionTo($permissionsId);
        $permissions = $role->permissions()->get();
        $count = $permissions->count();

        $data = [
            'data' => $permissions,
            'error' => [],
            'metadata' => [
                'count' => $count
            ]
        ];
        return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function deleteRoleAndPermissionAssociations(Request $request, $gid, $pid)
    {
        $role = $request->user()
            ->roles()
            ->where('id', '=', $gid)
            ->first();
        $permission = $role->permissions()
            ->where('id', '=', $pid)
            ->get();
        $role->revokePermissionTo($permission);
        $data = [
            'data' => $permission,
            'error' => [],
            'metadata' => []
        ];
        return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function selectGroupUsersByCondition(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        if ($role->name !== 'su') {
            $users = $role->users()
                ->where('name', '!=', 'meowlomo')
                ->get();
        } else {
            $users = $role->users()->get();
        }

        $defaultPageSize = $role->users()->count();
        $pageSize = $request->query('pageSize', $defaultPageSize);
        $pageNumber = $request->query('pageNumber', 1);
        $searchName = $request->query('name', '');
        $orderBy = $request->query('orderBy', 'id desc');
        $user = $users->filter(function ($value, $key) use ($searchName) {
            if (! $searchName) {
                return true;
            }
            if (strpos($value['name'], $searchName, 0) !== false) {
                return true;
            }
        });

        $count = $user->count();

        if (strpos($orderBy, 'desc', 0) !== false) {
            $users = $user->sortByDesc(explode(' ', $orderBy)[0])
                ->forPage($pageNumber, $pageSize)
                ->flatten()
                ->all();
        } else {
            $users = $user->sortBy(explode(' ', $orderBy)[0])
                ->forPage($pageNumber, $pageSize)
                ->flatten()
                ->all();
        }

        $data = [
            'data' => $users,
            'error' => [],
            'metadata' => [
                'count' => $count
            ]
        ];
        return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function associateRoleAndUsers(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $usersId = $request['ids'];
        array_map(function ($userId) use ($role) {
            $user = User::where('id', '=', $userId)->firstOrFail();
            $user->assignRole($role);
        }, $usersId);
        $users = $role->users()
            ->get()
            ->unique('name')
            ->values()
            ->all();

        $data = [
            'data' => $users,
            'error' => [],
            'metadata' => []
        ];
        return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
    }

    public function deleteRoleAndUserAssociations(Request $request, $gid, $uid)
    {
        $user = User::where('id', '=', $uid)->firstOrFail();
        $role = Role::where('id', '=', $gid)->firstOrFail();
        $user->removeRole($role);
        $data = [
            'data' => $user,
            'error' => [],
            'metadata' => []
        ];
        return response($data, 200)->header('Content-Type', 'application/json; charset=utf8');
    }
}
