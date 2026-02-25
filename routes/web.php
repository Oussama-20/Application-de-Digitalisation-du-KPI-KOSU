<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Page d'accueil
Route::get('/', function() { return view('home'); });

// Login
Route::get('/login/{role}', [AuthController::class,'showLogin'])->name('login.show');
Route::post('/login/{role}', [AuthController::class,'login'])->name('login.perform');

// Dashboards protégés
Route::middleware(['role:superviseur'])->group(function(){
    Route::get('/dashboard/superviseur',[DashboardController::class,'superviseur'])->name('dashboard.superviseur');
});

Route::middleware(['role:methodes'])->group(function(){
    Route::get('/dashboard/methodes',[DashboardController::class,'methodes'])->name('dashboard.methodes');
});

Route::middleware(['role:shift_leader'])->group(function(){
    Route::get('/dashboard/shift',[DashboardController::class,'shift'])->name('dashboard.shift');
});

// Logout
Route::post('/logout',[AuthController::class,'logout'])->name('logout');