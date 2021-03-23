<?php

// instructionTypes resource
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'instructionTypes',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'InstructionTypeController@selectByCondition');
	Route::get('/{id}', 'InstructionTypeController@selectById');
	Route::delete('/', 'InstructionTypeController@deleteByCondition');
	Route::delete('/{id}', 'InstructionTypeController@deleteById');
	Route::post('/', 'InstructionTypeController@insert');
	Route::put('/', 'InstructionTypeController@replace');
	Route::patch('/', 'InstructionTypeController@update');
	Route::get('/{instructionTypeId}/instructions', 'InstructionTypeController@getInstructionByInstructionTypeId');
	Route::get('/{instructionTypeId}/elementTypes', 'InstructionTypeController@getElementTypeByInstructionTypeId');
	Route::get('/{instructionTypeId}/instructionActions', 'InstructionTypeController@getInstructionActionByInstructionTypeId');
});
