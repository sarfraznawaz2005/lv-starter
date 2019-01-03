<?php

Route::group(['middleware' => 'XSSProtection'], function () {

    Route::prefix('user')->group(function () {
        #===========================================================#
        ### PUBLIC ROUTES START ###
        #===========================================================#

        Auth::routes([
            'register' => config('user.allow_user_registration'),
            'verify' => config('user.user_verify_required'),
            'reset' => config('user.enable_password_reset')
        ]);

        ### PUBLIC ROUTES END ###
        #===========================================================#
    });

});



