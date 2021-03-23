<?php
// properties
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'properties',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'PropertyController@selectByCondition');
	Route::get('/{id}', 'PropertyController@selectById');
	Route::delete('/', 'PropertyController@deleteByCondition');
	Route::delete('/{id}', 'PropertyController@deleteById');
	Route::post('/', 'PropertyController@insert');
	Route::put('/', 'PropertyController@replace');
	Route::patch('/', 'PropertyController@update');
});
