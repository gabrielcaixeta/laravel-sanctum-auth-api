<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;

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
Route::group(['prefix' => '/v1'], function () {
    Route::group(['prefix' => '/auth'], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:sanctum')->group( function () {
        Route::get('/me', function(Request $request) {
                    return auth()->user();
                });
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::resource('tasks', TaskController::class);
    });

    // Route::mi(['middleware' => ['auth:sanctum']], function () {
    //     
    //     ;
    //     Route::resource('tasks', TaskController::class);
    // });
});
    