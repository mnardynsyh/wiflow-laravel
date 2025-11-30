<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RegistrationController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/daftar', [RegistrationController::class, 'store'])->name('pendaftaran.store');

Route::resource('reports',ReportController::class);
Route::resource('users',UserController::class);