<?php

// testCases route
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'testCases',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'TestCaseController@selectByCondition');
	Route::get('/{id}', 'TestCaseController@selectById');
	Route::delete('/', 'TestCaseController@deleteByCondition');
	Route::delete('/{id}', 'TestCaseController@deleteById');
	Route::post('/', 'TestCaseController@insert');
	Route::put('/', 'TestCaseController@replace');
	Route::patch('/', 'TestCaseController@update');

	// instructions by testCase
	Route::get('/{testCaseId}/instructions', 'TestCaseController@getInstructionByTestCaseId');
	Route::delete('/{testCaseId}/instructions', 'TestCaseController@deleteInstructionByTestCaseId');
	Route::post('/{testCaseId}/instructions', 'TestCaseController@insertInstructionByTestCaseId');
	Route::patch('/{testCaseId}/instructions', 'TestCaseController@updateInstructionByTestCaseId');

	// storages by testCase
	Route::get('/{testCaseId}/storages', 'TestCaseController@getStorageByTestCaseId');
	Route::delete('/{testCaseId}/storages', 'TestCaseController@deleteStorageByTestCaseId');
	Route::post('/{testCaseId}/storages', 'TestCaseController@insertStorageByTestCaseId');
	Route::patch('/{testCaseId}/storages', 'TestCaseController@updateStorageByTestCaseId');
	Route::put('/{testCaseId}/storages', 'TestCaseController@replaceStorageByTestCaseId');

	// drivers by testCase
	Route::get('/{testCaseId}/drivers', 'TestCaseController@getDriverByTestCaseId');
	Route::delete('/{testCaseId}/drivers', 'TestCaseController@deleteDriverByTestCaseId');
	Route::post('/{testCaseId}/drivers', 'TestCaseController@insertDriverByTestCaseId');
	Route::patch('/{testCaseId}/drivers', 'TestCaseController@updateDriverByTestCaseId');
	Route::put('/{testCaseId}/drivers', 'TestCaseController@replaceDriverByTestCaseId');

	// systemRequirements by testCase
	Route::get('/{testCaseId}/systemRequirements', 'TestCaseController@getSystemRequirementByTestCaseId');
	Route::delete('/{testCaseId}/systemRequirements', 'TestCaseController@deleteSystemRequirementByTestCaseId');
	Route::post('/{testCaseId}/systemRequirements', 'TestCaseController@insertSystemRequirementByTestCaseId');
	Route::patch('/{testCaseId}/systemRequirements', 'TestCaseController@updateSystemRequirementByTestCaseId');
	Route::put('/{testCaseId}/systemRequirements', 'TestCaseController@replaceSystemRequirementByTestCaseId');

	// testCaseOptions by testCase
	Route::get('/{testCaseId}/testCaseOptions', 'TestCaseController@getTestCaseOptionByTestCaseId');
	Route::delete('/{testCaseId}/testCaseOptions', 'TestCaseController@deleteTestCaseOptionByTestCaseId');
	Route::post('/{testCaseId}/testCaseOptions', 'TestCaseController@insertTestCaseOptionByTestCaseId');
	Route::patch('/{testCaseId}/testCaseOptions', 'TestCaseController@updateTestCaseOptionByTestCaseId');
	Route::put('/{testCaseId}/testCaseOptions', 'TestCaseController@replaceTestCaseOptionByTestCaseId');

	// runs by testCase
	Route::get('/{testCaseId}/runs', 'TestCaseController@getRunByTestCaseId');
	Route::delete('/{testCaseId}/runs', 'TestCaseController@deleteRunByTestCaseId');
	Route::post('/{testCaseId}/runs', 'TestCaseController@insertRunByTestCaseId');
	Route::patch('/{testCaseId}/runs', 'TestCaseController@updateRunByTestCaseId');
	Route::put('/{testCaseId}/runs', 'TestCaseController@replaceRunByTestCaseId');

	Route::put('/{testCaseId}/runs/{runId}', 'TestCaseController@replaceRunByTestCaseIdAndRunId');
	Route::delete('/{testCaseId}/runs/{runId}', 'TestCaseController@deleteRunByTestCaseIdAndRunId');

	// tags by testCase
	Route::get('/{testCaseId}/tags', 'TestCaseController@getTagByTestCaseId');
	Route::delete('/{testCaseId}/tags', 'TestCaseController@deleteTagByTestCaseId');
	Route::post('/{testCaseId}/tags', 'TestCaseController@insertTagByTestCaseId');
	Route::patch('/{testCaseId}/tags', 'TestCaseController@updateTagByTestCaseId');
	Route::put('/{testCaseId}/tags', 'TestCaseController@replaceTagByTestCaseId');

	// others by testCase
	Route::get('/{testCaseId}/testCaseFolders', 'TestCaseController@getTestCaseFolderByTestCaseId');
	Route::get('/{testCaseId}/projects', 'TestCaseController@getProjectByTestCaseId');
	Route::get('/{testCaseId}/runSets', 'TestCaseController@getRunSetByTestCaseId');
	Route::get('/{testCaseId}/tasks', 'TestCaseController@getTaskByTestCaseId');
	Route::get('/{testCaseId}/driverPacks', 'TestCaseController@getDriverPackByTestCaseId');

	// Route::get('/{testCaseId}/executionDriverMaps', 'TestCaseController@getExecutionDriverMapByTestCaseId');
	Route::get('/{testCaseId}/driverTypes', 'TestCaseController@getExecutionDriverMapByTestCaseId');

	Route::get('/{testCaseId}/instructionOverwrites', 'TestCaseController@getInstructionOverwriteByTestCaseId');
	Route::get('/{testCaseId}/testCaseOverwrites', 'TestCaseController@getTestCaseOverwriteByTestCaseId');
	Route::post('/{testCaseId}/testCaseOverwrites', 'TestCaseController@insertTestCaseOverwriteByTestCaseId');

	//runExecutionInfo
	Route::get('/{testCaseId}/runExecutionInfo/', 'TestCaseController@getRunExecutionInfoByTestCaseId');
});