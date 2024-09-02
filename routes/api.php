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
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\MaterialController;

Route::post('/authorization', [UserController::class, 'login']);
Route::post('/registration', [UserController::class, 'reg']);

Route::get('/image/{image}', [ImageController::class, 'get']);

Route::prefix('door')->group(function () {
    Route::get('/', [DoorController::class, 'get']);
    Route::get('/filters', [DoorController::class, 'getFilters']);
    Route::get('/{door}', [DoorController::class, 'id']);
});

Route::prefix('brand')->group(function () {
    Route::get('/', [BrandController::class, 'get']);
    Route::get('/{brand}', [BrandController::class, 'id']);
});

Route::prefix('component')->group(function () {
    Route::get('/', [ComponentController::class, 'get']);
    Route::get('/{component}', [ComponentController::class, 'id']);
});

Route::prefix('material')->group(function () {
    Route::get('/', [MaterialController::class, 'get']);
    Route::get('/{material}', [MaterialController::class, 'id']);
});


Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);

    Route::prefix('material')->group(function () {
        Route::patch('/{material}', [MaterialController::class, 'patch']);
    });

    Route::prefix('component')->group(function () {
        Route::patch('/{component}', [ComponentController::class, 'patch']);
    });

    Route::prefix('brand')->group(function () {
        Route::patch('/{brand}', [BrandController::class, 'patch']);
    });

    Route::prefix('door')->group(function () {
        Route::patch('/{door}', [DoorController::class, 'patch']);
    });
});
