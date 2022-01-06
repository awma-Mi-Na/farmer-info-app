<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('item', ItemController::class)->only('index');
    Route::post('logout', [SessionController::class, 'destroy']);
    Route::middleware('isAdmin')->group(function () {
        Route::apiResource('item', ItemController::class)->except('index');
    });
});

//? public endpoints
Route::post('login', [SessionController::class, 'store']);
