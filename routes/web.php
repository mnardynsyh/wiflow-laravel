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
use App\Http\Controllers\Worker\ProfileController as WorkerProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. PUBLIC ROUTES ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/daftar', [RegistrationController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran-berhasil/{id}', [RegistrationController::class, 'success'])->name('pendaftaran.sukses');

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
        Route::post('/reports/{id}/approve', [App\Http\Controllers\Admin\ReportController::class, 'approve'])->name('admin.reports.approve');
        Route::get('/riwayat-pelanggan', [RegistrationController::class, 'riwayat'])->name('admin.riwayat');
        Route::resource('users', UserController::class);
        Route::resource('plans', PlanController::class);
    });


    // === GROUP TEKNISI ===
    Route::prefix('teknisi')->middleware(['role:teknisi'])->group(function () {
        
        // 1. Dashboard
        Route::get('/dashboard', [WorkerDashboardController::class, 'index'])->name('teknisi.dashboard');
        
        // 2. Tugas
        Route::get('/tugas', [WorkerReportController::class, 'index'])->name('teknisi.assignments.index');
        Route::patch('/pekerjaan/{id}/mulai', [WorkerDashboardController::class, 'startJob'])->name('teknisi.job.start');
        
        // 3. Riwayat
        Route::get('/riwayat', [WorkerDashboardController::class, 'history'])->name('teknisi.history');
        
        // 4. Profil & Ganti Password
        Route::get('/profil', [WorkerProfileController::class, 'index'])->name('teknisi.profile');
        Route::put('/profil/info', [WorkerProfileController::class, 'updateInfo'])->name('teknisi.profile.update.info');
        Route::put('/profil/password', [WorkerProfileController::class, 'updatePassword'])->name('teknisi.profile.update.password');

        // 4. Input Laporan
        Route::get('/laporan/create/{id_pendaftaran}', [WorkerReportController::class, 'create'])->name('teknisi.laporan.create');
        Route::post('/laporan', [WorkerReportController::class, 'store'])->name('teknisi.laporan.store');
    });

});