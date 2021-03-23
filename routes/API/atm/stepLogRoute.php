<?php

// stepLog
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'stepLogs',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'StepLogController@selectByCondition');
	Route::get('/{id}', 'StepLogController@selectById');
	Route::post('/', 'StepLogController@insert');
	Route::put('/', 'StepLogController@replace');
	Route::patch('/', 'StepLogController@update');
	Route::get('/{stepLogId}/instructionResults', 'StepLogController@getInstructionResultByStepLogId');
});
