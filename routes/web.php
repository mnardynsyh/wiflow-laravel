<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\PlanController;

// Import Controller Dashboard Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;

// Import Controller Teknisi (Worker Namespace)
use App\Http\Controllers\Worker\DashboardController as WorkerDashboardController;
use App\Http\Controllers\Worker\ReportController as WorkerReportController;
use App\Http\Controllers\Worker\ProfileController as WorkerProfileController; // <-- Controller Profil Baru
use App\Http\Controllers\TeknisiController; // Sisa untuk History

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. PUBLIC ROUTES ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/daftar', [RegistrationController::class, 'store'])->name('pendaftaran.store');

// --- 2. AUTHENTICATION ROUTES ---
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- 3. PROTECTED ROUTES ---
Route::middleware(['auth'])->group(function () {

    // === GROUP ADMIN ===
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'adminIndex'])->name('admin.dashboard');
        
        // Resource Controllers
        Route::resource('pendaftaran', RegistrationController::class)->except(['store']);
        Route::resource('reports', ReportController::class);
        Route::resource('users', UserController::class);
        Route::resource('plans', PlanController::class);
    });


    // === GROUP TEKNISI ===
    Route::prefix('teknisi')->middleware(['role:teknisi'])->group(function () {
        
        // 1. Dashboard (Statistik & Ringkasan)
        Route::get('/dashboard', [WorkerDashboardController::class, 'index'])->name('teknisi.dashboard');
        
        // 2. Tugas Saya (Daftar Lengkap Pekerjaan)
        Route::get('/tugas', [WorkerReportController::class, 'index'])->name('teknisi.assignments.index');
        
        // 3. Riwayat (Masih di TeknisiController)
        Route::get('/riwayat', [WorkerDashboardController::class, 'history'])->name('teknisi.history');
        
        // 4. Profil & Ganti Password (MENGGUNAKAN WORKER PROFILE CONTROLLER)
        Route::get('/profil', [WorkerProfileController::class, 'index'])->name('teknisi.profile');
        Route::put('/profil/info', [WorkerProfileController::class, 'updateInfo'])->name('teknisi.profile.update.info');
        Route::put('/profil/password', [WorkerProfileController::class, 'updatePassword'])->name('teknisi.profile.update.password');

        // 4. Input Laporan
        Route::get('/laporan/create/{id_pendaftaran}', [WorkerReportController::class, 'create'])->name('teknisi.laporan.create');
        Route::post('/laporan', [WorkerReportController::class, 'store'])->name('teknisi.laporan.store');
    });

});