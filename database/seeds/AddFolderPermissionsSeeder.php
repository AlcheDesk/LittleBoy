<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AddFolderPermissionsSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$this->command->info('==========> adding Folder permissions for ATM system <==========');

		//just Folder Permissions
		$ATMPermissions = [
			[
				'name' => 'view_folder', //folder
				'comment' => '读取共享文件夹',
			], [
				'name' => 'edit_folder',
				'comment' => '编辑共享文件夹',
			], [
				'name' => 'add_folder',
				'comment' => '添加共享文件夹',
			], [
				'name' => 'delete_folder',
				'comment' => '删除共享文件夹',
			], [
				'name' => 'view_folder_testcase', //folder_testCase
				'comment' => '读取共享文件夹测试用例',
			], [
				'name' => 'edit_folder_testcase',
				'comment' => '编辑共享文件夹测试用例',
			], [
				'name' => 'add_folder_testcase',
				'comment' => '添加共享文件夹测试用例',
			], [
				'name' => 'delete_folder_testcase',
				'comment' => '删除共享文件夹测试用例',
			],
		];

		//added the permission to the table
		foreach ($ATMPermissions as $perms) {
			Permission::firstOrCreate(['name' => $perms['name'], 'comment' => $perms['comment']]);
			$this->command->info('Permission ' . $perms['name'] . ' added.');
		}
		$this->command->info('Added all Folders Permissions to the table.');

	}
}
