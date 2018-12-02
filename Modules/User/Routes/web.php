<?php

Route::group(['middleware' => 'XSSProtection'], function () {

    Route::prefix('user')->group(function () {
        #===========================================================#
        ### PUBLIC ROUTES START ###
        #===========================================================#

        Auth::routes([
            'verify' => config('user.user_verify_required'),
            'reset' => config('user.enable_password_reset')
        ]);

        ### PUBLIC ROUTES END ###
        #===========================================================#
    });

});



