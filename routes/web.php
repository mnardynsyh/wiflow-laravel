<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;



use Illuminate\Support\Facades\Route;

Route::get('/', [ReportController::class, 'index']);

Route::resource('reports',ReportController::class);
Route::resource('users',UserController::class);