<?php

// tag route
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'systemRequirementPacks',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'SystemRequirementPacksController@selectByCondition');
	Route::get('/{id}', 'SystemRequirementPacksController@selectById');
	Route::delete('/', 'SystemRequirementPacksController@deleteByCondition');
	Route::delete('/{id}', 'SystemRequirementPacksController@deleteById');
	Route::post('/', 'SystemRequirementPacksController@insert');
	Route::put('/', 'SystemRequirementPacksController@replace');
	Route::patch('/', 'SystemRequirementPacksController@update');


	Route::get('/{systemRequirementPackId}/systemRequirements', 'SystemRequirementPacksController@getSystemRequirementsBySystemRequirementPackId');
	Route::delete('/{systemRequirementPackId}/systemRequirements', 'SystemRequirementPacksController@deleteSystemRequirementsBySystemRequirementPackId');
	Route::post('/{systemRequirementPackId}/systemRequirements', 'SystemRequirementPacksController@insertSystemRequirementsBySystemRequirementPackId');
	Route::put('/{systemRequirementPackId}/systemRequirements', 'SystemRequirementPacksController@replaceSystemRequirementsBySystemRequirementPackId');
});