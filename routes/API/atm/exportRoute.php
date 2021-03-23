<?php

// exportExcel
Route::group([
	'namespace' => 'Meowlomo\\',
	'prefix' => 'export',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('testCases/{id}', 'ExportController@exportExcelByTestCaseId');
});
