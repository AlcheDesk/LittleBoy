<?php

// elementLocatorType resources
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'elementLocatorTypes',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'ElementLocatorTypeController@selectByCondition');
	Route::get('/{id}', 'ElementLocatorTypeController@selectById');
	Route::delete('/', 'ElementLocatorTypeController@deleteByCondition');
	Route::delete('/{id}', 'ElementLocatorTypeController@deleteById');
	Route::post('/', 'ElementLocatorTypeController@insert');
	Route::put('/', 'ElementLocatorTypeController@replace');
	Route::patch('/', 'ElementLocatorTypeController@update');
	Route::get('/{elementLocatorTypeId}/elementTypes', 'ElementLocatorTypeController@getElementTypeByElementLocatorTypeId');
});
