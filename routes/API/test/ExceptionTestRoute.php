<?php


Route::prefix('tests/exceptions')->group(function () {
    Route::get('/forbidden', 'Test\ExceptionController@forbidden');
});
