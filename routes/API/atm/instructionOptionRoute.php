<?php

// instructionOption resource
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'instructionOptions',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'InstructionOptionController@selectByCondition');
	Route::get('/{id}/', 'InstructionOptionController@selectById');
	Route::delete('/', 'InstructionOptionController@deleteByCondition');
	Route::delete('/{id}/', 'InstructionOptionController@deleteById');
	Route::post('/', 'InstructionOptionController@insert');
	Route::put('/', 'InstructionOptionController@replace');
	Route::patch('/', 'InstructionOptionController@update');
	Route::get('/{instructionOptionId}/instructions', 'InstructionOptionController@getInstructionByInstructionOptionId');
});