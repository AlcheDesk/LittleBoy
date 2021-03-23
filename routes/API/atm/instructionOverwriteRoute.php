<?php

// instructionOverwrite route
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'instructionOverwrites',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'InstructionOverwriteController@selectByCondition');
	Route::get('/{id}', 'InstructionOverwriteController@selectById');
	Route::delete('/', 'InstructionOverwriteController@deleteByCondition');
	Route::delete('/{id}', 'InstructionOverwriteController@deleteById');
	Route::post('/', 'InstructionOverwriteController@insert');
	Route::put('/', 'InstructionOverwriteController@replace');
	Route::patch('/', 'InstructionOverwriteController@update');

	// testCaseOverwrite by instructionOverwriteId
	Route::get('/{instructionOverwriteId}/testCaseOverwrites', 'InstructionOverwriteController@getTestCaseOverwriteByInstructionOverwriteId');
});
