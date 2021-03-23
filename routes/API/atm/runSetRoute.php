<?php

// runSet
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'runSets',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'RunSetController@selectByCondition');
	Route::get('/{id}', 'RunSetController@selectById');
	Route::delete('/', 'RunSetController@deleteByCondition');
	Route::delete('/{id}', 'RunSetController@deleteById');
	Route::post('/', 'RunSetController@insert');
	Route::put('/', 'RunSetController@replace');
	Route::patch('/', 'RunSetController@update');

	Route::get('/{runSetId}/runSetTestCaseLinks', 'RunSetController@getTestCaseByRunSetId');
	Route::delete('/{runSetId}/runSetTestCaseLinks', 'RunSetController@deleteTestCaseByRunSetId');
	Route::post('/{runSetId}/runSetTestCaseLinks', 'RunSetController@insertTestCaseByRunSetId');
	Route::put('/{runSetId}/runSetTestCaseLinks', 'RunSetController@replaceTestCaseByRunSetId');
	Route::get('/{runSetId}/aliases', 'RunSetController@getAliasByRunSetId');
	Route::delete('/{runSetId}/aliases', 'RunSetController@deleteAliasByRunSetId');
	Route::post('/{runSetId}/aliases', 'RunSetController@insertAliasByRunSetId');
	Route::put('/{runSetId}/aliases', 'RunSetController@replaceAliasByRunSetId');
	// Route::get('/{runSetId}/executionDriverMaps', 'RunSetController@getExecutionDriverMapByRunSetId');

	Route::get('/{runSetId}/driverTypes', 'RunSetController@getExecutionDriverMapByRunSetId');

	Route::get('/{runSetId}/notifications', 'RunSetController@getNotificationByRunSetId');
	Route::put('/{runSetId}/notifications', 'RunSetController@replaceNotificationByRunSetId');
	Route::delete('/{runSetId}/notifications', 'RunSetController@deleteNotificationByRunSetId');
});

// runSetTestCaseLinks
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'runSetTestCaseLinks',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::delete('/{testCaseId}', 'RunSetController@deleteTestCaseLinkByRunSetId');
	Route::put('/', 'RunSetController@replaceTestCaseLinkByRunSetId');
});