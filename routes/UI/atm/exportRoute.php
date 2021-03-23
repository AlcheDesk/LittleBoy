<?php

Route::group([
	'namespace' => 'UI\ATM',
	'prefix' => 'atm/export',
	'middleware' => [
		'auth',
	],
], function () {

	Route::get('/project/{id}', 'ExportController@exportExcelProject')->name('exportExcelProject');
	Route::get('/testCase/{id}', 'ExportController@exportExcelTestCase')->name('exportExcelTestCase');
	Route::get('/runSet/{id}', 'ExportController@exportExcelRunSet')->name('exportExcelRunSet');
	Route::get('/runSetResult/{id}', 'ExportController@exportExcelRunSetResult')->name('exportExcelRunSetResult');

});