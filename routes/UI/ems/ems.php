<?php

Route::group([
	'namespace' => 'UI\\EMS',
	'prefix' => 'ems',
	'middleware' => [
		'auth', 'EMS',
	],
], function () {

	Route::get('/ControlCenter', 'EMSController@showControlCenter')->name('ControlCenter');
	Route::get('/Work', 'EMSController@showWork')->name('Work');
	Route::get('/Task', 'EMSController@showTask')->name('Task');
	Route::get('/ExecutionUnit', 'EMSController@showExecutionUnit')->name('ExecutionUnit');

});
