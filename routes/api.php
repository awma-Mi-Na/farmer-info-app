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

//? authentication required
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('logout', [SessionController::class, 'destroy']);

    //? admin guard
    Route::middleware('Admin')->group(function () {
        Route::apiResource('item', ItemController::class)->except(['index', 'show']);
    });
});

//? get all items
Route::apiResource('item', ItemController::class)->only('index');

//? get specific item details
Route::apiResource('item', ItemController::class)->only('show');

//? login
Route::post('login', [SessionController::class, 'store']);
