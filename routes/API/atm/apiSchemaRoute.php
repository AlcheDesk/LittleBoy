<?php

// apiSchemas
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'apiSchemas',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::get('/', 'ApiSchemaController@selectByCondition');
	Route::get('/{id}', 'ApiSchemaController@selectById');
	Route::delete('/', 'ApiSchemaController@deleteByCondition');
	Route::delete('/{id}', 'ApiSchemaController@deleteById');
	Route::post('/', 'ApiSchemaController@insert');
	Route::put('/', 'ApiSchemaController@replace');
	Route::patch('/', 'ApiSchemaController@update');

	Route::get('/{apiSchemaId}/projects', 'ApiSchemaController@getProjectByApiSchemaId');
});
