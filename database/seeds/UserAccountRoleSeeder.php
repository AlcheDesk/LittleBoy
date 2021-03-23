<?php

use Illuminate\Database\Seeder;

class UserAccountRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('==========> Start adding super admin account info <==========');

        $user_info_meowlomo = DB::table('users')->where('email','it@meowlomo.com')->first();
        $user_infoArr_meowlomo = json_decode( json_encode( $user_info_meowlomo),true);
        $user_id_meowlomo = $user_infoArr_meowlomo['id'];

        $account_info_meowlomo = DB::table('accounts')->where('name','meowlomo' )->first();
        $account_infoArr_meowlomo = json_decode( json_encode( $account_info_meowlomo),true);
        $account_id_meowlomo = $account_infoArr_meowlomo['id'];

        $role_info_meowlomo = DB::table('roles')->where('name','su' )->first();
        $role_infoArr_meowlomo = json_decode( json_encode( $role_info_meowlomo),true);
        $role_id_meowlomo = $role_infoArr_meowlomo['id'];

        DB::table('account_role')->insert([
            'user_id' => $user_id_meowlomo,
            'account_id' => $account_id_meowlomo,
            'role_id' => $role_id_meowlomo
        ]);


        $this->command->info('==========> Start adding administrator account info <==========');

        $user_info_admin = DB::table('users')->where('email','admin@example.com')->first();
        $user_infoArr_admin = json_decode( json_encode( $user_info_admin),true);
        $user_id_admin = $user_infoArr_admin['id'];

        $account_info_admin = DB::table('accounts')->where('name','admin' )->first();
        $account_infoArr_admin = json_decode( json_encode( $account_info_admin),true);
        $account_id_admin = $account_infoArr_admin['id'];

        $role_info_admin = DB::table('roles')->where('name','administrator' )->first();
        $role_infoArr_admin = json_decode( json_encode( $role_info_admin),true);
        $role_id_admin = $role_infoArr_admin['id'];

        DB::table('account_role')->insert([
            'user_id' => $user_id_admin,
            'account_id' => $account_id_admin,
            'role_id' => $role_id_admin
        ]);

    }
}
