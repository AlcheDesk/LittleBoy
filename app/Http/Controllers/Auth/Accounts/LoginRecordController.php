<?php

namespace App\Http\Controllers\Auth\Accounts;

use App\Http\Controllers\Controller;
use App\Models\RBAC\accounts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function GuzzleHttp\json_encode;

class LoginRecordController extends Controller
{
    public function update_current_accout($user_uuid, $account_id)
    {
        $login_record = DB::table('login_record')->where('uuid',$user_uuid)->get();
        $login_record_current_id = $login_record->max('id');

        DB::table('login_record')->where('id',$login_record_current_id)->update(['current_account_id' => $account_id]);

        DB::table('users')->where('uuid',$user_uuid)->update(['current_account_id' => $account_id]);

    }

    //根据user查询当前的tenantid
    public function get_tenant_id($user)
    {
        $current_account_id = $user->current_account_id;
        $account_info = DB::table('accounts')->where('id',$current_account_id)->get();
        $account = json_decode( json_encode( $account_info),true);

        return $account[0]['tenant_id'];
    }

    //根据user查询当前的role
    public function get_role_id($user)
    {
        $user_id = $user->id;
        $current_account_id = $user->current_account_id;

        $role = DB::table('account_role')->where('account_id',$current_account_id)->where('user_id',$user_id) ->get();
        $role_info = json_decode( json_encode( $role),true);

        return $role_info[0]['role_id'];
    }

    //根据user id查询当前的role
    public function get_role_id_by($user_id)
    {
        $user = DB::table('users')->where('id',$user_id)->get();
        $user_info = json_decode( json_encode( $user),true);
        $current_account_id = $user_info[0]['current_account_id'];

        $role = DB::table('account_role')->where('account_id',$current_account_id)->where('user_id',$user_id) ->get();
        $role_info = json_decode( json_encode( $role),true);

        return $role_info[0]['role_id'];
    }

    }
