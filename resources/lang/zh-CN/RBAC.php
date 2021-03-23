<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Pagination Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are used by the paginator library to build
	| the simple pagination links. You are free to change them to anything
	| you want to customize your views to better match your application.
	|
	 */

	'menu' => [
		'user_management_system' => '用户管理系统',
		'administrator' => '管理员',
		'general_user' => '普通用户',
		'basic_information' => '基本资料',
		'authority_management' => '权限管理',
		'group_management' => '群组管理',
		'user_management' => '用户管理',
	],

	'dialog' => [

		'title' => [
			'add' => '添加:name ',
			'edit' => '编辑:name ',
			'delete' => '删除:name ',
			'delete_info' => '该操作将删除 ',
			'delete_continue' => ' , 是否继续?',

			'permission_details' => '权限分配详情',
			'have_permission' => '拥有',
			'details_of_permission' => '权限的用户和角色详情如下',

			'group_details' => '群组分配详情',
			'have_group' => '群组',
			'details_of_group' => '拥有的用户和权限详情如下',

			'open' => '打开',

			'user_details' => '用户详情',
			'have_user' => '',
			'details_of_user' => '用户所属群组和权限详情如下',

		],

		'label' => [
			'user_name' => '用户名',
			'account_level' => '账号级别',
			'role' => '所属角色',
			'permission' => '权限',

			'permission_name' => '权限名称',
			'comment' => '备注信息',

			'user' => '用户',
			'group' => '群组',

			'email' => '邮箱地址',
			'password' => '密码',

			'group_user_name' => '群组用户名称',
			'group_permission_name' => '群组权限名称',
		],

		'placeholder' => [
			'enter_name' => '请输入名称',
			'enter_comment' => '请输入备注信息',
			'enter_email' => '请输入邮箱地址',
			'enter_password' => '请输入密码',

			'select_name' => '请选择群组用户',
			'select_permission' => '请选择群组权限',

			'search' => '请输入要搜索的数据',
		],

	],

	'table' => [
		'id' => '编号',
		'create_at' => '创建时间',
		'comment' => '备注',
		'operating' => '操作',
		'distribution_details' => '分配详情',
		'click_for_detail' => '点击查看详情',

		'permission_name' => '权限名称',
		'group_name' => '群组名称',
		'user_name' => '用户名',
		'email' => '邮箱地址',

		'group_user_name' => '群组用户名称',
		'group_permission_name' => '群组权限名称',

		'operating_object' => '操作对象',
		'action' => '动作',
		'modify_content' => '修改内容',
	],

	'operator' => [
		'new' => '新建',
		'edit' => '编辑',
		'delete' => '删除',
		'undelete' => '取消删除',
		'confirm' => '确定',
		'cancel' => '取消',
		'config' => '配置',

		'group_user' => '群组用户',
		'group_permission' => '群组权限',

		'record' => '操作记录',

		'pass' => '通过',
		'refuse' => '拒绝',
	],

	'validator' => [
		'name' => [
			'required' => '不能为空(选择或输入)',
			'exist' => '该名称数据库中已存在，请更改',
			'consists' => '名称由长度为1-32的数字字符下划线汉字组成',
		],
		'email' => '请输入正确的邮箱格式',
		'password' => '请输入密码，最小长度为6位',
	],

	'breadcrumb' => [
		'system_auth_manage' => '系统权限管理',
		'group_manage' => '群组管理',
		'user_manage' => '用户管理',
		'group_user' => '群组用户管理',
		'group_permission' => '群组权限管理',
		'user_record' => '用户操作记录',
	],

];
