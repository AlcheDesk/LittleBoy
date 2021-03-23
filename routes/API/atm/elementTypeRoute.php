<?php

// elementTypes
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'elementTypes',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'ElementTypeController@selectByCondition');
	Route::get('/{id}', 'ElementTypeController@selectById');
	Route::delete('/', 'ElementTypeController@deleteByCondition');
	Route::delete('/{id}', 'ElementTypeController@deleteById');
	Route::post('/', 'ElementTypeController@insert');
	Route::put('/', 'ElementTypeController@replace');
	Route::patch('/', 'ElementTypeController@update');

	// elements by elementTypes
	Route::get('/{elementTypeId}/elements', 'ElementTypeController@getElementByElementTypeId');

	// instructionActions by elementTypes
	Route::get('/{elementTypeId}/instructionActions', 'ElementTypeController@getInstructionActionByElementTypeId');
	Route::delete('/{elementTypeId}/instructionActions', 'ElementTypeController@deleteInstructionActionByElementTypeId');
	Route::post('/{elementTypeId}/instructionActions', 'ElementTypeController@insertInstructionActionByElementTypeId');
	Route::put('/{elementTypeId}/instructionActions', 'ElementTypeController@replaceInstructionActionByElementTypeId');

	// elementLocatorTypes by elementTypes
	Route::get('/{elementTypeId}/elementLocatorTypes', 'ElementTypeController@getElementLocatorTypeByElementTypeId');
	Route::delete('/{elementTypeId}/elementLocatorTypes', 'ElementTypeController@deleteElementLocatorTypeByElementTypeId');
	Route::post('/{elementTypeId}/elementLocatorTypes', 'ElementTypeController@insertElementLocatorTypeByElementTypeId');
	Route::put('/{elementTypeId}/elementLocatorTypes', 'ElementTypeController@replaceElementLocatorTypeByElementTypeId');

	// instructionOptions by elementTypes
	Route::get('/{elementTypeId}/instructionOptions', 'ElementTypeController@getInstructionNptionsTypeByElementTypeId');
	Route::delete('/{elementTypeId}/instructionOptions', 'ElementTypeController@deleteInstructionNptionsTypeByElementTypeId');
	Route::post('/{elementTypeId}/instructionOptions', 'ElementTypeController@insertInstructionNptionsTypeByElementTypeId');
	Route::put('/{elementTypeId}/instructionOptions', 'ElementTypeController@replaceInstructionNptionsTypeByElementTypeId');
});
