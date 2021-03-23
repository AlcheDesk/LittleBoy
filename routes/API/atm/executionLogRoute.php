<?php

// executionLog
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'executionLogs',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'ExecutionLogController@selectByCondition');
	Route::get('/{id}', 'ExecutionLogController@selectById');
	Route::post('/', 'ExecutionLogController@insert');
	Route::put('/', 'ExecutionLogController@replace');
	Route::patch('/', 'ExecutionLogController@update');
	Route::get('/{executionLogId}/instructionResults', 'ExecutionLogController@getInstructionResultByExecutionLogId');
	Route::get('/{executionLogId}/runs', 'ExecutionLogController@getRunByExecutionLogId');
});
