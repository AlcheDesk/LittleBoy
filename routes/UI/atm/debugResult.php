<?php

Route::group([
	'namespace' => 'UI\\ATM\\DebugResult',
	'prefix' => 'atm/',
	'middleware' => [
		'auth',
	],
], function () {

	Route::get('/DebugResult/Project', 'DebugResultController@showProjectDebugResult')->name('projectDebugResult');
	Route::get('/DebugResult/Project/{projectId}/TestCase', 'DebugResultController@showProjectTestCaseDebugResult')->name('projectTestCaseDebugResult');
	Route::get('/DebugResult/Project/{projectId}/TestCase/{testCaseId}/Runs', 'DebugResultController@showTestCaseRunDebugResult')->name('testCaseRunDebugResult');
	Route::get('/DebugResult/Project/{projectId}/TestCase/{testCaseId}/Runs/{runId}/Instruction', 'DebugResultController@showRunInstructionDebugResult')->name('runInstructionDebugResult');
	Route::get('/DebugResult/Project/{projectId}/TestCase/{testCaseId}/Runs/{runId}/Instruction/{apiInstructionId}/ApiLog', 'DebugResultController@showApiInstructionDebugResultLog')->name('apiInstructionDebugResultLog');

	Route::get('/DebugResult/RunList', 'DebugResultController@showRunListDebugResult')->name('runListDebugResult');
	Route::get('/DebugResult/RunList/{runListId}/TestCase', 'DebugResultController@showRunListTestCaseDebugResult')->name('runListTestCaseDebugResult');

	Route::get('/DebugResult/TestCase', 'DebugResultController@showTestCaseDebugResult')->name('testCaseDebugResult');

});