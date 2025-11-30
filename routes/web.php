<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth; <--- INI JADI TIDAK WAJIB KALAU PAKAI auth()
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PaketLayananController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Worker\DashboardController as WorkerController;

// --- Public Routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/daftar', [RegistrationController::class, 'store'])->name('pendaftaran.store');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- Authenticated Routes ---
Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
        Route::resource('pendaftaran', RegistrationController::class)->except(['store']);
        Route::resource('reports', ReportController::class);
        Route::resource('users', UserController::class);
        Route::resource('plans', PlanController::class);
    });

    Route::prefix('teknisi')->middleware(['role:teknisi'])->group(function () {
        Route::get('/dashboard', [WorkerController::class, 'index'])->name('teknisi.dashboard');
        Route::get('/riwayat', [WorkerController::class, 'history'])->name('teknisi.history');
        Route::get('/profil', [WorkerController::class, 'profile'])->name('teknisi.profile');
        Route::put('/profil/info', [WorkerController::class, 'updateInfo'])->name('teknisi.profile.update.info');
        Route::put('/profil/password', [WorkerController::class, 'updatePassword'])->name('teknisi.profile.update.password');
        Route::get('/laporan/create/{id_pendaftaran}', [ReportController::class, 'create'])->name('teknisi.laporan.create');
        Route::post('/laporan', [ReportController::class, 'store'])->name('teknisi.laporan.store');
    });
});