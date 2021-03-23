<?php

use Illuminate\Database\Seeder;
use function GuzzleHttp\json_encode;

class tenantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userInfo = DB::table('users')->where('name','meowlomo')->first();
        $userInfoArr = json_decode( json_encode( $userInfo),true);
        $meowlomo_uuid = $userInfoArr['uuid'];

        DB::table('tenant')->insert([
            //meowlomo
            'tenant_id_public' => 1,
            'tenant_id_private' => 1,
            'user_uuid' => $meowlomo_uuid,
            'cloud_config' => env('CLOUD_CONFIG')
        ]);

        $userInfo = DB::table('users')->where('name','admin')->first();
        $userInfoArr = json_decode( json_encode( $userInfo),true);
        $admin_uuid = $userInfoArr['uuid'];

        DB::table('tenant')->insert([
            //admin
            'tenant_id_public' => 1000,
            'tenant_id_private' => 1000,
            'user_uuid' => $admin_uuid,
            'cloud_config' => env('CLOUD_CONFIG')
        ]);
    }
}
