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
		'user_management_system' => 'User Management System',
		'administrator' => 'Administrator',
		'general_user' => 'General User',
		'basic_information' => 'Basic Information',
		'authority_management' => 'Permission Management',
		'group_management' => 'Group Management',
		'user_management' => 'User Management',
	],

	'dialog' => [

		'title' => [
			'add' => 'Add :name ',
			'edit' => 'Edit :name ',
			'delete' => 'Delete :name ',
			'delete_info' => 'This operation will delete',
			'delete_continue' => ' , continue?',

			'permission_details' => 'Permission allocation details',
			'have_permission' => 'Details of users and roles with ',
			'details_of_permission' => ' permission are as follows',

			'group_details' => 'Group allocation details',
			'have_group' => 'The details of the users and permissions owned by group ',
			'details_of_group' => ' are as follows',
			'open' => 'Open',

			'user_details' => 'User allocation details',
			'have_user' => 'The details of the group and permissions of the ',
			'details_of_user' => ' user are as follows',

		],

		'label' => [
			'user_name' => 'User Name',
			'account_level' => 'Account Level',
			'role' => 'Role',
			'permission' => 'Permission',

			'permission_name' => 'Permission Name',
			'comment' => 'Comment',

			'user' => 'User',
			'group' => 'Group',

			'group_name' => 'Group Name',

			'email' => 'Email',
			'password' => 'Password',

			'group_user_name' => 'Group User Name',
			'group_permission_name' => 'Permission Name',
		],

		'placeholder' => [
			'enter_name' => 'Please enter a name',
			'enter_comment' => 'Please enter a comment',
			'enter_email' => 'Please enter a email',
			'enter_password' => 'Please enter a password',

			'select_name' => 'Please select a group user',
			'select_permission' => 'Please select a group permission',

			'search' => 'Please enter the data to search for',
		],

	],

	'table' => [
		'id' => 'Id',
		'create_at' => 'CreateAt',
		'comment' => 'Comment',
		'operating' => 'Operating',
		'distribution_details' => 'Distribution Details',
		'click_for_detail' => 'Click for details',

		'permission_name' => 'Permission Name',
		'group_name' => 'Group Name',
		'user_name' => 'User Name',
		'email' => 'Email',

		'group_user_name' => 'Group User Name',
		'group_permission_name' => 'Group Permission Name',

		'operating_object' => 'Operating Object',
		'action' => 'Action',
		'modify_content' => 'Modify Content',
	],

	'operator' => [
		'new' => 'New',
		'edit' => 'Edit',
		'delete' => 'Delete',
		'undelete' => 'Undelete',
		'confirm' => 'Confirm',
		'cancel' => 'Cancel',
		'config' => 'config',

		'group_user' => 'Group User',
		'group_permission' => 'Group Permission',

		'record' => 'Record',

		'pass' => 'Pass',
		'refuse' => 'Refuse',
	],

	'validator' => [
		'name' => [
			'required' => 'Cannot be empty (select or enter)',
			'exist' => 'The name database already exists, please change',
			'consists' => 'The name consists of a numeric character with a length of 1-32 and an underlined Chinese character',
		],
		'email' => 'Please enter the correct mailbox format',
		'password' => 'Please enter a password with a minimum length of 6 digits',
	],

	'breadcrumb' => [
		'system_auth_manage' => 'System Permission Management',
		'group_manage' => 'Group Management',
		'user_manage' => 'User Management',
		'group_user' => 'Group User Management',
		'group_permission' => 'Group Permission Management',
		'user_record' => 'User Operation Record',
	],

];
