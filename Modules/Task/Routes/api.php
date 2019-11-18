<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/task', function (Request $request) {
    return $request->user();
});

// for API/Vue Task Component (Sample)
Route::apiResource('tasks', 'API\TaskAPIController');
*/

Route::apiResource('task', 'API\TaskAPIController');
Route::get('task/{task}/complete', 'TaskController@complete')->name('task.complete');
