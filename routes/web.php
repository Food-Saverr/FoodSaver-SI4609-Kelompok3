<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\DonaturController;

// Landing Page (bisa diakses semua)
Route::get('/', function () {
    return view('welcome'); // Landing Page
})->name('landing');

// Grup untuk user yang belum login (guest)
Route::middleware('guest')->group(function () {
    Route::get('/registrasi', [RegisterController::class, 'showRegisterForm'])->name('registrasi.form');
    Route::post('/registrasi', [RegisterController::class, 'register'])->name('registrasi');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

// Grup untuk user yang sudah login (auth) dan kembali ke website
Route::get('/', function () {
    if (Auth::check()) {
        // Redirect sesuai role
        $role = Auth::user()->Role_Pengguna;
        return match ($role) {
            'Admin' => redirect()->route('dashboard.admin'),
            'Donatur' => redirect()->route('dashboard.donatur'),
            default => redirect()->route('dashboard.pengguna'),
        };
    }
    return view('welcome'); // Kalau belum login
})->name('landing');

// Grup untuk user yang sudah login
Route::middleware('auth')->group(function () {

    // Dashboard untuk role Pengguna
    Route::get('/dashboard-pengguna', [PenggunaController::class, 'index'])->name('dashboard.pengguna');

    // Dashboard untuk role Donatur
    Route::get('/dashboard-donatur', [DonaturController::class, 'index'])->name('dashboard.donatur');

    // Admin Routes hanya untuk role admin
    Route::middleware('auth')->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/pengguna', [AdminDashboardController::class, 'pengguna'])->name('admin.pengguna');
        Route::get('/admin/statistik-pengguna', [AdminDashboardController::class, 'statistikPengguna'])->name('admin.pengguna');
        Route::get('/admin/statistik-makanan', [AdminDashboardController::class, 'statistikMakanan'])->name('admin.makanan');
        Route::get('/admin/total-donasi', [AdminDashboardController::class, 'detailDonasi'])->name('admin.total-donasi');
    });

    // Fitur logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});
