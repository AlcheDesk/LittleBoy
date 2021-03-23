<?php

// resultReport
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'resultReports',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/projects/', 'ResultReportController@getResultReportProject');
	Route::get('/projects/{projectId}/', 'ResultReportController@getResultReportProjectById');
	Route::get('/projects/{projectId}/charts', 'ResultReportController@getResultReportChartByProjectId');

	Route::get('/testCases/', 'ResultReportController@getResultReportTestCase');
	Route::get('/testCases/{testCaseId}/', 'ResultReportController@getResultReportTestCaseById');
	Route::get('/testCases/{testCaseId}/runs', 'ResultReportController@getResultReportRunByTestCaseId');

	Route::get('/runs/{runId}/', 'ResultReportController@getResultReportRunById');
	Route::get('/runs/{runId}/instructionResults', 'ResultReportController@getResultReportInstructionResultByRunId');

	Route::get('/instructionResults/{instructionResultId}/stepLogs', 'ResultReportController@getResultReportStepLogByInstructionResultId');

	Route::get('/runSetResults/{runSetResultId}/runs', 'ResultReportController@getResultReportRunByRunSetResultId');
});

