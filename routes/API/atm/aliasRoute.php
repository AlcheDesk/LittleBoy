<?php

// aliases
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'aliases',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'AliasController@selectByCondition');
	Route::get('/{id}', 'AliasController@selectById');
	Route::delete('/', 'AliasController@deleteByCondition');
	Route::delete('/{id}', 'AliasController@deleteById');
	Route::post('/', 'AliasController@insert');
	Route::put('/', 'AliasController@replace');
	Route::patch('/', 'AliasController@update');

	// RunSet By AliasId
	Route::get('/{aliasId}/runSets', 'AliasController@getRunSetByAliasId');
	Route::delete('/{aliasId}/runSets', 'AliasController@deleteRunSetByAliasId');
	Route::post('/{aliasId}/runSets', 'AliasController@insertRunSetByAliasId');
	Route::put('/{aliasId}/runSets', 'AliasController@replaceRunSetByAliasId');
});
