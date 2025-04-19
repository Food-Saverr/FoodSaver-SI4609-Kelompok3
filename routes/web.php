<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminDashboardController;


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
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

});

// Grup untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Dashboard untuk role Pengguna
    Route::get('/dashboard-pengguna', function () {
        return view('dashboard-pengguna'); // file: resources/views/dashboard-pengguna.blade.php
    })->name('dashboard.pengguna');

    // Dashboard untuk role Donatur
    Route::get('/dashboard-donatur', function () {
        return view('dashboard-donatur'); // file: resources/views/dashboard-donatur.blade.php
    })->name('dashboard.donatur');

    // Dashboard untuk role Admin
    Route::get('/dashboard-admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
    Route::get('/admin/donasi', [AdminDashboardController::class, 'detailDonasi'])->name('admin.donasi');

    // Fitur logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});