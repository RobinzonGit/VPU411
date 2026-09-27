<?php

use App\Http\Controllers\WEB\Admin\CategoryController;
use App\Http\Controllers\WEB\HomeController;
use App\Http\Controllers\WEB\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class);
    });

Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

Auth::routes();
