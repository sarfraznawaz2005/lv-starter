<?php

use App\Actions\Task\CompleteTaskAction;
use App\Actions\Task\DestroyTaskAction;
use App\Actions\Task\EditTaskAction;
use App\Actions\Task\IndexTaskAction;
use App\Actions\Task\StoreTaskAction;
use App\Actions\Task\UpdateTaskAction;
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

Route::group(['namespace' => '\\'], static function () {
    Route::get('task', IndexTaskAction::class)->name('task.index');
    Route::post('task', StoreTaskAction::class)->name('task.store');
    Route::put('task/{task}', UpdateTaskAction::class)->name('task.update');
    Route::delete('task/{task}', DestroyTaskAction::class)->name('task.destroy');
    Route::get('task/{task}', EditTaskAction::class)->name('task.edit');
    Route::get('task/{task}/complete', CompleteTaskAction::class)->name('task.complete');
});
