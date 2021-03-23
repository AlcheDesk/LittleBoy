<?php
namespace App\Http\Controllers\API\RBAC\Administrator;

use App\Http\Controllers\Auth\Accounts\LoginRecordController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
//use Spatie\Permission\Models\Role;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Traits\HasPermissions;
use App\Models\RBAC\Role;
use Illuminate\Support\Facades\Log;

class HasPermissionsManagement extends Controller {
    use HasPermissions;

    public static function hasPermissionToMeowlomo($permission, $user_id, $guardName = null): bool
    {
        $roles = new LoginRecordController();
        $role_id = $roles->get_role_id_by($user_id);
        $roleinfo = Role::findById($role_id);
        $flag = $roleinfo->hasPermissionTo($permission);
        Log::info("====override===hasPermissionTo====".$permission."==has==".$flag);
        return $flag;
    }

}
