<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminMakananController;
use App\Http\Controllers\DonaturMakananController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DonaturDashboardController;
use App\Http\Controllers\FoodListingController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\DonaturRequestController;
use App\Http\Controllers\AdminRequestController;

// Landing Page (bisa diakses semua)
Route::get('/', function () {
    return view('welcome'); // Landing Page
})->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/registrasi', [RegisterController::class, 'showRegisterForm'])->name('registrasi.form');
    Route::post('/registrasi', [RegisterController::class, 'register'])->name('registrasi');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    // Dashboard untuk role Pengguna
    Route::get('/dashboard-pengguna', function () {
        return view('dashboard-pengguna'); // file: resources/views/dashboard-pengguna.blade.php
    })->name('dashboard.pengguna');

    Route::get('/dashboard-donatur', [DonaturDashboardController::class, 'index'])->name('dashboard.donatur');
    Route::get('/dashboard-admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/food-listing', [AdminMakananController::class, 'index'])->name('admin.food-listing.index');
    Route::get('/food-listing/{makanan}', [AdminMakananController::class, 'show'])->name('admin.food-listing.show');
    Route::delete('/food-listing/{makanan}', [AdminMakananController::class, 'destroy'])->name('admin.food-listing.destroy');
    Route::get('/admin/request/{id_makanan}', [AdminRequestController::class, 'index'])->name('admin.request.index');
});
Route::middleware(['auth'])->prefix('donatur')->group(function () {
    Route::get('/food-listing', [DonaturMakananController::class, 'index'])->name('donatur.food-listing.index');
    Route::get('/food-listing/create', [DonaturMakananController::class, 'create'])->name('donatur.food-listing.create');
    Route::post('/food-listing', [DonaturMakananController::class, 'store'])->name('donatur.food-listing.store');
    Route::get('/food-listing/{makanan}', [DonaturMakananController::class, 'show'])->name('donatur.food-listing.show');
    Route::get('/food-listing/{makanan}/edit', [DonaturMakananController::class, 'edit'])->name('donatur.food-listing.edit');
    Route::put('/food-listing/{makanan}', [DonaturMakananController::class, 'update'])->name('donatur.food-listing.update');
    Route::delete('/food-listing/{makanan}', [DonaturMakananController::class, 'destroy'])->name('donatur.food-listing.destroy');
    Route::get('/donatur/request/{id_makanan}', [DonaturRequestController::class, 'index'])->name('donatur.request.index');
    Route::get('/donatur/request/show/{id_request}', [DonaturRequestController::class, 'show'])->name('donatur.request.show');
    Route::patch('/donatur/request/{id_request}', [DonaturRequestController::class, 'update'])->name('donatur.request.update');
});
Route::middleware(['auth'])->prefix('pengguna')->group(function () {
    Route::get('/food-listing', [FoodListingController::class, 'index'])->name('pengguna.food-listing.index');
    Route::get('/food-listing/{makanan}', [FoodListingController::class, 'show'])->name('pengguna.food-listing.show');
    // Rute untuk request makanan
    Route::post('/request/{id_makanan}', [RequestController::class, 'store'])->name('pengguna.request.store');
    // Rute untuk riwayat permintaan
    Route::get('/request/index', [RequestController::class, 'history'])->name('pengguna.request.index');
    // Rute untuk detail permintaan
    Route::get('/request/{id_request}', [RequestController::class, 'show'])->name('pengguna.request.show');
    // Rute untuk membatalkan permintaan
    Route::delete('/request/{id_request}/cancel', [RequestController::class, 'cancel'])->name('pengguna.request.cancel');
    // Rute untuk memperbarui status permintaan
    Route::patch('/request/{id_request}', [RequestController::class, 'update'])->name('pengguna.request.update');
});