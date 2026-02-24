<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function(){
    return view('home');
});

Route::get('/login/{role}', [AuthController::class,'showLogin'])->name('login.show');
Route::post('/login/{role}', [AuthController::class,'login'])->name('login.perform');

// ⭐ dashboard protected
Route::get('/dashboard/{role}', [AuthController::class,'dashboard'])
     ->name('dashboard')
     ->middleware('role');

Route::post('/logout', [AuthController::class,'logout'])->name('logout');