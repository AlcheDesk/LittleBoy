<?php

// copy
Route::group([
	'namespace' => 'API\\ATM\\',
	'prefix' => 'apiUnitCalls',
	'middleware' => [
		'auth:api', 'atm',
	],
], function () {
	Route::post('/', 'ApiUnitCallController@apiUniCall');
});
