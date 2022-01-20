<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PriorityController;
use Illuminate\Http\JsonResponse;

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
Route::get('csrf', function() {
    return new JsonResponse(['token' => csrf_token()]);
});

Route::prefix('auth')->group(function () {
    Route::post('login', 'App\Http\Controllers\AuthController@login')->name('login')->middleware('web');
    Route::post('register', 'App\Http\Controllers\AuthController@register')->name('register');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
});

Route::apiResource('task', TaskController::class);

Route::prefix('task')->group(function() {
    Route::post('sync_time', 'App\Http\Controllers\TaskController@syncTaskTime')->name('task.sync_time');
});

Route::apiResource('priority', PriorityController::class);


