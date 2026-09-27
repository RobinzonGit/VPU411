<?php

use App\Http\Controllers\API\Admin\CategoryController;
use App\Http\Controllers\API\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->name('api.categories.')->group(function () {
    Route::get('', [CategoryController::class, 'index'])->name('index');
    Route::get('{category}', [CategoryController::class, 'show'])->name('show');
    Route::post('', [CategoryController::class, 'store'])->name('store');
    Route::put('{category}', [CategoryController::class, 'update'])->name('update');
    Route::delete('{category}', [CategoryController::class, 'destroy'])->name('update');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me'])->middleware('auth:api');
});
