<?php

// driverPropertyPredefinedValue
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'driverPropertyPredefinedValues',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'DriverPropertyPredefinedValueController@selectByCondition');
	Route::get('/{id}', 'DriverPropertyPredefinedValueController@selectById');
	Route::delete('/', 'DriverPropertyPredefinedValueController@deleteByCondition');
	Route::delete('/{id}', 'DriverPropertyPredefinedValueController@deleteById');
	Route::post('/', 'DriverPropertyPredefinedValueController@insert');
	Route::put('/', 'DriverPropertyPredefinedValueController@replace');
	Route::patch('/', 'DriverPropertyPredefinedValueController@update');
});
