<?php

// projectType
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'projectTypes',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'ProjectTypeController@selectByCondition');
	Route::get('/{id}', 'ProjectTypeController@selectById');
	Route::delete('/', 'ProjectTypeController@deleteByCondition');
	Route::delete('/{id}', 'ProjectTypeController@deleteById');
	Route::post('/', 'ProjectTypeController@insert');
	Route::put('/', 'ProjectTypeController@replace');
	Route::patch('/', 'ProjectTypeController@update');
	Route::get('/', 'ProjectTypeController@selectByCondition');
});
