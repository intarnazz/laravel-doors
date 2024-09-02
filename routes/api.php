<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\ImageController;
use App\Http\Controllers\DoorController;
use App\Http\Controllers\UserController;

Route::post('/authorization', [UserController::class, 'login']);
Route::post('/registration', [UserController::class, 'reg']);

Route::get('/image/{image}', [ImageController::class, 'get']);

Route::prefix('door')->group(function () {
    Route::get('/', [DoorController::class, 'get']);
    Route::get('/filters', [DoorController::class, 'getFilters']);
    Route::get('/{door}', [DoorController::class, 'id']);
    Route::patch('/{door}', [DoorController::class, 'patch']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::prefix('door')->group(function () {
        Route::patch('/{door}', [DoorController::class, 'patch']);
    });
});



//  [ ] - избранные двери
