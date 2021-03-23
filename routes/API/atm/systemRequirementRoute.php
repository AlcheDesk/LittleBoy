<?php

// systemRequirement
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'systemRequirements',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'SystemRequirementController@selectByCondition');
	Route::get('/{id}', 'SystemRequirementController@selectById');
	Route::delete('/', 'SystemRequirementController@deleteByCondition');
	Route::delete('/{id}', 'SystemRequirementController@deleteById');
	Route::post('/', 'SystemRequirementController@insert');
	Route::put('/', 'SystemRequirementController@replace');
	Route::patch('/', 'SystemRequirementController@update');
	Route::get('/{systemRequirementId}/testCases', 'SystemRequirementController@getTestCaseBySystemRequirementId');
});
