<?php

// fileType
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'fileTypes',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'FileTypeController@selectByCondition');
	Route::get('/{id}', 'FileTypeController@selectById');
	Route::delete('/', 'FileTypeController@deleteByCondition');
	Route::delete('/{id}', 'FileTypeController@deleteById');
	Route::post('/', 'FileTypeController@insert');
	Route::put('/', 'FileTypeController@replace');
	Route::patch('/', 'FileTypeController@update');
	Route::get('/{fileTypeId}/files', 'FileTypeController@getFileByFileTypeId');
});
