<?php

//group route
Route::prefix('groups')->group(function () {
    Route::get('/', 'EMS\GroupController@selectByCondition');
    Route::get('/{id}', 'EMS\GroupController@selectById');
    Route::delete('/', 'EMS\GroupController@deleteByCondition');
    Route::delete('/{id}', 'EMS\GroupController@deleteById');
    Route::post('/', 'EMS\GroupController@insert');
    Route::put('/', 'EMS\GroupController@replace');
    Route::patch('/', 'EMS\GroupController@update');
});
