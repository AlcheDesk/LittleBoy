<?php
Route::group([
    'namespace' => 'API\\ATM\\',
    'prefix' => '',
    'middleware' => [
        'auth:api', 'atm',
    ],
], function () {
    Route::get('/runExecutionInfo/', 'RunExecutionInfoController@getRunExecutionInfo');
    Route::get('/runExecutionInfo/{runId}/', 'RunExecutionInfoController@getRunExecutionInfoById');
});



