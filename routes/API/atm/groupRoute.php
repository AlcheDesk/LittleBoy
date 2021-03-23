<?php

// group
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'groups',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'GroupController@selectByCondition');
	Route::get('/{id}', 'GroupController@selectById');
	Route::delete('/', 'GroupController@deleteByCondition');
	Route::delete('/{id}', 'GroupController@deleteById');
	Route::post('/', 'GroupController@insert');
	Route::put('/', 'GroupController@replace');
	Route::patch('/', 'GroupController@update');
});
