<?php

Route::group(['middleware' => 'XSSProtection'], function () {

    Route::prefix('user')->group(function () {
        #===========================================================#
        ### PUBLIC ROUTES START ###
        #===========================================================#

        Auth::routes();

        // verify registration
        if (config('user.account_email_verification')) {
            Route::get('register/verify/{confirmationCode}', [
                'as' => 'user.verify',
                'uses' => 'Auth\RegisterController@confirm'
            ]);
        }

        ### PUBLIC ROUTES END ###
        #===========================================================#
    });

});



