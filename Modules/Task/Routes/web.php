<?php

Route::group(['middleware' => 'XSSProtection'], function () {

    Route::group(['middleware' => ['auth', 'verified']], function () {
        Route::resource('task', 'TaskController');
        Route::get('task/{task}/complete', 'TaskController@complete')->name('task.complete');
    });

});



