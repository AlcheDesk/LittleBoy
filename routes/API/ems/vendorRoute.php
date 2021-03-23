<?php

//vendor route
Route::prefix('vendors')->group(function () {
    Route::get('/', 'EMS\VendorController@selectByCondition');
    Route::get('/{id}', 'EMS\VendorController@selectById');
    Route::delete('/', 'EMS\VendorController@deleteByCondition');
    Route::delete('/{id}', 'EMS\VendorController@deleteById');
    Route::post('/', 'EMS\VendorController@insert');
    Route::put('/', 'EMS\VendorController@replace');
    Route::patch('/', 'EMS\VendorController@update');
});
