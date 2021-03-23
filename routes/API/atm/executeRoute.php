<?php

// execute
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'execute',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/testCases/{testCaseId}', 'ExecutionController@selectExecuteTestCaseByTestCaseId');
	Route::post('/testCases/{testCaseId}', 'ExecutionController@executeTestCaseByTestCaseId');
	Route::get('/runSets/{runSetId}', 'ExecutionController@selectExecuteRunSetByRunSetId');
	Route::post('/runSets/{runSetId}', 'ExecutionController@executeRunSetByRunSetId');
	Route::post('/runSetResults/{runSetId}', 'ExecutionController@executeRunSetResultByRunSetId');
	Route::post('/aliases', 'ExecutionController@executeAliases');
});
