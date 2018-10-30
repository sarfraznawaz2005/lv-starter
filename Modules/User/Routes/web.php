<?php

Route::group(['middleware' => 'XSSProtection'], function () {

    Route::prefix('user')->group(function () {
        #===========================================================#
        ### PUBLIC ROUTES START ###
        #===========================================================#

        Auth::routes(['verify' => true]);

        ### PUBLIC ROUTES END ###
        #===========================================================#
    });

});



