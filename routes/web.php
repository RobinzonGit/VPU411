<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Auth;

Route::get('', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class);
    });

Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

Auth::routes();
