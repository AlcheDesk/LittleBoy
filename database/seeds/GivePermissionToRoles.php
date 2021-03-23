<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GivePermissionToRoles extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	public function run() {
		$this->command->info('==========> GivePermissionToRoles starting <==========');

		$SuPermissions = [
			[
				'name' => 'add_permissions',
				'comment' => '添加权限',
			], [
				'name' => 'edit_permissions',
				'comment' => '编辑权限',
			], [
				'name' => 'delete_permissions',
				'comment' => '删除权限',
			],
		];

		foreach ($SuPermissions as $perms) {
			Permission::firstOrCreate(['name' => $perms['name'], 'comment' => $perms['comment']]);
			$this->command->info('Permission ' . $perms['name'] . ' added.');
		}

		// assign all permissions for administrator
		$adminRole = Role::findByName('administrator');
		$adminRole->syncPermissions(Permission::all());

		//delete adminRole permission operator
		if ($adminRole->hasPermissionTo('add_permissions')) {
			$adminRole->revokePermissionTo('add_permissions');
		}

		if ($adminRole->hasPermissionTo('edit_permissions')) {
			$adminRole->revokePermissionTo('edit_permissions');
		}

		if ($adminRole->hasPermissionTo('delete_permissions')) {
			$adminRole->revokePermissionTo('delete_permissions');
		}

		$this->command->info('Administrator granted all permissions about ATM and RBAC');

		//default user permissions
		$userRole = Role::findByName('user');
		$userRole->syncPermissions(Permission::where('name', 'LIKE', '%view%')->get());
		$userRole->givePermissionTo('ATM');

		// assign all permissions for su
		$suRole = Role::findByName('su');

		$suRole->syncPermissions(Permission::all());
		$this->command->info('SU granted all permissions');

		//assign the su role to meowlomo user
		$meowlomoUser = User::where('name', 'meowlomo')->first();
		$meowlomoUser->assignRole('su', 'administrator', 'user');

		//assign the administrator role to admin user
		$adminUser = User::where('name', 'admin')->first();
		$adminUser->assignRole('administrator', 'user');

		$this->command->info('==========> GivePermissionToRoles Done <==========');

	}
}
