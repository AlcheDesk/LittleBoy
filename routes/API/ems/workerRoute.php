<?php

//worker route
Route::group([
	'namespace' => 'API\\EMS\\',
	'prefix' => 'workers',
	'middleware' => [
		'auth:api',
	],
], function () {
	Route::get('/', 'WorkerController@selectByCondition');
	Route::get('/{uuid}', 'WorkerController@selectByUuid');
	Route::delete('/', 'WorkerController@deleteByCondition');
	Route::delete('/{uuid}', 'WorkerController@deleteByUuid');
	Route::post('/', 'WorkerController@insert');
	Route::put('/', 'WorkerController@replace');
	Route::patch('/', 'WorkerController@update');
});
