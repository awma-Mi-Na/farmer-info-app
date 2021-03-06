<?php

use App\Http\Controllers\DistrictController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
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

Route::get('/sanctum/csrf-cookie', function () {
    return response('', 204);
});

//? login
Route::post('login', LoginController::class);

//? authentication required
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', LogoutController::class);

    //? get auth user details
    Route::get('user', [UserController::class, 'show'])->name('user.show');

    Route::match(['put', 'patch'], 'user', [UserController::class, 'update'])->name('user.update');

    //? admin guard
    Route::middleware('admin')->group(function () {
        Route::apiResource('item', ItemController::class)->except(['index', 'show']);
        Route::apiResource('market', MarketController::class)->except(['index', 'show']);
        Route::apiResource('district', DistrictController::class)->except(['index', 'show']);
        Route::apiResource('entry', EntryController::class)->except(['index', 'show', 'store']);
        Route::apiResource('photo', PhotoController::class)->except(['index', 'show', 'store']);
        Route::get('users', [UserController::class, 'index'])->name('user.index');
        Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        //? user management
        Route::post('user', [UserController::class, 'store'])->name('user.store');

        //? reports/statistics
        Route::get('report/weekly', [ReportController::class, 'weekly'])->name('report.weekly');
    });

    //? agent guard`
    Route::middleware('agent')->group(function () {
        Route::apiResource('entry', EntryController::class)->only('store');
        Route::apiResource('photo', PhotoController::class)->only('store');
    });
});

//? get all users with filters if requested [for testing only]
// Route::get('users', [UserController::class, 'index'])->name('user.index');


//? get all items and specific item
Route::apiResource('item', ItemController::class)->only(['index', 'show']);

//? get all market and specific market
Route::apiResource('market', MarketController::class)->only(['index', 'show']);

//? get all district and specific district details
Route::apiResource('district', DistrictController::class)->only(['index', 'show']);

//? get all entries and specific entry details
Route::apiResource('entry', EntryController::class)->only(['index', 'show']);

//? get all photos and specific photo
Route::apiResource('photo', PhotoController::class)->only(['index', 'show']);
