<?php

// driver
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'drivers',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'DriverController@selectByCondition');
	Route::get('/{id}', 'DriverController@selectById');
	Route::delete('/', 'DriverController@deleteByCondition');
	Route::delete('/{id}', 'DriverController@deleteById');
	Route::post('/', 'DriverController@insert');
	Route::put('/', 'DriverController@replace');
	Route::patch('/', 'DriverController@update');

	// driverProperties by driverId
	Route::get('/{driverId}/driverProperties', 'DriverController@getDriverPropertyByDriverId');
	Route::post('/{driverId}/driverProperties', 'DriverController@insertDriverPropertyByDriverId');
	Route::put('/{driverId}/driverProperties', 'DriverController@replaceDriverPropertyByDriverId');
	Route::delete('/{driverId}/driverProperties', 'DriverController@deleteDriverPropertyByDriverId');
	Route::get('/{driverId}/testCases', 'DriverController@getTestCaseByDriverId');
});
