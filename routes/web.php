<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\ReferenceController;

/*
|--------------------------------------------------------------------------
| Page d'accueil
|--------------------------------------------------------------------------
*/
Route::get('/', function() {
    return view('home');
});

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/
Route::get('/login/{role}', [AuthController::class,'showLogin'])->name('login.show');
Route::post('/login/{role}', [AuthController::class,'login'])->name('login.perform');

/*
|--------------------------------------------------------------------------
| Dashboard Superviseur
|--------------------------------------------------------------------------
*/
Route::middleware(['role:superviseur'])->group(function(){
    Route::get('/dashboard/superviseur',[DashboardController::class,'superviseur'])
        ->name('dashboard.superviseur');
});

/*
|--------------------------------------------------------------------------
| Dashboard Méthodes + References
|--------------------------------------------------------------------------
*/
Route::middleware(['role:methodes'])->group(function(){

    Route::get('/dashboard/methodes',[DashboardController::class,'methodes'])
        ->name('dashboard.methodes');

    /*
    |-------------------------
    | REFERENCES
    |-------------------------
    */

    // Liste
    Route::get('/references', [ReferenceController::class, 'index'])->name('references.index');
Route::get('/references/create', [ReferenceController::class, 'create'])->name('references.create');
Route::post('/references', [ReferenceController::class, 'store'])->name('references.store');
Route::get('/references/{reference}/edit', [ReferenceController::class, 'edit'])->name('references.edit');
Route::put('/references/{reference}', [ReferenceController::class, 'update'])->name('references.update');
Route::delete('/references/{reference}', [ReferenceController::class, 'destroy'])->name('references.destroy');
});

/*
|--------------------------------------------------------------------------
| Dashboard Shift Leader
|--------------------------------------------------------------------------
*/
Route::middleware(['role:shift_leader'])->group(function(){

    Route::get('/dashboard/shift',[DashboardController::class,'shift'])
        ->name('dashboard.shift');

    Route::get('/shifts', [ShiftController::class, 'index'])
        ->name('shifts.index');

    Route::get('/shifts/create', [ShiftController::class, 'create'])
        ->name('shifts.create');

    Route::post('/shifts', [ShiftController::class, 'store'])
        ->name('shifts.store');

    Route::get('/shifts/{shift}', [ShiftController::class, 'show'])
        ->name('shifts.show');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout',[AuthController::class,'logout'])
    ->name('logout');