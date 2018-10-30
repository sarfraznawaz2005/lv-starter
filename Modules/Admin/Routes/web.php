<?php

Route::group(['middleware' => 'XSSProtection'], function () {
    Route::prefix('admin')->group(function () {

        #===========================================================#
        ### PUBLIC ROUTES START ###
        #===========================================================#

        Route::get('/', 'AdminController')->name('admin_login');
        Route::post('login', 'AdminController@login');

        ### PUBLIC ROUTES END ###
        #===========================================================#

        #===========================================================#
        ### AUTHENTICATED ROUTES START ###
        #===========================================================#
        Route::group(['middleware' => ['admin', 'verified']], function () {
            Route::get('logout', 'AdminController@logout')->name('admin_logout');
            Route::get('panel', 'AdminController@index')->name('admin_panel');

            Route::get('user', 'UserController')->name('admin_user_listing');
        });
        #===========================================================#
        ### AUTHENTICATED ROUTES END ###
        #===========================================================#

    });
});



