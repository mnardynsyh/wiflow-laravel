<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Worker\DashboardController as WorkerController;
// use App\Http\Controllers\PaketController;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/daftar', [RegistrationController::class, 'store'])->name('pendaftaran.store');


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        
        // Dashboard Utama
        Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');

        Route::resource('pendaftaran', RegistrationController::class)->except(['store']);


        Route::resource('reports', ReportController::class);

        Route::resource('users', UserController::class);
        
        // Route::resource('paket', PaketController::class);
    });



     Route::prefix('teknisi')->middleware(['role:teknisi'])->group(function () {
        
        Route::get('/dashboard', [WorkerController::class, 'index'])->name('teknisi.dashboard');
        
        Route::get('/laporan/create/{id_pendaftaran}', [ReportController::class, 'create'])->name('teknisi.laporan.create');
        Route::post('/laporan', [ReportController::class, 'store'])->name('teknisi.laporan.store');
    });


<<<<<<< Updated upstream
});
=======
});
>>>>>>> Stashed changes
