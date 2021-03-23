<?php

//operatingSystem route
Route::prefix('operatingSystems')->group(function () {
    Route::get('/', 'EMS\OperatingSystemController@selectByCondition');
    Route::get('/{id}', 'EMS\OperatingSystemController@selectById');
    Route::delete('/', 'EMS\OperatingSystemController@deleteByCondition');
    Route::delete('/{id}', 'EMS\OperatingSystemController@deleteById');
    Route::post('/', 'EMS\OperatingSystemController@insert');
    Route::put('/', 'EMS\OperatingSystemController@replace');
    Route::patch('/', 'EMS\OperatingSystemController@update');
});
