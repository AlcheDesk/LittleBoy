<?php

// userContents route
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'userContents',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'UserContentsController@selectByCondition');
});

// contentTypes route
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'contentTypes',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'ContentTypesController@selectByCondition');
});
