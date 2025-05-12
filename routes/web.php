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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DonaturPaymentController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonaturDonationController;
use App\Http\Controllers\AdminDonationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MapController;

// Landing Page (bisa diakses semua)
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->Role_Pengguna;

        return match ($role) {
            'Admin'    => redirect()->route('dashboard.admin'),
            'Donatur'  => redirect()->route('dashboard.donatur'),
            'Pengguna' => redirect()->route('dashboard.pengguna'),
            default    => redirect()->route('/'),
        };
    }

    return view('welcome');
})->name('/');

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

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Route untuk profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show'); // Satu route untuk tampilan profil

    // Route untuk halaman edit profil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // Route untuk update password
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // Route untuk update profil
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    // Route untuk menghapus akun
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/food-listing', [AdminMakananController::class, 'index'])->name('admin.food-listing.index');
    Route::get('/food-listing/{makanan}', [AdminMakananController::class, 'show'])->name('admin.food-listing.show');
    Route::delete('/food-listing/{makanan}', [AdminMakananController::class, 'destroy'])->name('admin.food-listing.destroy');
    Route::get('/admin/request/{id_makanan}', [AdminRequestController::class, 'index'])->name('admin.request.index');
    Route::get('/donasi-keuangan', [AdminDonationController::class, 'index'])->name('admin.donation.index');

    Route::get('/donasi-keuangan/{donation}', [AdminDonationController::class, 'show'])->name('admin.donation.show');

    Route::delete('/donasi-keuangan/{donation}', [AdminDonationController::class, 'destroy'])->name('admin.donation.destroy');

    Route::put('/donasi-keuangan/{donation}', [AdminDonationController::class, 'updateStatus'])->name('admin.donation.update-status');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/statistik-pengguna', [AdminDashboardController::class, 'statistikPengguna'])->name('DashboardAdmin.pengguna');
    Route::get('/statistik-makanan', [AdminDashboardController::class, 'statistikMakanan'])->name('DashboardAdmin.makanan');
    Route::get('/statistik-donasi', [AdminDashboardController::class, 'statistikDonasi'])->name('DashboardAdmin.donasi');
    Route::get('/statistik-artikel', [AdminDashboardController::class, 'showTotalArtikel'])->name('DashboardAdmin.artikel');
    Route::get('/statistikforum', [AdminDashboardController::class, 'statistikForum'])->name('DashboardAdmin.statistikForum');
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

    // Map routes
    Route::get('/maps', [MapController::class, 'index'])->name('pengguna.maps.index');
    Route::get('/maps/nearby', [MapController::class, 'nearby'])->name('pengguna.maps.nearby');
    Route::post('/maps/{makanan}/location', [MapController::class, 'updateLocation'])->name('maps.update-location');
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
