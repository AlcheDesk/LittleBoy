<?php

//jobType route
Route::prefix('jobTypes')->group(function () {
    Route::get('/', 'EMS\JobTypeController@selectByCondition');
    Route::get('/{id}', 'EMS\JobTypeController@selectById');
    Route::delete('/', 'EMS\JobTypeController@deleteByCondition');
    Route::delete('/{id}', 'EMS\JobTypeController@deleteById');
    Route::post('/', 'EMS\JobTypeController@insert');
    Route::put('/', 'EMS\JobTypeController@replace');
    Route::patch('/', 'EMS\JobTypeController@update');
});
