<?php

Route::group([
	'namespace' => 'UI\\ATM\\RunStatus',
	'prefix' => 'atm',
	'middleware' => [
		'auth',
	],
], function () {

	Route::get('/RunState/Project', 'RunStatusController@showProjectRunStatus')->name('projectRunState');
	Route::get('/RunState/Project/{projectId}/TestCase', 'RunStatusController@showProjectTestCaseRunStatus')->name('projectTestCaseRunState');

	Route::get('/RunState/RunList', 'RunStatusController@showRunListRunStatus')->name('runListRunState');
	Route::get('/RunState/RunList/{runListId}/TestCase', 'RunStatusController@showRunListTestCaseRunStatus')->name('runListTestCaseRunState');

	Route::get('/RunState/TestCase', 'RunStatusController@showTestCaseRunStatus')->name('testCaseRunState');

});
