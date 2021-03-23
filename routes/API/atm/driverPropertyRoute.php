<?php

// driverProperty resources
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'driverProperties',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'DriverPropertyController@selectByCondition');
	Route::get('/{id}', 'DriverPropertyController@selectById');
	Route::delete('/', 'DriverPropertyController@deleteByCondition');
	Route::delete('/{id}', 'DriverPropertyController@deleteById');
	Route::post('/', 'DriverPropertyController@insert');
	Route::put('/', 'DriverPropertyController@replace');
	Route::patch('/', 'DriverPropertyController@update');
	Route::get('/{driverPropertyId}/drivers', 'DriverPropertyController@getDriverByDriverPropertyId');

	// driverPropertyPredefinedValues by driverPropertyId
	Route::get('/{driverPropertyId}/driverPropertyPredefinedValues', 'DriverPropertyController@getDriverPropertyPredefinedValueByDriverPropertyId');
	Route::post('/{driverPropertyId}/driverPropertyPredefinedValues', 'DriverPropertyController@insertDriverPropertyPredefinedValueByDriverPropertyId');
	Route::patch('/{driverPropertyId}/driverPropertyPredefinedValues', 'DriverPropertyController@updateDriverPropertyPredefinedValueByDriverPropertyId');
	Route::put('/{driverPropertyId}/driverPropertyPredefinedValues', 'DriverPropertyController@replaceDriverPropertyPredefinedValueByDriverPropertyId');
	Route::delete('/{driverPropertyId}/driverPropertyPredefinedValues', 'DriverPropertyController@deleteDriverPropertyPredefinedValueByDriverPropertyId');
});
