<?php

// file
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'files',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'FileController@selectByCondition');
	Route::get('/{id}', 'FileController@selectById');
	Route::post('/', 'FileController@insert');
	Route::put('/', 'FileController@replace');
	Route::patch('/', 'FileController@update');
	Route::get('/{id}/content', 'FileController@getFileImgById');
});
