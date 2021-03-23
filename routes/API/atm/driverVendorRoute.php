<?php
// driverVendor
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'driverVendors',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'DriverVendorController@selectByCondition');
	Route::get('/{id}', 'DriverVendorController@selectById');
	Route::delete('/', 'DriverVendorController@deleteByCondition');
	Route::delete('/{id}', 'DriverVendorController@deleteById');
	Route::post('/', 'DriverVendorController@insert');
	Route::put('/', 'DriverVendorController@replace');
	Route::patch('/', 'DriverVendorController@update');

	// DriverProperty By DriverVendorId
	Route::get('/{driverVendorId}/driverProperties', 'DriverVendorController@getDriverPropertyByDriverVendorId');
	Route::delete('/{driverVendorId}/driverProperties', 'DriverVendorController@deleteDriverPropertyByDriverVendorId');
	Route::post('/{driverVendorId}/driverProperties', 'DriverVendorController@insertDriverPropertyByDriverVendorId');
	Route::put('/{driverVendorId}/driverProperties', 'DriverVendorController@replaceDriverPropertyByDriverVendorId');
});
