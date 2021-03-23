<?php

// tag route
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'testCaseTypes',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'TestCaseTypeController@selectByCondition');
});
