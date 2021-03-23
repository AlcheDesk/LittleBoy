<?php

use Illuminate\Database\Seeder;

class LoginModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = DB::table('login_mode')->insertGetId(
            ['mode_name' => '邮箱密码']
        );        
    }
}
