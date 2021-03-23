<?php

// projects
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'testCaseShareFolders',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'FolderController@selectByCondition');
	Route::get('/{id}', 'FolderController@selectById');
	Route::delete('/', 'FolderController@deleteByCondition');
	Route::delete('/{id}', 'FolderController@deleteById');
	Route::post('/', 'FolderController@insert');
	Route::put('/', 'FolderController@replace');
	Route::patch('/', 'FolderController@update');

	// TestCase By FolderId
	Route::get('/{folderId}/testCaseShareFolderTestCaseLinks', 'FolderController@getTestCaseByFolderId');
	Route::post('/{folderId}/testCases', 'FolderController@insertTestCaseByFolderId');

});

Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'testCaseShareFolderTestCaseLinks',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::delete('/{id}', 'FolderController@deleteTestCaseByFolderId');
	Route::put('/', 'FolderController@replaceTestCaseByFolderId');

});
