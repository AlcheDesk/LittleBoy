<?php

// runSet
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'emailNotificationTargets',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'EmailNotificationTargetController@selectByCondition');
	Route::delete('/{id}', 'EmailNotificationTargetController@deleteById');
	Route::post('/', 'EmailNotificationTargetController@insert');
	Route::patch('/', 'EmailNotificationTargetController@update');
});