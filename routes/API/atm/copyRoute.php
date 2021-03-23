<?php

// copy
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'copy',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::post('/projects', 'CopyController@copyProject');
	Route::post('/testCases', 'CopyController@copyTestCase');
	Route::post('/testCases/{testCaseId}/instructions', 'CopyController@copyInstructionInTestCase');
	Route::post('/testCaseOverwrites', 'CopyController@copyTestCaseOverwrite');
});
