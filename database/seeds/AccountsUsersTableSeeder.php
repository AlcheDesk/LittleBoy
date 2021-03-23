<?php

use Illuminate\Database\Seeder;
use App\Models\RBAC\accounts;
use App\Models\RBAC\users;

class AccountsUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->command->info('==========> Start adding super admin account_user info <==========');

        $name_meowlomo = 'meowlomo';
        $user_info_meowlomo = DB::table('users')->where('name',$name_meowlomo )->first();
        $user_info_arr_meowlomo = json_decode( json_encode( $user_info_meowlomo),true);
        $user_id_meowlomo = $user_info_arr_meowlomo['id'];

        $accounts_info_meowlomo = DB::table('accounts')->where('name',$name_meowlomo )->first();
        $accounts_info_arr_meowlomo = json_decode( json_encode( $accounts_info_meowlomo),true);
        $accounts_id_meowlomo = $accounts_info_arr_meowlomo['id'];

        $accounts = accounts::find($accounts_id_meowlomo);
        $accounts-> users()-> attach($user_id_meowlomo);
        DB::table('accounts_users')->where('users_id', 1)->update(['active' => 1]);

        $this->command->info('==========> Start adding admin account_user info <==========');

        $name_admin = 'admin';
        $user_info_admin = DB::table('users')->where('name',$name_admin )->first();
        $user_info_arr_admin = json_decode( json_encode( $user_info_admin),true);
        $user_id_admin = $user_info_arr_admin['id'];

        $accounts_info_admin = DB::table('accounts')->where('name',$name_admin )->first();
        $accounts_info_arr_admin = json_decode( json_encode( $accounts_info_admin),true);
        $accounts_id_admin = $accounts_info_arr_admin['id'];


        $accounts = accounts::find($accounts_id_admin);
        $accounts-> users()-> attach($user_id_admin);
        DB::table('accounts_users')->where('users_id', 2)->update(['active' => 1]);
    }
}
