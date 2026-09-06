<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    $users = User::all()->toArray();
    dd($users);
    return view('welcome');
});
