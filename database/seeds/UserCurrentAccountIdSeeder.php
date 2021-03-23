<?php

use Illuminate\Database\Seeder;

class UserCurrentAccountIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('==========> Start adding super admin current account info <==========');

        $email_meowlomo = 'it@meowlomo.com';

        $account_info_meowlomo = DB::table('accounts')->where('name','meowlomo' )->first();
        $account_infoArr_meowlomo = json_decode( json_encode( $account_info_meowlomo),true);
        $account_id_meowlomo = $account_infoArr_meowlomo['id'];

        DB::table('users')->where('email',$email_meowlomo)->update(['current_account_id' => $account_id_meowlomo]);

        $this->command->info('==========> Start adding super admin current account info <==========');

        $email_admin = 'admin@example.com';

        $account_info_admin = DB::table('accounts')->where('name','admin' )->first();
        $account_infoArr_admin = json_decode( json_encode( $account_info_admin),true);
        $account_id_admin = $account_infoArr_admin['id'];

        DB::table('users')->where('email',$email_admin)->update(['current_account_id' => $account_id_admin]);

    }
}
