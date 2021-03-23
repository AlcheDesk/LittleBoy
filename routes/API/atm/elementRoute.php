
<?php

// element
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'elements',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'ElementController@selectByCondition');
	Route::get('/{id}', 'ElementController@selectById');
	Route::delete('/', 'ElementController@deleteByCondition');
	Route::delete('/{id}', 'ElementController@deleteById');
	Route::post('/', 'ElementController@insert');
	Route::put('/', 'ElementController@replace');
	Route::patch('/', 'ElementController@update');
	Route::get('/{elementId}/instructionActions', 'ElementController@getInstructionActionByElementId');
	Route::get('/{elementId}/sections', 'ElementController@getSectionByElementId');
});
