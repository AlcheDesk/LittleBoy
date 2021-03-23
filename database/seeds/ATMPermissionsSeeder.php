<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ATMPermissionsSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$this->command->info('==========> adding permissions for ATM system <==========');

		//just TAM Permissions
		$ATMPermissions = [
			[
				'name' => 'view_system_setting', //system_setting
				'comment' => '读取系统设置',
			], [
				'name' => 'edit_system_setting',
				'comment' => '编辑系统设置',
			], [
				'name' => 'view_projects', //projects
				'comment' => '读取项目',
			], [
				'name' => 'add_projects',
				'comment' => '添加项目',
			], [
				'name' => 'edit_projects',
				'comment' => '编辑项目',
			], [
				'name' => 'delete_projects',
				'comment' => '删除项目',
			], [
				'name' => 'import_projects',
				'comment' => '导出项目',
			], [
				'name' => 'copy_projects',
				'comment' => '复制项目',
			], [
				'name' => 'view_test_cases', //test_case
				'comment' => '读取测试用例',
			], [
				'name' => 'add_test_cases',
				'comment' => '添加测试用例',
			], [
				'name' => 'edit_test_cases',
				'comment' => '编辑测试用例',
			], [
				'name' => 'delete_test_cases',
				'comment' => '删除测试用例',
			], [
				'name' => 'import_test_cases',
				'comment' => '导出测试用例',
			], [
				'name' => 'copy_test_cases',
				'comment' => '复制测试用例',
			], [
				'name' => 'view_test_case_tags', //test_case_tags
				'comment' => '读取测试用例标签',
			], [
				'name' => 'add_test_case_tags',
				'comment' => '添加测试用例标签',
			], [
				'name' => 'edit_test_case_tags',
				'comment' => '编辑测试用例标签',
			], [
				'name' => 'delete_test_case_tags',
				'comment' => '删除测试用例标签',
			], [
				'name' => 'view_test_case_overwrites', //test_case_overwrite
				'comment' => '读取测试用例参数配置',
			], [
				'name' => 'add_test_case_overwrites',
				'comment' => '添加测试用例参数配置',
			], [
				'name' => 'copy_test_case_overwrites',
				'comment' => '复制测试用例参数配置',
			], [
				'name' => 'delete_test_case_overwrites',
				'comment' => '删除测试用例参数配置',
			], [
				'name' => 'add_test_cases_to_run_plan', //add_test_cases_to_run_plan
				'comment' => '添加测试用例到运行计划',
			], [
				'name' => 'view_instructions', //instruction
				'comment' => '读取测试步骤',
			], [
				'name' => 'add_instructions',
				'comment' => '添加测试步骤',
			], [
				'name' => 'edit_instructions',
				'comment' => '编辑测试步骤',
			], [
				'name' => 'delete_instructions',
				'comment' => '删除测试步骤',
			], [
				'name' => 'copy_instructions',
				'comment' => '复制测试步骤',
			], [
				'name' => 'view_instructions_overwrites', //instructions_overwrite
				'comment' => '读取测试步骤参数配置',
			], [
				'name' => 'edit_instructions_overwrites',
				'comment' => '编辑测试步骤参数配置',
			], [
				'name' => 'delete_instructions_overwrites',
				'comment' => '删除测试步骤参数配置',
			], [
				'name' => 'run_test_case', //run_test_case
				'comment' => '运行测试用例',
			], [
				'name' => 'view_applications', //application
				'comment' => '读取项目板块',
			], [
				'name' => 'add_applications',
				'comment' => '添加项目板块',
			], [
				'name' => 'edit_applications',
				'comment' => '编辑项目板块',
			], [
				'name' => 'delete_applications',
				'comment' => '删除项目板块',
			], [
				'name' => 'view_sections', //section
				'comment' => '读取项目子板块',
			], [
				'name' => 'add_sections',
				'comment' => '添加项目子板块',
			], [
				'name' => 'edit_sections',
				'comment' => '编辑项目子板块',
			], [
				'name' => 'delete_sections',
				'comment' => '删除项目子板块',
			], [
				'name' => 'view_elements', //elements
				'comment' => '读取元素',
			], [
				'name' => 'add_elements',
				'comment' => '添加元素',
			], [
				'name' => 'edit_elements',
				'comment' => '编辑元素',
			], [
				'name' => 'delete_elements',
				'comment' => '删除元素',
			], [
				'name' => 'view_run_sets', //run_sets
				'comment' => '读取自定义执行列表',
			], [
				'name' => 'add_run_sets',
				'comment' => '添加自定义执行列表',
			], [
				'name' => 'edit_run_sets',
				'comment' => '编辑自定义执行列表',
			], [
				'name' => 'delete_run_sets',
				'comment' => '删除自定义执行列表',
			], [
				'name' => 'view_run_sets_tags', //run_sets_tags
				'comment' => '读取自定义执行列表标签',
			], [
				'name' => 'add_run_sets_tags',
				'comment' => '添加自定义执行列表标签',
			], [
				'name' => 'edit_run_sets_tags',
				'comment' => '编辑自定义执行列表标签',
			], [
				'name' => 'delete_run_sets_tags',
				'comment' => '删除自定义执行列表标签',
			], [
				'name' => 'view_run_sets_test_cases', //run_sets_test_case
				'comment' => '读取自定义执行列表内测试用例',
			], [
				'name' => 'add_run_sets_test_cases',
				'comment' => '添加自定义执行列表内测试用例',
			], [
				'name' => 'delete_run_sets_test_cases',
				'comment' => '删除自定义执行列表内测试用例',
			], [
				'name' => 'run_set_reference_run_set', //run_set_reference_run_set
				'comment' => '自定义执行列表内引用其他自定义执行列表',
			], [
				'name' => 'run_set_run', //run_set_run
				'comment' => '执行自定义执行列表',
			], [
				'name' => 'run_set_test_case_overwrite_set', //run_set_test_case_overwrite_set
				'comment' => '自定义执行列表内测试用例执行参数设置',
			], [
				'name' => 'run_set_test_case_driver_package_set', //run_set_test_case_driver_package_set
				'comment' => '自定义执行列表内测试用例执行驱动设置',
			], [
				'name' => 'view_drivers', //drivers
				'comment' => '读取引擎',
			], [
				'name' => 'add_drivers',
				'comment' => '添加引擎',
			], [
				'name' => 'edit_drivers',
				'comment' => '编辑引擎',
			], [
				'name' => 'delete_drivers',
				'comment' => '删除引擎',
			], [
				'name' => 'view_drivers_properties', //driver_property
				'comment' => '读取引擎属性',
			], [
				'name' => 'add_drivers_properties',
				'comment' => '添加引擎属性',
			], [
				'name' => 'edit_drivers_properties',
				'comment' => '编辑引擎属性',
			], [
				'name' => 'delete_drivers_properties',
				'comment' => '删除引擎属性',
			], [
				'name' => 'view_drivers_packs', //driver_packs
				'comment' => '读取引擎包',
			], [
				'name' => 'edit_drivers_packs',
				'comment' => '编辑引擎包',
			], [
				'name' => 'add_drivers_packs',
				'comment' => '添加引擎包',
			], [
				'name' => 'delete_drivers_packs',
				'comment' => '删除引擎包',
			], [
				'name' => 'view_drivers_pack_drivers', //driver_packs_management
				'comment' => '读取引擎包中的引擎',
			], [
				'name' => 'edit_drivers_pack_drivers',
				'comment' => '编辑引擎包的引擎',
			], [
				'name' => 'add_drivers_pack_drivers',
				'comment' => '向引擎包添加引擎',
			], [
				'name' => 'delete_drivers_pack_drivers',
				'comment' => '删除引擎包内的引擎',
			], [
				'name' => 'view_run_status', //view_run_status
				'comment' => '查看运行状态',
			], [
				'name' => 'view_run_result', //view_run_result
				'comment' => '查看运行结果',
			], [
				'name' => 'view_instruction_bundle', //template
				'comment' => '读取包',
			], [
				'name' => 'edit_instruction_bundle',
				'comment' => '编辑包',
			], [
				'name' => 'add_instruction_bundle',
				'comment' => '添加包',
			], [
				'name' => 'delete_instruction_bundle',
				'comment' => '删除包',
			], [
				'name' => 'view_instruction_bundle_entry', //instruction_template
				'comment' => '读取指令包',
			], [
				'name' => 'edit_instruction_bundle_entry',
				'comment' => '编辑指令包',
			], [
				'name' => 'add_instruction_bundle_entry',
				'comment' => '添加指令包',
			], [
				'name' => 'delete_instruction_bundle_entry',
				'comment' => '删除指令包',
			],
		];

		//Administrator and meowlomo RBAC permissions
		$RBACPermissions = [
			[
				'name' => 'view_users', //user
				'comment' => '查看用户',
			], [
				'name' => 'add_users',
				'comment' => '添加用户',
			], [
				'name' => 'edit_users',
				'comment' => '编辑用户',
			], [
				'name' => 'delete_users',
				'comment' => '删除用户',
			], [
				'name' => 'view_roles', //role
				'comment' => '查看角色',
			], [
				'name' => 'add_roles',
				'comment' => '添加角色',
			], [
				'name' => 'edit_roles',
				'comment' => '编辑角色',
			], [
				'name' => 'delete_roles',
				'comment' => '删除角色',
			], [
				'name' => 'view_permissions', //permission
				'comment' => '查看权限',
			], [
				'name' => 'ATM',
				'comment' => '访问ATM权限',
			], [
				'name' => 'EMS',
				'comment' => '访问EMS权限',
			], [
				'name' => 'RBAC',
				'comment' => '访问用户管理系统权限',
			], [
				'name' => 'read_group_permissions', //groupPermission
				'comment' => '查看群组权限',
			], [
				'name' => 'add_group_permissions',
				'comment' => '添加群组权限',
			], [
				'name' => 'delete_group_permissions',
				'comment' => '删除群组权限',
			], [
				'name' => 'read_group_users', //groupUser
				'comment' => '查看群组用户',
			], [
				'name' => 'add_group_users',
				'comment' => '添加群组用户',
			], [
				'name' => 'delete_group_users',
				'comment' => '删除群组用户',
			],
		];

		//added the permission to the table
		foreach ($ATMPermissions as $perms) {
			Permission::firstOrCreate(['name' => $perms['name'], 'comment' => $perms['comment']]);
			$this->command->info('Permission ' . $perms['name'] . ' added.');
		}
		$this->command->info('Added all ATMs Permissions to the table.');

		foreach ($RBACPermissions as $perms) {
			Permission::firstOrCreate(['name' => $perms['name'], 'comment' => $perms['comment']]);
			$this->command->info('Permission ' . $perms['name'] . ' added.');
		}
		$this->command->info('Added all RBACs Permissions to the table.');

		$this->command->info('==========> Done adding permissions for ATM system <==========');

	}
}
