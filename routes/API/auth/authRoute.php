<?php

Route::group([
	'namespace' => 'Auth',
	'prefix' => 'auth',
], function () {
	Route::post('login', 'AuthController@login');
	Route::post('signup', 'AuthController@signup');
	Route::get('signup/activate/{token}', 'AuthController@signupActivate');
	Route::get('logout', 'AuthController@logout');

	// Route::group([
	//     'middleware' => 'auth:api'
	// ], function() {
	//     Route::get('logout', 'AuthController@logout');
	//     Route::get('user', 'AuthController@user');
	// });
});
