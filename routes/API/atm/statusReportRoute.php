<?php

// statusReport
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'statusReports',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/projects', 'StatusReportController@getStatusReportProject');
	Route::get('/projects/{projectId}', 'StatusReportController@getStatusReportProjectById');
	Route::get('/projects/{projectId}/testCases', 'StatusReportController@getStatusReportTestCaseByProjectId');

	Route::get('/runSets', 'StatusReportController@getStatusReportRunSet');
	Route::get('/runSets/{runSetId}', 'StatusReportController@getStatusReportRunSetById');
	Route::get('/runSets/{runSetId}/testCases', 'StatusReportController@getStatusReportTestCaseByRunSetId');

	Route::get('/testCases', 'StatusReportController@getStatusReportTestCase');
});
