<?php
Route::group([
    'namespace' => 'API\\ATM\\',
    'prefix' => '',
    'middleware' => [
        'auth:api', 'atm',
    ],
], function () {
    Route::get('/projectExecutionInfo/', 'ProjectExecutionInfoController@getProjectExecutionInfo');
    Route::get('/projectExecutionInfo/{projectId}/', 'ProjectExecutionInfoController@getProjectExecutionInfoById');
    Route::get('/projectExecutionInfo/{projectId}/testCaseExecutionInfo', 'ProjectExecutionInfoController@getTestCaseExecutionInfoByProjectId');
});



