<?php

Route::group(['middleware' => 'XSSProtection'], function () {

    #===========================================================#
    ### PUBLIC ROUTES START ###
    #===========================================================#

    Route::get('/', 'MainController')->name('home');
    Route::get('/home', 'MainController')->name('home');

    ### PUBLIC ROUTES END ###
    #===========================================================#


    #===========================================================#
    ### AUTHENTICATED ROUTES START ###
    #===========================================================#

    /*
    // SAMPLE RESTFUL ROUTES...
    Route::group(['middleware' => ['auth', 'verified']], function () {
        Route::get('dashboard', 'TasksController@index')->name('dashboard');
        Route::post('tasks', 'TasksController@store')->name('task.store');
        Route::get('tasks/{task}/edit', 'TasksController@edit')->name('task.edit');
        Route::patch('tasks/{task}', 'TasksController@update')->name('task.update');
        Route::delete('tasks/{task}', 'TasksController@destroy')->name('task.destroy');
        Route::get('tasks/{task}/complete', 'TasksController@complete')->name('task.complete');
    });
    */

    #===========================================================#
    ### AUTHENTICATED ROUTES END ###
    #===========================================================#

});



