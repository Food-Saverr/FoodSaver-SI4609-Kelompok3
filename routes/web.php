<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminDashboardController;


// Landing Page (bisa diakses semua)
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Grup untuk user yang belum login (guest)
Route::middleware('guest')->group(function () {
    // Registration Routes
    Route::get('/registrasi', [RegisterController::class, 'showRegisterForm'])->name('registrasi.form');
    Route::post('/registrasi', [RegisterController::class, 'register'])->name('registrasi');
    
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

// Grup untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Dashboard untuk role Pengguna
    Route::get('/dashboard-pengguna', function () {
        return view('dashboard-pengguna');
    })->name('dashboard.pengguna');

    // Dashboard untuk role Donatur
    Route::get('/dashboard-donatur', function () {
        return view('dashboard-donatur');
    })->name('dashboard.donatur');

    // Dashboard dan fitur Admin
    Route::prefix('admin')->middleware('auth')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/statistik-pengguna', [AdminDashboardController::class, 'statistikPengguna'])->name('admin.pengguna');
        Route::get('/statistik-makanan', [AdminDashboardController::class, 'statistikMakanan'])->name('admin.makanan');
        Route::get('/statistik-donasi', [AdminDashboardController::class, 'statistikDonasi'])->name('admin.donasi');
        Route::get('/total-artikel', [AdminDashboardController::class, 'showTotalArtikel'])->name('admin.artikel');
    });

    // Alternative URL for admin dashboard
    Route::get('/dashboard-admin', function () {
        if (auth()->user()->Role_Pengguna !== 'Admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app()->make(AdminDashboardController::class)->index();
    })->name('dashboard.admin');

    // Logout Route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
