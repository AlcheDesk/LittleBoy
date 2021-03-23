<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AddSystemRequirementsPermissionsSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$this->command->info('==========> adding SystemRequirements permissions for ATM system <==========');

		//just Folder Permissions
		$ATMPermissions = [
			[
				'name' => 'view_system_requirements_packs', //folder
				'comment' => '读取系统需求包',
			], [
				'name' => 'edit_system_requirements_packs',
				'comment' => '编辑系统需求包',
			], [
				'name' => 'add_system_requirements_packs',
				'comment' => '添加系统需求包',
			], [
				'name' => 'delete_system_requirements_packs',
				'comment' => '删除系统需求包',
			], [
				'name' => 'view_system_requirements', //folder_testCase
				'comment' => '读取系统需求',
			], [
				'name' => 'edit_system_requirements',
				'comment' => '编辑系统需求',
			], [
				'name' => 'add_system_requirements',
				'comment' => '添加系统需求',
			], [
				'name' => 'delete_system_requirements',
				'comment' => '删除系统需求',
			],
		];

		//added the permission to the table
		foreach ($ATMPermissions as $perms) {
			Permission::firstOrCreate(['name' => $perms['name'], 'comment' => $perms['comment']]);
			$this->command->info('Permission ' . $perms['name'] . ' added.');
		}
		$this->command->info('Added all SystemRequirements Permissions to the table.');

	}
}
