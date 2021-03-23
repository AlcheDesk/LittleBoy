<?php

// testCaseOverwrite route
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'testCaseOverwrites',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'TestCaseOverwriteController@selectByCondition');
	Route::get('/{id}', 'TestCaseOverwriteController@selectById');
	Route::delete('/', 'TestCaseOverwriteController@deleteByCondition');
	Route::delete('/{id}', 'TestCaseOverwriteController@deleteById');
	Route::post('/', 'TestCaseOverwriteController@insert');
	Route::put('/', 'TestCaseOverwriteController@replace');
	Route::patch('/', 'TestCaseOverwriteController@update');

	// instructionOverwrite by testCaseOverwriteId
	Route::get('/{testCaseOverwriteId}/instructionOverwrites', 'TestCaseOverwriteController@getInstructionOverwriteByTestCaseOverwriteId');
	Route::post('/{testCaseOverwriteId}/instructionOverwrites', 'TestCaseOverwriteController@postInstructionOverwriteByTestCaseOverwriteId');
	Route::delete('/{testCaseOverwriteId}/instructionOverwrites', 'TestCaseOverwriteController@deleteInstructionOverwriteByTestCaseOverwriteId');
	Route::patch('/{testCaseOverwriteId}/instructionOverwrites', 'TestCaseOverwriteController@updateInstructionOverwriteByTestCaseOverwriteId');
	Route::put('/{testCaseOverwriteId}/instructionOverwrites', 'TestCaseOverwriteController@replaceInstructionOverwriteByTestCaseOverwriteId');
});
