<?php

// instruction
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'instructions',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'InstructionController@selectByCondition');
	Route::get('/{id}', 'InstructionController@selectById');
	Route::delete('/', 'InstructionController@deleteByCondition');
	Route::delete('/{id}', 'InstructionController@deleteById');
	Route::post('/', 'InstructionController@insert');
	Route::put('/', 'InstructionController@replace');
	Route::patch('/', 'InstructionController@update');

	// instructionOptions by instruction
	Route::get('/{instructionId}/instructionOptions', 'InstructionController@getInstructionOptionByInstructionId');
	Route::delete('/{instructionId}/instructionOptions', 'InstructionController@deleteInstructionOptionByInstructionId');
	Route::post('/{instructionId}/instructionOptions', 'InstructionController@insertInstructionOptionByInstructionId');
	Route::put('/{instructionId}/instructionOptions', 'InstructionController@replaceInstructionOptionByInstructionId');
	Route::patch('/{instructionId}/instructionOptions', 'InstructionController@updateInstructionOptionByInstructionId');
	Route::get('/{instructionId}/testCases', 'InstructionController@getTestCaseByInstructionId');
});
