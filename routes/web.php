<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RiwayatPermintaanController;

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
    Route::get('/dashboard-admin', function () {
        return view('dashboard-admin'); // file: resources/views/dashboard-admin.blade.php
    })->name('dashboard.admin');

    Route::get('/request', [RequestController::class, 'index'])->name('request.index');
    Route::get('/request/create/{idMakanan}', [RequestController::class, 'create'])->name('request.create');
    Route::post('/request/store/{idMakanan}', [RequestController::class, 'store'])->name('request.store');
    Route::get('/riwayat-permintaan', [RiwayatPermintaanController::class, 'index'])->name('request.history');
    Route::delete('/request/{idMakanan}', [RequestController::class, 'destroy'])->name('request.destroy');


    // Fitur logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});