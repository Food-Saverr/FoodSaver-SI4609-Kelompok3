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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DonaturPaymentController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonaturDonationController;
use App\Http\Controllers\AdminDonationController;

// Landing Page (bisa diakses semua)
Route::get('/', function () {
    return view('welcome'); // Landing Page
})->name('landing');
//
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
    Route::get('/dashboard-donatur', [DonaturDashboardController::class, 'index'])->name('dashboard.donatur');

    // Dashboard untuk role Admin
    Route::get('/dashboard-admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');

    // Fitur logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');


});


// Routes for Admin Features
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Food Listing: List all foods
    Route::get('/food-listing', [AdminMakananController::class, 'index'])->name('admin.food-listing.index');

    // Food Listing: Show food details
    Route::get('/food-listing/{makanan}', [AdminMakananController::class, 'show'])->name('admin.food-listing.show');

    // Food Listing: Delete food
    Route::delete('/food-listing/{makanan}', [AdminMakananController::class, 'destroy'])->name('admin.food-listing.destroy');
    
    Route::get('/donasi-keuangan', [AdminDonationController::class, 'index'])->name('admin.donation.index');

    Route::get('/donasi-keuangan/{donation}', [AdminDonationController::class, 'show'])->name('admin.donation.show');

    Route::delete('/donasi-keuangan/{donation}', [AdminDonationController::class, 'destroy'])->name('admin.donation.destroy');

    Route::put('/donasi-keuangan/{donation}', [AdminDonationController::class, 'updateStatus'])->name('admin.donation.update-status');
});

// Routes for Donatur Features
Route::middleware(['auth'])->prefix('donatur')->group(function () {

    // Food Listing: List all foods
    Route::get('/food-listing', [DonaturMakananController::class, 'index'])->name('donatur.food-listing.index');

    // Food Listing: Show form to create new food
    Route::get('/food-listing/create', [DonaturMakananController::class, 'create'])->name('donatur.food-listing.create');

    // Food Listing: Store new food
    Route::post('/food-listing', [DonaturMakananController::class, 'store'])->name('donatur.food-listing.store');

    // Food Listing: Show food details
    Route::get('/food-listing/{makanan}', [DonaturMakananController::class, 'show'])->name('donatur.food-listing.show');

    // Food Listing: Show form to edit food
    Route::get('/food-listing/{makanan}/edit', [DonaturMakananController::class, 'edit'])->name('donatur.food-listing.edit');

    // Food Listing: Update food
    Route::put('/food-listing/{makanan}', [DonaturMakananController::class, 'update'])->name('donatur.food-listing.update');

    // Food Listing: Delete food
    Route::delete('/food-listing/{makanan}', [DonaturMakananController::class, 'destroy'])->name('donatur.food-listing.destroy');
});


// --- Routes buat Fitur Donasi keuangan -- Pengguna
Route::middleware(['auth'])->prefix('pengguna')->group(function () {
    // Dashboard donation
    Route::get('/donation/create', [DonationController::class, 'create'])->name('pengguna.donation.create')->middleware('auth');
    Route::post('/donation', [DonationController::class, 'store'])->name('pengguna.donation.store');
        
    // payment
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('pengguna.payment.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('pengguna.payment.store');
    Route::get('/payments', [PaymentController::class, 'index'])->name('pengguna.payment.index');
    // Route::get('/payments/{id}/download', [PaymentController::class, 'downloadInvoice'])->name('payment.download');
    Route::get('/payments/download/{id}', [PaymentController::class, 'downloadInvoice'])->name('pengguna.payment.downloadInvoice');

    Route::get('/donasi-keuangan', [DonationController::class, 'index'])->name('pengguna.donation.index');
    Route::get('/donasi-keuangan/{donation}', [DonationController::class, 'show'])->name('pengguna.donation.show');

});

// --- Routes buat Fitur Donasi keuangan -- Donatur
Route::middleware(['auth'])->prefix('donatur')->group(function () {
    Route::get('/donation/create', [DonaturDonationController::class, 'create'])->name('donatur.donation.create')->middleware('auth');
    Route::post('/donation', [DonaturDonationController::class, 'store'])->name('donatur.donation.store');
        
    // payment
    Route::get('/payments/create', [DonaturPaymentController::class, 'create'])->name('donatur.payment.create');
    Route::post('/payments', [DonaturPaymentController::class, 'store'])->name('donatur.payment.store');
    Route::get('/payments', [DonaturPaymentController::class, 'index'])->name('donatur.payment.index');
    // Route::get('/payments/{id}/download', [PaymentController::class, 'downloadInvoice'])->name('payment.download');
    Route::get('/payments/download/{id}', [DonaturPaymentController::class, 'downloadInvoice'])->name('donatur.payment.downloadInvoice');

    Route::get('/donasi-keuangan', [DonaturDonationController::class, 'index'])->name('donatur.donation.index');
    Route::get('/donasi-keuangan/{donation}', [DonaturDonationController::class, 'show'])->name('donatur.donation.show');

});

// --- Rute untuk Fitur Makanan Pengguna ---
Route::middleware(['auth'])->prefix('pengguna')->group(function () {
    Route::get('/food-listing', [FoodListingController::class, 'index'])->name('pengguna.food-listing.index');
    Route::get('/food-listing/{makanan}', [FoodListingController::class, 'show'])->name('pengguna.food-listing.show');
});