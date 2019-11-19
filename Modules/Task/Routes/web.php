<?php

use App\Actions\Task\CompleteTaskAction;
use App\Actions\Task\DestroyTaskAction;
use App\Actions\Task\EditTaskAction;
use App\Actions\Task\IndexTaskAction;
use App\Actions\Task\StoreTaskAction;
use App\Actions\Task\UpdateTaskAction;

Route::group(['middleware' => 'XSSProtection'], function () {

    Route::group(['middleware' => ['auth', 'verified']], function () {
        //Route::resource('task', 'TaskController');
        //Route::get('task/{task}/complete', 'TaskController@complete')->name('task.complete');

        Route::group(['namespace' => '\\'], static function () {
            Route::get('task', IndexTaskAction::class)->name('task.index');
            Route::post('task', StoreTaskAction::class)->name('task.store');
            Route::put('task/{task}', UpdateTaskAction::class)->name('task.update');
            Route::delete('task/{task}', DestroyTaskAction::class)->name('task.destroy');
            Route::get('task/{task}/edit', EditTaskAction::class)->name('task.edit');
            Route::get('task/{task}/complete', CompleteTaskAction::class)->name('task.complete');
        });
    });

});



