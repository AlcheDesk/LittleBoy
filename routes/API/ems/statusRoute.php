<?php

//status route
Route::prefix('statuses')->group(function () {
    Route::get('/', 'EMS\StatusController@selectByCondition');
    Route::get('/{id}', 'EMS\StatusController@selectById');
    Route::delete('/', 'EMS\StatusController@deleteByCondition');
    Route::delete('/{id}', 'EMS\StatusController@deleteById');
    Route::post('/', 'EMS\StatusController@insert');
    Route::put('/', 'EMS\StatusController@replace');
    Route::patch('/', 'EMS\StatusController@update');
});
