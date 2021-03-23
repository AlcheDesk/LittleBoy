<?php

use App\Http\Controllers\API\RBAC\Administrator\UserManagement;

Route::group([
	'namespace' => 'API\\RBAC\\Administrator',
	'prefix' => 'users',
	'middleware' => 'auth:api',
], function () {
	Route::get('/', 'UserManagement@selectByCondition');
	Route::delete('/{id}', 'UserManagement@destroy');
	Route::post('/', 'UserManagement@insert');
	Route::patch('/', 'UserManagement@update');
  Route::get('/{id}/message/', 'UserManagement@getRolesAndPermissionsMessage');
  Route::get('/{uuid}/accounts/', 'UserManagement@getAccountsByUserUuid');
  Route::get('/active/', 'UserManagement@activateAccountUserByUserId');
});

Route::group([
	'namespace' => 'API\\RBAC\\Administrator',
	'prefix' => 'count',
	'middleware' => 'auth:api',
], function () {
	Route::get('/users', 'UserManagement@getNameOrEmailOfUserNumbers');
});

Route::group([
	'namespace' => 'API\\RBAC\\Administrator',
	'prefix' => 'userActivityLogs',
	'middleware' => 'auth:api',
], function () {
	Route::get('/', 'UserManagement@readAdminstratorUserLogs');
});
