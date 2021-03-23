<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use function GuzzleHttp\json_encode;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('==========> Start adding super admin account info <==========');

        $name_meowlomo = 'meowlomo';
        $user_info_meowlomo = DB::table('users')->where('name',$name_meowlomo )->first();
        $user_infoArr_meowlomo = json_decode( json_encode( $user_info_meowlomo),true);
        $uuid_meowlomo = $user_infoArr_meowlomo['uuid'];

        DB::table('accounts')->insert([
            'uuid' => (string) Str::uuid(),
            'name' => $name_meowlomo,
            'account_level' => 'superadmin',
            'description' => 'meowlomo super admin account',
            'expirated_at' => Carbon::now()->addDays(9999),
            'user_uuid' => $uuid_meowlomo,
            'tenant_id' => 1
        ]);

        $this->command->info('==========> Start adding admin account info <==========');

        $name_admin = 'admin';
        $user_info_admin = DB::table('users')->where('name',$name_admin )->first();
        $user_info_arr_admin = json_decode( json_encode( $user_info_admin),true);
        $uuid_admin = $user_info_arr_admin['uuid'];

        DB::table('accounts')->insert([
            'uuid' => (string) Str::uuid(),
            'name' => $name_admin,
            'account_level' => 'administrator',
            'description' => 'meowlomo administrator account',
            'expirated_at' => Carbon::now()->addDays(9999),
            'user_uuid' => $uuid_admin,
            'tenant_id' => 1000
        ]);

    }
}
