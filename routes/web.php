<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RegistrationController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/daftar', [RegistrationController::class, 'store'])->name('pendaftaran.store');


//login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('reports',ReportController::class);
Route::resource('users',UserController::class);

Route::get('/dashboard', [ReportController::class,'index'])
   ->name('admin.dashboard')
   ->middleware('auth'); 

Route::get('/teknisi/dashboard', function() {
    return view('teknisi.dashboard'); 
})->middleware('auth')->name('teknisi.dashboard');