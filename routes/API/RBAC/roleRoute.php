<?php

Route::group([
	'namespace' => 'API\\RBAC\\Administrator',
	'prefix' => 'roles',
	'middleware' => 'auth:api',
], function () {
	Route::get('/', 'GroupManagement@selectByCondition');
	Route::delete('/{id}/', 'GroupManagement@destroy');
	Route::post('/', 'GroupManagement@insert');
	Route::patch('/', 'GroupManagement@update');
	Route::get('/{id}/message/', 'GroupManagement@getUserAndPermissionMessage');
	Route::get('/{id}/permissions/', 'GroupManagement@selectGroupPermissionsByCondition');
	Route::post('/{id}/permissions/', 'GroupManagement@associateRoleAndPermissions');
	Route::delete('/{gid}/permissions/{pid}/', 'GroupManagement@deleteRoleAndPermissionAssociations');
	Route::get('/{id}/users/', 'GroupManagement@selectGroupUsersByCondition');
	Route::post('/{id}/users/', 'GroupManagement@associateRoleAndUsers');
	Route::delete('/{gid}/users/{uid}/', 'GroupManagement@deleteRoleAndUserAssociations');
});

Route::group([
	'namespace' => 'API\\RBAC\\Administrator',
	'prefix' => 'count',
	'middleware' => 'auth:api',
], function () {
	Route::get('/roles', 'GroupManagement@getPermissionsNumberOfName');
});
