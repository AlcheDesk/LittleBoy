<?php

// testCaseFolder
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'utils/termination',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::delete('runs/{id}', 'TerminationController@terminationTestCaseRunById');
	Route::delete('runSetResults/{id}', 'TerminationController@terminationRunSetResultRunById');
});
