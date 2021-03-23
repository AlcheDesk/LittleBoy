<?php

namespace App\Models\RBAC;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Guard;
use Spatie\Permission\Models;
use Illuminate\Support\Facades\Log;

class Role extends Models\Role
{
    public static function findById(int $id, $guardName = null): RoleContract
    {
//        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        $guardName = 'web';

        $role = static::where('id', $id)->where('guard_name', $guardName)->first();
        Log::info("=====090909==222==".$guardName);
        Log::info($role);

        if (! $role) {
            throw RoleDoesNotExist::withId($id);
        }

        return $role;
    }

}
