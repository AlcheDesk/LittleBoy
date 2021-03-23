<?php

//// accounts
//Route::group([
//	'namespace' => 'API\\ATM\\',
//	'prefix' => 'accounts',
//	'middleware' => [
//		'auth:api', 'atm',
//	],
//], function () {
//	// view
//	Route::middleware([
//		'',
//	], function () {
//		Route::get('/', 'AccountController@selectByCondition');
//		Route::get('/{id}', 'AccountController@selectById');
//	});
//
//	Route::middleware([
//		'',
//	], function () {
//		Route::delete('/', 'AccountController@deleteByCondition');
//		Route::delete('/{id}', 'AccountController@deleteById');
//	});
//	Route::post('/', 'AccountController@insert');
//	Route::put('/', 'AccountController@replace');
//
//	Route::patch('/', 'AccountController@update');
//});
