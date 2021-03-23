<?php

// driverType
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'driverTypes',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'DriverTypeController@selectByCondition');
	Route::get('/{id}', 'DriverTypeController@selectById');
	Route::delete('/', 'DriverTypeController@deleteByCondition');
	Route::delete('/{id}', 'DriverTypeController@deleteById');
	Route::post('/', 'DriverTypeController@insert');
	Route::put('/', 'DriverTypeController@replace');
	Route::patch('/', 'DriverTypeController@update');

	// DriverVendor By DriverTypeId
	Route::get('/{driverTypeId}/driverVendors', 'DriverTypeController@getDriverVendorByDriverTypeId');
	Route::delete('/{driverTypeId}/driverVendors', 'DriverTypeController@deleteDriverVendorByDriverTypeId');
	Route::post('/{driverTypeId}/driverVendors', 'DriverTypeController@insertDriverVendorByDriverTypeId');
	Route::put('/{driverTypeId}/driverVendors', 'DriverTypeController@replaceDriverVendorByDriverTypeId');

	// Driver By DriverTypeId
	Route::get('/{driverTypeId}/drivers', 'DriverTypeController@getTestCaseByDriverTypeId');
	Route::delete('/{driverTypeId}/drivers', 'DriverTypeController@deleteTestCaseByDriverTypeId');
	Route::post('/{driverTypeId}/drivers', 'DriverTypeController@insertTestCaseByDriverTypeId');
	Route::put('/{driverTypeId}/drivers', 'DriverTypeController@replaceTestCaseByDriverTypeId');
});
