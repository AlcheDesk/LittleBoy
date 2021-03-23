<?php

// section
Route::group([
    'namespace' => 'API\\ATM\\',
    'prefix' => 'verify',
    'middleware' => [
        'auth:api', 'atm',
    ],
], function () {
    Route::post('/', 'VerificationController@verify');
});
