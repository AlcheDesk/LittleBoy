<?php

//task route
Route::group([
	'namespace' => 'API\\EMS\\',
	'prefix' => 'tasks',
	'middleware' => [
		'auth:api',
	],
], function () {
	Route::get('/', 'TaskController@selectByCondition');
	Route::get('/{uuid}', 'TaskController@selectByUuid');
	Route::delete('/', 'TaskController@deleteByCondition');
	Route::delete('/{uuid}', 'TaskController@deleteByUuid');
	Route::post('/', 'TaskController@insert');
	Route::put('/', 'TaskController@replace');
	Route::patch('/', 'TaskController@update');
});
