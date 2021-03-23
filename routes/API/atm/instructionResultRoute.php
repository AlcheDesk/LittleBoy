<?php

// instructionResults
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'instructionResults',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'InstructionResultController@selectByCondition');
	Route::get('/{id}', 'InstructionResultController@selectById');
	Route::post('/', 'InstructionResultController@insert');
	Route::put('/', 'InstructionResultController@replace');
	Route::patch('/', 'InstructionResultController@update');

	// file by InstructionResult
	Route::get('/{instructionResultId}/files', 'InstructionResultController@getFileByInstructionResultId');
	Route::post('/{instructionResultId}/files', 'InstructionResultController@insertFileByInstructionResultId');
	Route::patch('/{instructionResultId}/files', 'InstructionResultController@updateFileByInstructionResultId');

	// stepLogs by InstructionResult
	Route::get('/{instructionResultId}/stepLogs', 'InstructionResultController@getStepLogByInstructionResultId');
	Route::post('/{instructionResultId}/stepLogs', 'InstructionResultController@insertStepLogByInstructionResultId');
	Route::patch('/{instructionResultId}/stepLogs', 'InstructionResultController@updateStepLogByInstructionResultId');

	// executionLogs by InstructionResult
	Route::get('/{instructionResultId}/executionLogs', 'InstructionResultController@getExecutionLogByInstructionResultId');
	Route::post('/{instructionResultId}/executionLogs', 'InstructionResultController@insertExecutionLogByInstructionResultId');
	Route::patch('/{instructionResultId}/executionLogs', 'InstructionResultController@updateExecutionLogByInstructionResultId');
	Route::get('/{instructionResultId}/runs', 'InstructionResultController@getRunByInstructionResultId');
});
