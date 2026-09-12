<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Группа админских роутов
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
});