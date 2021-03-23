<?php

// section
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'sections',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'SectionController@selectByCondition');
	Route::get('/{id}', 'SectionController@selectById');
	Route::delete('/', 'SectionController@deleteByCondition');
	Route::delete('/{id}', 'SectionController@deleteById');
	Route::post('/', 'SectionController@insert');
	Route::put('/', 'SectionController@replace');
	Route::patch('/', 'SectionController@update');

	// element by section and application by section
	Route::get('/{sectionId}/elements', 'SectionController@getElementBySectionId');
	Route::delete('/{sectionId}/elements', 'SectionController@deleteElementBySectionId');
	Route::post('/{sectionId}/elements', 'SectionController@insertElementBySectionId');
	Route::put('/{sectionId}/elements', 'SectionController@replaceElementBySectionId');
	Route::get('/{sectionId}/applications', 'SectionController@getApplicationBySectionId');
});
