<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminMakananController;
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

    // Fitur logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});


// --- Rute untuk Fitur Makanan Admin ---
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Menampilkan daftar makanan (index)
    Route::get('/food-listing', [AdminMakananController::class, 'index'])->name('admin.food-listing.index');

    // Menampilkan form tambah makanan (create)
    Route::get('/food-listing/create', [AdminMakananController::class, 'create'])->name('admin.food-listing.create');

    // Menyimpan data makanan baru dari form
    Route::post('/food-listing', [AdminMakananController::class, 'store'])->name('admin.food-listing.store');
    
    // Menampilkan detail makanan (show)
    Route::get('/food-listing/{makanan}', [AdminMakananController::class, 'show'])->name('admin.food-listing.show');
    
    // Menampilkan form edit makanan (edit)
    Route::get('/food-listing/{makanan}/edit', [AdminMakananController::class, 'edit'])->name('admin.food-listing.edit');
    
    // Mengupdate data makanan
    Route::put('/food-listing/{makanan}', [AdminMakananController::class, 'update'])->name('admin.food-listing.update');
    
    // Menghapus data makanan
    Route::delete('/food-listing/{makanan}', [AdminMakananController::class, 'destroy'])->name('admin.food-listing.destroy');
});