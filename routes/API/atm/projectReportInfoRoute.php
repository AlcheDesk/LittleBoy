<?php
Route::group([
    'namespace' => 'API\\ATM\\',
    'prefix' => '',
    'middleware' => [
        'auth:api', 'atm',
    ],
], function () {
    Route::get('/projectReportInfo/', 'ProjectReportInfoController@getProjectReportInfo');
    Route::get('/projectReportInfo/{projectId}/', 'ProjectReportInfoController@getProjectReportInfoById');
});



