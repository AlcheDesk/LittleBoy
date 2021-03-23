<?php

use App\Account;
use App\Membership;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AccountTableSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$this->command->info('==========> Start adding super admin account info <==========');

        Account::firstOrCreate([
            'uuid' => '00112233-4455-6677-8899-aabbccddeeff',
            'name' => 'meowlomo',
            'account_level' => 'superadmin',
            'description' => 'meowlomo super admin account',
            'expirated_at' => Carbon::now()->addDays(9999),
        ]);

        Membership::firstOrCreate([
            'uuid' => '00112233-4455-6677-8899-aabbccddeeff',
            'name' => 'superadmin',
            'membership_email' => 'it@meowlomo.com',
            'role_id'  => Role::where('name', 'su')->first()['id'],
            'description' => 'super admin memebership',
            'expirated_at' => Carbon::now()->addDays(9999),
        ]);

        $this->command->info('==========> Done adding super admin account info <==========');*/
    }
}
