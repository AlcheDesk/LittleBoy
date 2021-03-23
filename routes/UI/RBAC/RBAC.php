<?php

Route::group([
	'namespace' => 'UI\\RBAC',
	'prefix' => 'RBAC',
	'middleware' => [
		'auth', 'RBAC',
	],
], function () {

	Route::group([
		'prefix' => 'administrator',
	], function () {
		Route::get('/index', 'Administrator@showAdministratorBasicInfo')->name('basicInfo');

		Route::get('/permission', 'Administrator@showAdminstratorAuthManagement')->name('authManagement');

		Route::get('/group', 'Administrator@showAdminstratorGroupManagement')->name('groupManagement');

		Route::get('/group/{id}/permissions/', 'Administrator@showGroupPermissionsManagement')->name('groupPermissionManagement');

		Route::get('/group/{id}/users/', 'Administrator@showGroupUsersManagement')->name('groupUserManagement');

		Route::get('/user', 'Administrator@showAdminstratorUserManagement')->name('userManagement');

		Route::get('/user/{id}/logs', 'Administrator@showAdminstratorUserLogs')->name('userLogs');
	});
});
