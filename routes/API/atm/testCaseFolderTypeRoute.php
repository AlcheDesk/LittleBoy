<?php

// testCaseFolderType
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'testCaseFolderTypes',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'TestCaseFolderTypeController@selectByCondition');
	Route::get('/{id}', 'TestCaseFolderTypeController@selectById');
	Route::delete('/', 'TestCaseFolderTypeController@deleteByCondition');
	Route::delete('/{id}', 'TestCaseFolderTypeController@deleteById');
	Route::post('/', 'TestCaseFolderTypeController@insert');
	Route::put('/', 'TestCaseFolderTypeController@replace');
	Route::patch('/', 'TestCaseFolderTypeController@update');
	Route::get('/{testCaseFolderTypeId}/testCaseFolders', 'TestCaseFolderTypeController@getTestCaseFolderByTestCaseFolderTypeId');
});
