<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ATMRolesSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	public function run() {
		$this->command->info('==========> adding Roles for ATM system <==========');

		//RBAC default roles
		$RBACRoles = [
			[
				'name' => 'su',
				'comment' => 'meowlomo内部账户角色，拥有所有权限',
			], [
				'name' => 'administrator',
				'comment' => '管理员账户角色，拥有绝大多数权限',
			], [
				'name' => 'user',
				'comment' => '默认基础用户角色，最初始的角色',
			],
		];

		//add all the new permissions to administrator and su role
		foreach ($RBACRoles as $role) {
			Role::firstOrCreate(['name' => $role['name'], 'comment' => $role['comment']]);
			$this->command->info('Role ' . $role['name'] . ' found.');
		}
		$this->command->info('Added all RBACs Role to the table.');

		$this->command->info('==========> Done adding Roles for ATM system <==========');

	}
}
