<?php

// accounts
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'preExecution',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	// view
	Route::post('/', 'PreExecutionController@PreExecutionCall');
	Route::post('/httpPreExecution', 'PreExecutionController@HttpPreExecutionCall');
	Route::post('/webServicePreExecution', 'PreExecutionController@WebServicePreExecutionCall');
	Route::post('/RedisExecution', 'PreExecutionController@RedisExecutionCall');
});