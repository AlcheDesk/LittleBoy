<?php

Route::group([
	'namespace' => 'Auth\\Accounts',
	'prefix' => 'auth',
	/*'middleware' => [
		'auth', 'RBAC',
	],*/
], function () {

	Route::group([
		'prefix' => 'accounts',
	], function () {

        Route::get('/', 'AccountController@showAccount')->name('accountShow');

		Route::get('/accountCreate', 'AccountController@showAccountCreate')->name('accountCreateShow');

		Route::get('/accountJoin', 'AccountController@showAccountJoin')->name('accountJoinShow');

        Route::post('/accountCreate', 'AccountController@store')->name('accountCreate');

        Route::post('/accountJoin', 'AccountController@accountJoin')->name('accountJoin');

				Route::get('/accountChoose', 'AccountController@showAccountList')->name('accountListShow');
				
        Route::get('/accountExitShow', 'AccountController@showAccountExitList')->name('accountExitListShow');
				
        Route::post('/accountExit', 'AccountController@userExitAccount')->name('exitAccount');

//        Route::get('/accountCreateSucess', 'Accounts\AccountController@showAccountCreateSucess')->name('accountCreateSucess');


    });
});



