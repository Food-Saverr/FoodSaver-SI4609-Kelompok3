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

    // Dashboard dan fitur Admin
    Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
        Route::get('/dashboard', function () {
            if (auth()->user()->Role_Pengguna !== 'Admin') {
                return redirect('/')->with('error', 'Unauthorized access.');
            }
            return app()->make(AdminDashboardController::class)->index();
        })->name('admin.dashboard');

        Route::get('/statistik-pengguna', function () {
            if (auth()->user()->Role_Pengguna !== 'Admin') {
                return redirect('/')->with('error', 'Unauthorized access.');
            }
            return app()->make(AdminDashboardController::class)->statistikPengguna();
        })->name('admin.pengguna');

        Route::get('/statistik-makanan', function () {
            if (auth()->user()->Role_Pengguna !== 'Admin') {
                return redirect('/')->with('error', 'Unauthorized access.');
            }
            return app()->make(AdminDashboardController::class)->statistikMakanan();
        })->name('admin.makanan');

        Route::get('/statistik-donasi', function () {
            if (auth()->user()->Role_Pengguna !== 'Admin') {
                return redirect('/')->with('error', 'Unauthorized access.');
            }
            return app()->make(AdminDashboardController::class)->statistikDonasi();
        })->name('admin.donasi');
    });

    // Alternative URL for admin dashboard
    Route::get('/dashboard-admin', function () {
        if (auth()->user()->Role_Pengguna !== 'Admin') {
            return redirect('/')->with('error', 'Unauthorized access.');
        }
        return app()->make(AdminDashboardController::class)->index();
    })->name('dashboard.admin');

    // Fitur logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});