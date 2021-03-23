<?php

namespace App\Http\Controllers\Auth\Accounts;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //添加role的关联关系，
    public function insert_role_relation($user_id, $account_id, $role_name)
    {
        $role_info = DB::table('roles')->where('name',$role_name )->first();
        $role_infoArr = json_decode( json_encode( $role_info),true);
        $role_id = $role_infoArr['id'];

        $id = DB::table('account_role')->insertGetId([
            'user_id' => $user_id,
            'account_id' => $account_id,
            'role_id' => $role_id
        ]);
    }

    //查询当前team中的同role类型的user,非meowlomo账号
    public function select_user_by_role_and_account($account_id, $role_id)
    {
        $user_ids = DB::table('account_role')->where('account_id', $account_id)->where('role_id', $role_id)->get('user_id');
        $user = json_decode($user_ids,true);

        $ids1 = array();
        foreach ($user as $ids){
            array_push($ids1,$ids['user_id']);
        }
        $users = User::whereIn('id',$ids1)->get();

        return $users;
    }

    //查询当前account下的所有role
    public function role_by_account($account_id)
    {
        //如果账号为su，展示所有
        if($account_id == 1){
            $role = Role::all();
        } else{
            $role_ids = DB::table('account_role')->where('account_id', $account_id)->get('role_id');
            $roles = json_decode($role_ids,true);

            $ids1 = array();
            foreach ($roles as $ids){
                array_push($ids1,$ids['role_id']);
            }
            $role = Role::whereIn('id',$ids1)->get();
        }
        return $role;
    }

    }
