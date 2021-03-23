<?php

// application route
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'applications',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'ApplicationController@selectByCondition');
	Route::get('/{id}', 'ApplicationController@selectById');
	Route::delete('/', 'ApplicationController@deleteByCondition');
	Route::delete('/{id}', 'ApplicationController@deleteById');
	Route::post('/', 'ApplicationController@insert');
	Route::put('/', 'ApplicationController@replace');
	Route::patch('/', 'ApplicationController@update');

	// section by applicationId
	Route::get('/{applicationId}/sections', 'ApplicationController@getSectionByApplicationId');
	Route::post('/{applicationId}/sections', 'ApplicationController@insertSectionByApplicationId');
	Route::delete('/{applicationId}/sections', 'ApplicationController@deleteSectionByApplicationId');
	Route::patch('/{applicationId}/sections', 'ApplicationController@updateSectionByApplicationId');
	Route::put('/{applicationId}/sections', 'ApplicationController@replaceSectionByApplicationId');
	Route::get('/{applicationId}/projects', 'ApplicationController@getProjectByApplicationId');
});
