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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminArtikelController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ExpiredReminderController;
use App\Http\Controllers\ExpiredFoodHistoryController;
use App\Http\Controllers\ForumPenggunaController;
use App\Http\Controllers\ForumDonaturController;
use App\Http\Controllers\AdminForumController;


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

    // Notification Routes untuk Admin
    Route::get('/notifications/send', [NotificationController::class, 'showSendForm'])->name('admin.notifications.send-form');
    Route::post('/notifications/send', [NotificationController::class, 'sendNotification'])->name('admin.notifications.send');
});
Route::middleware(['auth'])->prefix('donatur')->group(function () {
    Route::get('/food-listing', [DonaturMakananController::class, 'index'])->name('donatur.food-listing.index');
    Route::get('/food-listing/create', [DonaturMakananController::class, 'create'])->name('donatur.food-listing.create');
    Route::post('/food-listing', [DonaturMakananController::class, 'store'])->name('donatur.food-listing.store');
    Route::get('/food-listing/{makanan}', [DonaturMakananController::class, 'show'])->name('donatur.food-listing.show');
    Route::get('/food-listing/{makanan}/edit', [DonaturMakananController::class, 'edit'])->name('donatur.food-listing.edit');
    Route::put('/food-listing/{makanan}', [DonaturMakananController::class, 'update'])->name('donatur.food-listing.update');
    Route::delete('/food-listing/{makanan}', [DonaturMakananController::class, 'destroy'])->name('donatur.food-listing.destroy');
    Route::get('/request/{id_makanan}', [DonaturRequestController::class, 'index'])->name('donatur.request.index');
    Route::get('/request/show/{id_request}', [DonaturRequestController::class, 'show'])->name('donatur.request.show');
    Route::patch('/request/{id_request}', [DonaturRequestController::class, 'update'])->name('donatur.request.update');
    Route::post('/request/{id_request}', [DonaturRequestController::class, 'update']);

    // Notification Routes untuk Donatur
    Route::get('/notifications', [NotificationController::class, 'index'])->name('donatur.notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('donatur.notifications.mark-as-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('donatur.notifications.mark-all-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('donatur.notifications.unread-count');
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
    // Rute untuk mengatur pengambilan
    Route::post('/request/{id_request}/pickup', [RequestController::class, 'updatePickup'])->name('pengguna.request.update-pickup');
    Route::post('/request/{id_request}/pickup/edit', [RequestController::class, 'editPickup'])->name('pengguna.request.edit-pickup');
    Route::post('/request/{id_request}/pickup/cancel', [RequestController::class, 'cancelPickup'])->name('pengguna.request.cancel-pickup');

    // Notification Routes untuk Pengguna
    Route::get('/notifications', [NotificationController::class, 'index'])->name('pengguna.notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('pengguna.notifications.mark-as-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('pengguna.notifications.mark-all-read');
    Route::get('/notifications/preferences', [NotificationController::class, 'preferences'])->name('pengguna.notifications.preferences');
    Route::put('/notifications/preferences', [NotificationController::class, 'updatePreferences'])->name('pengguna.notifications.update-preferences');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('pengguna.notifications.unread-count');
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

// Admin routes Artikel (gunakan huruf besar "Admin" pada prefix dan middleware)
Route::middleware(['auth', 'can:Admin'])->prefix('Admin')->group(function () {
    Route::resource('artikel', AdminArtikelController::class, [
        'as' => 'Admin'
    ])->except(['show']);
});

// Public routes Artikel (Pengguna & Donatur)
Route::get('artikels', [ArtikelController::class, 'index'])
    ->name('artikels.index');
Route::get('artikel/{slug}', [ArtikelController::class, 'show'])
    ->name('artikels.show');

// web.php
Route::middleware('auth')->group(function () {
    Route::post('artikel/{artikel}/like', [LikeController::class, 'toggle'])
        ->name('artikels.toggleLike');
});

// Untuk user (public)
Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])->name('artikel.show');

// Untuk admin (gunakan middleware jika perlu)
Route::prefix('admin/artikel')->name('admin.artikel.')->group(function () {
    Route::get('/', [ArtikelController::class, 'index'])->name('index');
    Route::get('/create', [ArtikelController::class, 'create'])->name('create');
    Route::post('/', [ArtikelController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ArtikelController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ArtikelController::class, 'update'])->name('update');
    Route::delete('/{id}', [ArtikelController::class, 'destroy'])->name('destroy');
});

// public lihat artikel & search
Route::get('artikels', [ArtikelController::class, 'index'])->name('artikels.index');
Route::get('artikels/{slug}', [ArtikelController::class, 'show'])->name('artikels.show');

// untuk like/unlike (harus login)
Route::middleware('auth')->group(function () {
    Route::post('artikels/{artikel}/like', [LikeController::class, 'toggle'])
        ->name('artikels.toggleLike');
});

// // Untuk Donatur
// Route::get('/donatur/artikel', [ArtikelController::class, 'artikelDonatur'])->name('artikel.donatur');

// // Untuk Pengguna
// Route::get('/pengguna/artikel', [ArtikelController::class, 'artikelPengguna'])->name('artikel.pengguna');

// Untuk Pengguna
Route::get('/pengguna/artikel', [ArtikelController::class, 'indexPengguna'])
    ->name('artikel.pengguna')
    ->middleware('auth');

// Untuk Donatur
Route::get('/donatur/artikel', [ArtikelController::class, 'indexDonatur'])
    ->name('artikel.donatur')
    ->middleware('auth');

Route::get('/expired-food-history', [ExpiredFoodHistoryController::class, 'index'])
        ->name('donatur.expired-food-history.index');
Route::get('/expired-food-history/{expiredFood}', [ExpiredFoodHistoryController::class, 'show'])
        ->name('donatur.expired-food-history.show');

Route::middleware(['auth'])->group(function () {
    // Forum routes
    Route::resource('pengguna/forum', ForumPenggunaController::class, [
        'names' => [
            'index' => 'pengguna.forum.index',
            'create' => 'pengguna.forum.create',
            'store' => 'pengguna.forum.store',
            'show' => 'pengguna.forum.show',
            'edit' => 'pengguna.forum.edit',
            'update' => 'pengguna.forum.update',
            'destroy' => 'pengguna.forum.destroy',
        ]
    ]);
    
    // Comment routes
    Route::post('forum/{post}/comment', [ForumPenggunaController::class, 'addComment'])->name('pengguna.forum.comment');
    Route::delete('forum/comment/{comment}', [ForumPenggunaController::class, 'deleteComment'])->name('pengguna.forum.comment.delete');
    
    // Like routes
    Route::post('forum/{post}/like', [ForumPenggunaController::class, 'toggleLike'])->name('pengguna.forum.like');
    
    // Attachment routes
    Route::delete('forum/attachment/{attachment}', [ForumPenggunaController::class, 'deleteAttachment'])->name('pengguna.forum.attachment.delete');

    // Report route
    Route::post('forum/{id}/report', [ForumPenggunaController::class, 'reportPost'])->name('pengguna.forum.report');
});


// Donatur Forum Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('donatur/forum', ForumDonaturController::class, [
        'names' => [
            'index' => 'donatur.forum.index',
            'create' => 'donatur.forum.create',
            'store' => 'donatur.forum.store',
            'show' => 'donatur.forum.show',
            'edit' => 'donatur.forum.edit',
            'update' => 'donatur.forum.update',
            'destroy' => 'donatur.forum.destroy',
        ]
    ]);
    
    Route::post('donatur/forum/{post}/comment', [ForumDonaturController::class, 'addComment'])->name('donatur.forum.comment');
    Route::delete('donatur/forum/comment/{comment}', [ForumDonaturController::class, 'deleteComment'])->name('donatur.forum.comment.delete');
    Route::post('donatur/forum/{post}/like', [ForumDonaturController::class, 'toggleLike'])->name('donatur.forum.like');
    Route::delete('donatur/forum/attachment/{attachment}', [ForumDonaturController::class, 'deleteAttachment'])->name('donatur.forum.attachment.delete');

    // Report route
    Route::post('donatur/forum/{id}/report', [ForumDonaturController::class, 'reportPost'])->name('donatur.forum.report');
});


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('forum', [AdminForumController::class, 'index'])->name('forum.index');
    Route::get('forum/{id}', [AdminForumController::class, 'show'])->name('forum.show');
    Route::get('forum/{id}/edit', [AdminForumController::class, 'edit'])->name('forum.edit');
    Route::put('forum/{id}', [AdminForumController::class, 'update'])->name('forum.update');
    Route::delete('forum/{id}', [AdminForumController::class, 'destroy'])->name('forum.destroy');
    Route::post('forum/{id}/restore', [AdminForumController::class, 'restore'])->name('forum.restore');
    Route::delete('forum/comment/{commentId}', [AdminForumController::class, 'deleteComment'])->name('forum.comment.delete');
    Route::delete('forum/attachment/{attachmentId}', [AdminForumController::class, 'deleteAttachment'])->name('forum.attachment.delete');
    Route::get('forum/attachment/{attachmentId}/download', [AdminForumController::class, 'downloadAttachment'])->name('forum.attachment.download');
    Route::get('forum-statistics', [AdminForumController::class, 'statistics'])->name('forum.statistics');

    // Forum report routes
    Route::get('reports', [AdminForumController::class, 'reportIndex'])->name('forum.reports');
    Route::get('reports/{id}', [AdminForumController::class, 'reportShow'])->name('forum.reports.show');
    Route::post('reports/{id}/update', [AdminForumController::class, 'reportUpdate'])->name('forum.reports.update');
    Route::delete('reports/{id}', [AdminForumController::class, 'reportDestroy'])->name('forum.reports.destroy');
});