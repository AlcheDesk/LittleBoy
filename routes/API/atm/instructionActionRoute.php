<?php

// instructionAction
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'instructionActions',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'InstructionActionController@selectByCondition');
	Route::get('/{id}', 'InstructionActionController@selectById');
	Route::delete('/', 'InstructionActionController@deleteByCondition');
	Route::delete('/{id}', 'InstructionActionController@deleteById');
	Route::post('/', 'InstructionActionController@insert');
	Route::put('/', 'InstructionActionController@replace');
	Route::patch('/', 'InstructionActionController@update');

	// elementTypes by instructionActionId
	Route::get('/{instructionActionId}/elementTypes', 'InstructionActionController@getElementTypeByInstructionActionId');

	// instructionOptions by instructionActionId
	Route::get('/{instructionActionId}/instructionOptions', 'InstructionActionController@getInstructionOptionByInstructionActionId');
});