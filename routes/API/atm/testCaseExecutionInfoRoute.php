<?php
Route::group([
    'namespace' => 'API\\ATM\\',
    'prefix' => '',
    'middleware' => [
        'auth:api', 'atm',
    ],
], function () {
    Route::get('/testCaseExecutionInfo/', 'TestCaseExecutionInfoController@getTestCaseExecutionInfo');
    Route::get('/testCaseExecutionInfo/{testCaseId}/', 'TestCaseExecutionInfoController@getTestCaseExecutionInfoById');
});



