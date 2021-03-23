<?php

// driverEntry
Route::group([
	'namespace' => 'Util',
	'prefix' => 'info',
	'middleware' => [
//		'auth:api', 'atm',
	],
], function () {
	Route::get('/gitVersion', 'InfoController@getGitVersion');
});
