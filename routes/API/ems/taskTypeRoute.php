<?php

//taskType route
Route::prefix('taskTypes')->group(function () {
    Route::get('/', 'EMS\TaskTypeController@selectByCondition');
    Route::get('/{id}', 'EMS\TaskTypeController@selectById');
    Route::delete('/', 'EMS\TaskTypeController@deleteByCondition');
    Route::delete('/{id}', 'EMS\TaskTypeController@deleteById');
    Route::post('/', 'EMS\TaskTypeController@insert');
    Route::put('/', 'EMS\TaskTypeController@replace');
    Route::patch('/', 'EMS\TaskTypeController@update');
});
