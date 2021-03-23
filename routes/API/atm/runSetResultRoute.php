<?php

// runSetResult
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'runSetResults',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'RunSetResultController@selectByCondition');
	Route::get('/{id}', 'RunSetResultController@selectById');
	Route::delete('/', 'RunSetResultController@deleteByCondition');
	Route::delete('/{id}', 'RunSetResultController@deleteById');
	Route::post('/', 'RunSetResultController@insert');
	Route::put('/', 'RunSetResultController@replace');
	Route::patch('/', 'RunSetResultController@update');

	Route::get('/{runSetResultId}/runs', 'RunSetResultController@getTestCaseByRunSetId');
	Route::delete('/{runSetResultId}/runs', 'RunSetResultController@deleteTestCaseByRunSetId');
	Route::post('/{runSetResultId}/runs', 'RunSetResultController@insertTestCaseByRunSetId');
	Route::put('/{runSetResultId}/runs', 'RunSetResultController@replaceTestCaseByRunSetId');

	//runExecutionInfo
	Route::get('/{runSetResultId}/runExecutionInfo', 'RunSetResultController@getRunExecutionInfoByRunSetResultId');
});
