<?php

// driverEntry
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'driverEntrys',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'DriverEntryController@selectByCondition');
	Route::get('/{id}', 'DriverEntryController@selectById');
	Route::delete('/', 'DriverEntryController@deleteByCondition');
	Route::delete('/{id}', 'DriverEntryController@deleteById');
	Route::post('/', 'DriverEntryController@insert');
	Route::put('/', 'DriverEntryController@replace');
	Route::patch('/', 'DriverEntryController@update');
});
