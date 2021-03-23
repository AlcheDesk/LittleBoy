<?php

// instructionBundles
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'instructionBundles',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'InstructionBundleController@selectByCondition');
	Route::get('/{id}', 'InstructionBundleController@selectById');
	Route::delete('/{id}', 'InstructionBundleController@deleteById');
	Route::post('/', 'InstructionBundleController@insert');
	Route::patch('/', 'InstructionBundleController@update');

	Route::get('/{bundleId}/instructionBundleEntries', 'InstructionBundleController@getInstructionBundleEntryByBundleId');
	Route::post('/{bundleId}/instructionBundleEntries', 'InstructionBundleController@insertInstructionBundleEntryByBundleId');
});

// instructionBundleEntries
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'instructionBundleEntries',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::delete('/{id}', 'InstructionBundleController@deleteInstructionBundleEntryByBundleId');
	Route::patch('/', 'InstructionBundleController@updateInstructionBundleEntry');
});