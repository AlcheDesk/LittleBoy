<?php

// runs
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'runs',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'RunController@selectByCondition');
	Route::get('/{id}', 'RunController@selectById');
	Route::post('/', 'RunController@insert');
	Route::put('/', 'RunController@replace');
	Route::patch('/', 'RunController@update');

	Route::get('/{runId}/instructionResults', 'RunController@getInstructionResultByRunId');
	Route::post('/{runId}/instructionResults', 'RunController@insertInstructionResultByRunId');
	Route::patch('/{runId}/instructionResults', 'RunController@updateInstructionResultByRunId');

	Route::get('/{runId}/executionLogs', 'RunController@getExecutionLogByRunId');
	Route::post('/{runId}/executionLogs', 'RunController@insertExecutionLogByRunId');
	Route::patch('/{runId}/executionLogs', 'RunController@updateExecutionLogByRunId');

	Route::get('/{runId}/tasks', 'RunController@getTaskByRunId');
});

Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'runExecutionInfo',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/{id}', 'RunController@selectExecutionInfoById');
});
