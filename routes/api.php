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

Route::get('/image/{image}', [ImageController::class, 'get']);

Route::prefix('door')->group(function () { // bookmaker
    Route::get('/', [DoorController::class, 'get']);
    Route::get('/{door}', [DoorController::class, 'id']);
});



//  [ ] - избранные двери
