<?php

//job route
Route::group([
	'namespace' => 'API\\EMS\\',
	'prefix' => 'jobs',
	'middleware' => [
		'auth:api',
	],
], function () {
	Route::get('/', 'JobController@selectByCondition');
	Route::get('/{uuid}', 'JobController@selectByUuid');
	Route::delete('/', 'JobController@deleteByCondition');
	Route::delete('/{uuid}', 'JobController@deleteByUuid');
	Route::post('/', 'JobController@insert');
	Route::put('/', 'JobController@replace');
	Route::patch('/', 'JobController@update');

	Route::get('/{jobUuid}/tasks', 'JobController@getTaskByJobUuid');
	Route::delete('/{jobUuid}/tasks', 'JobController@deleteTaskByJobUuid');
	Route::post('/{jobUuid}/tasks', 'JobController@insertTaskByJobUuid');
	Route::patch('/{jobUuid}/tasks', 'JobController@updateTaskByJobUuid');
});

//tasks by job
// Route::prefix('jobs')->group(function () {
// 	Route::get('/{jobUuid}/tasks', 'JobController@getTaskByJobUuid');
// 	Route::delete('/{jobUuid}/tasks', 'JobController@deleteTaskByJobUuid');
// 	Route::post('/{jobUuid}/tasks', 'JobController@insertTaskByJobUuid');
// 	Route::patch('/{jobUuid}/tasks', 'JobController@updateTaskByJobUuid');
// });
