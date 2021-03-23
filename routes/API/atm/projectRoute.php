<?php

// projects
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'projects',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'ProjectController@selectByCondition');
	Route::get('/{id}', 'ProjectController@selectById');
	Route::delete('/', 'ProjectController@deleteByCondition');
	Route::delete('/{id}', 'ProjectController@deleteById');
	Route::post('/', 'ProjectController@insert');
	Route::put('/', 'ProjectController@replace');
	Route::patch('/', 'ProjectController@update');

	// Application By ProjectId
	Route::get('/{projectId}/applications', 'ProjectController@getApplicationByProjectId');
	Route::delete('/{projectId}/applications', 'ProjectController@deleteApplicationByProjectId');
	Route::post('/{projectId}/applications', 'ProjectController@insertApplicationByProjectId');
	Route::put('/{projectId}/applications', 'ProjectController@replaceApplicationByProjectId');

	// TestCase By ProjectId
	Route::get('/{projectId}/testCases', 'ProjectController@getTestCaseByProjectId');
	Route::delete('/{projectId}/testCases', 'ProjectController@deleteTestCaseByProjectId');
	Route::post('/{projectId}/testCases', 'ProjectController@insertTestCaseByProjectId');
	Route::put('/{projectId}/testCases', 'ProjectController@replaceTestCaseByProjectId');

	// apiElement By ProjectId
	Route::get('/{projectId}/elements', 'ProjectController@getElementByProjectId');
	Route::delete('/{projectId}/elements', 'ProjectController@deleteElementByProjectId');
	Route::post('/{projectId}/elements', 'ProjectController@insertElementByProjectId');
	Route::put('/{projectId}/elements', 'ProjectController@replaceElementByProjectId');
});
