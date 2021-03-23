<?php

// stepLogType
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'stepLogTypes',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'StepLogTypeController@selectByCondition');
	Route::get('/{id}', 'StepLogTypeController@selectById');
	Route::delete('/', 'StepLogTypeController@deleteByCondition');
	Route::delete('/{id}', 'StepLogTypeController@deleteById');
	Route::post('/', 'StepLogTypeController@insert');
	Route::put('/', 'StepLogTypeController@replace');
	Route::patch('/', 'StepLogTypeController@update');
	Route::get('/{stepLogTypeId}/stepLogs', 'StepLogTypeController@getStepLogByStepLogTypeId');
});
