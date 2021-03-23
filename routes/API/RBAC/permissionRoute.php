<?php

Route::group([
	'namespace' => 'API\\RBAC\\Administrator',
	'prefix' => 'permissions',
	'middleware' => 'auth:api',
], function () {
	Route::get('/', 'AuthManagement@selectByCondition');
	Route::delete('/{id}/', 'AuthManagement@destroy');
	Route::post('/', 'AuthManagement@insert');
	Route::patch('/', 'AuthManagement@update');
	Route::get('/{id}/message/', 'AuthManagement@getUserAndRoleMessage');
});

Route::group([
	'namespace' => 'API\\RBAC\\Administrator',
	'prefix' => 'count',
	'middleware' => 'auth:api',
], function () {
	Route::get('/permissions', 'AuthManagement@getPermissionsNumberOfName');
});
