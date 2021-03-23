<?php

// testCaseFolder
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'testCaseFolders',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'TestCaseFolderController@selectByCondition');
	Route::get('/{id}', 'TestCaseFolderController@selectById');
	Route::delete('/', 'TestCaseFolderController@deleteByCondition');
	Route::delete('/{id}', 'TestCaseFolderController@deleteById');
	Route::post('/', 'TestCaseFolderController@insert');
	Route::put('/', 'TestCaseFolderController@replace');
	Route::patch('/', 'TestCaseFolderController@update');

	// testCase by testCaseFolder
	Route::get('/{testCaseFolderId}/testCases', 'TestCaseFolderController@getTestCaseByTestCaseFolderId');
	Route::delete('/{testCaseFolderId}/testCases', 'TestCaseFolderController@deleteTestCaseByTestCaseFolderId');
	Route::post('/{testCaseFolderId}/testCases', 'TestCaseFolderController@insertTestCaseByTestCaseFolderId');
	Route::put('/{testCaseFolderId}/testCases', 'TestCaseFolderController@replaceTestCaseByTestCaseFolderId');
});
