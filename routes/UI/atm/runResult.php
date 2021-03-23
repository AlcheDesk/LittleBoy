<?php

Route::group([
	'namespace' => 'UI\\ATM\\RunResult',
	'prefix' => 'atm',
	'middleware' => [
		'auth',
	],
], function () {

	Route::get('/RunResult/Project', 'RunResultController@showProjectRunResult')->name('projectRunResult');
	Route::get('/RunResult/Project/{projectId}/Charts', 'RunResultController@showRunResultProjectCharts')->name('projectCharts');
	Route::get('/RunResult/Project/{projectId}/TestCase', 'RunResultController@showProjectTestCaseRunResult')->name('projectTestCaseRunResult');
	Route::get('/RunResult/Project/{projectId}/TestCase/{testCaseId}/Runs', 'RunResultController@showTestCaseRunRunResult')->name('testCaseRunRunResult');
	Route::get('/RunResult/Project/{projectId}/TestCase/{testCaseId}/Runs/{runId}/Instruction', 'RunResultController@showRunInstructionRunResult')->name('runInstructionRunResult');
	Route::get('/RunResult/Project/{projectId}/TestCase/{testCaseId}/Runs/{runId}/Instruction/{apiInstructionId}/ApiLog', 'RunResultController@showApiInstructionResultLog')->name('apiInstructionResultLog');

	Route::get('/RunResult/RunList', 'RunResultController@showRunListRunResult')->name('runListRunResult');
	Route::get('/RunResult/RunList/{runListId}/TestCase', 'RunResultController@showRunListTestCaseRunResult')->name('runListTestCaseRunResult');

	Route::get('/RunResult/TestCase', 'RunResultController@showTestCaseRunResult')->name('testCaseRunResult');

});