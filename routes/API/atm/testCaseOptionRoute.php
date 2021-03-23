<?php

// testCaseOption
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'testCaseOptions',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'TestCaseOptionController@selectByCondition');
	Route::get('/{id}', 'TestCaseOptionController@selectById');
	Route::delete('/', 'TestCaseOptionController@deleteByCondition');
	Route::delete('/{id}', 'TestCaseOptionController@deleteById');
	Route::post('/', 'TestCaseOptionController@insert');
	Route::put('/', 'TestCaseOptionController@replace');
	Route::patch('/', 'TestCaseOptionController@update');
	Route::get('/{testCaseOptionId}/testCases', 'TestCaseOptionController@getTestCaseByTestCaseOptionId');
});
