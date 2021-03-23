<?php

// driverPack
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'driverPacks',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'DriverPackController@selectByCondition');
	Route::get('/{id}', 'DriverPackController@selectById');
	Route::delete('/', 'DriverPackController@deleteByCondition');
	Route::delete('/{id}', 'DriverPackController@deleteById');
	Route::post('/', 'DriverPackController@insert');
	Route::put('/', 'DriverPackController@replace');
	Route::patch('/', 'DriverPackController@update');

	// drivers by driverPack
	Route::get('/{driverPackId}/drivers', 'DriverPackController@getDriverByDriverPackId');
	Route::delete('/{driverPackId}/drivers', 'DriverPackController@deleteDriverByDriverPackId');
	Route::post('/{driverPackId}/drivers', 'DriverPackController@insertDriverByDriverPackId');
	Route::patch('/{driverPackId}/drivers', 'DriverPackController@updateDriverByDriverPackId');
	Route::put('/{driverPackId}/drivers', 'DriverPackController@replaceDriverByDriverPackId');
});
