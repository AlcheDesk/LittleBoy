<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AddEMSPermissionsSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$this->command->info('==========> adding AddEMSPermissionsSeeder permissions for EMS system <==========');

		//just Folder Permissions
		$ATMPermissions = [
			[
				'name' => 'view_ems_executive_overview', //folder
				'comment' => '读取EMS执行总览',
      ], [
				'name' => 'view_ems_work_list', //folder
				'comment' => '读取EMS工作列表',
      ], [
				'name' => 'view_ems_test_case_details', //folder
				'comment' => '读取EMS用例详情',
      ], [
				'name' => 'view_ems_execution_unit', //folder
				'comment' => '读取EMS执行单元',
      ],
		];

		//added the permission to the table
		foreach ($ATMPermissions as $perms) {
			Permission::firstOrCreate(['name' => $perms['name'], 'comment' => $perms['comment']]);
			$this->command->info('Permission ' . $perms['name'] . ' added.');
		}
		$this->command->info('Added all AddEMSPermissionsSeeder Permissions to the table.');

	}
}
