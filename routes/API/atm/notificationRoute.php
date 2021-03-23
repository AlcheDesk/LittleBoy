<?php

// runSet
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'notifications',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'NotificationController@selectByCondition');
	Route::delete('/{id}', 'NotificationController@deleteById');
	Route::post('/', 'NotificationController@insert');
	Route::patch('/', 'NotificationController@update');
});