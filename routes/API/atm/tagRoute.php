<?php

// tag route
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'tags',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'TagController@selectByCondition');
	Route::get('/{id}', 'TagController@selectById');
	Route::delete('/', 'TagController@deleteByCondition');
	Route::delete('/{id}', 'TagController@deleteById');
	Route::post('/', 'TagController@insert');
	Route::put('/', 'TagController@replace');
	Route::patch('/', 'TagController@update');

	// testCase by tagId
	Route::get('/{tagId}/testCases', 'TagController@getTestCaseByTagId');
	Route::post('/{tagId}/testCases', 'TagController@postTestCaseByTagId');
	Route::delete('/{tagId}/testCases', 'TagController@deleteTestCaseByTagId');
	Route::patch('/{tagId}/testCases', 'TagController@updateTestCaseByTagId');
	Route::put('/{tagId}/testCases', 'TagController@replaceTestCaseByTagId');
	Route::get('/{tagId}/projects', 'TagController@getProjectByTagId');
});
