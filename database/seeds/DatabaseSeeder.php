<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
		// $this->call(UsersTableSeeder::class);
		$this->call(AdminUserSeeder::class);
		$this->call(AddFolderPermissionsSeeder::class);
		$this->call(ATMPermissionsSeeder::class);
		$this->call(ATMRolesSeeder::class);
		$this->call(GivePermissionToRoles::class);
		$this->call(LoginModeSeeder::class);
		$this->call(AccountTableSuperAdminSeeder::class);
//        $this->call(tenantTableSeeder::class);
        $this->call(AddSystemRequirementsPermissionsSeeder::class);
        $this->call(AccountsTableSeeder::class);
        $this->call(AccountsUsersTableSeeder::class);
        $this->call(UserAccountRoleSeeder::class);
        $this->call(UserCurrentAccountIdSeeder::class);
        $this->call(AddEMSPermissionsSeeder::class);
	}
}
