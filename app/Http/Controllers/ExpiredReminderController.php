<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExpiredReminderController extends Controller
{
    /**
     * Tampilkan daftar makanan yang hampir kedaluwarsa untuk admin
     */
    public function indexAdmin()
    {
        $makanans = Makanan::where('Tanggal_Kedaluwarsa', '<=', Carbon::now()->addDays(3))
            ->orderBy('Tanggal_Kedaluwarsa')
            ->with('donatur')
            ->get();

        return view('admin.ExpiredReminder.index', compact('makanans'));
    }

    /**
     * Tampilkan daftar makanan yang hampir kedaluwarsa untuk donatur
     */
    public function indexDonatur()
    {
        $makanans = Makanan::where('id_user', Auth::id())
            ->where('Tanggal_Kedaluwarsa', '<=', Carbon::now()->addDays(3))
            ->orderBy('Tanggal_Kedaluwarsa')
            ->get();

        // Cek dan kirim notifikasi untuk makanan yang hampir kedaluwarsa
        foreach ($makanans as $makanan) {
            if ($makanan->isAlmostExpired() && !$makanan->notified) {
                $this->sendNotification($makanan);
                $makanan->markAsNotified();
            }
        }

        return view('donatur.ExpiredReminder.index', compact('makanans'));
    }

    /**
     * Kirim reminder untuk makanan yang hampir kedaluwarsa.
     */
    public function sendExpiredReminders()
    {
        // Ambil makanan yang kedaluwarsa dalam 2 hari atau kurang
        $makanans = Makanan::whereNull('notified')
            ->where('Tanggal_Kedaluwarsa', '<=', Carbon::now()->addDays(2))
            ->get();

        foreach ($makanans as $makanan) {
            // Cek jika makanan hampir kedaluwarsa dan belum diberi notifikasi
            if ($makanan->isAlmostExpired()) {
                try {
                    // Kirim notifikasi
                    $this->sendNotification($makanan);
                    
                    // Tandai makanan sebagai sudah diberi notifikasi
                    $makanan->markAsNotified();
                    
                    Log::info("Notifikasi terkirim untuk makanan: {$makanan->Nama_Makanan} (ID: {$makanan->ID_Makanan})");
                } catch (\Exception $e) {
                    Log::error("Gagal mengirim notifikasi untuk makanan ID {$makanan->ID_Makanan}: " . $e->getMessage());
                }
            }
        }

        return response()->json(['message' => 'Expired reminders sent successfully.']);
    }

    /**
     * Kirim notifikasi kepada donatur tentang makanan yang hampir kedaluwarsa
     */
    private function sendNotification(Makanan $makanan)
    {
        $donatur = $makanan->donatur;
        if (!$donatur) {
            Log::warning("Tidak dapat menemukan data donatur untuk makanan ID: {$makanan->ID_Makanan}");
            return;
        }

        $daysLeft = Carbon::parse($makanan->Tanggal_Kedaluwarsa)->diffInDays(now());
        $message = "Makanan Anda '{$makanan->Nama_Makanan}' akan kedaluwarsa dalam {$daysLeft} hari pada " . 
                  Carbon::parse($makanan->Tanggal_Kedaluwarsa)->format('d M Y') . 
                  ". Segera perbarui status atau donasikan kembali sebelum kedaluwarsa.";

        // Di sini Anda bisa menambahkan pengiriman email atau notifikasi real-time
        // Contoh: Mail::to($donatur->email)->send(new ExpiryNotification($makanan, $daysLeft));
        
        // Untuk saat ini, kita hanya log pesan
        Log::info("Notifikasi untuk donatur ID {$donatur->id_user}: $message");
        
        // Anda juga bisa menyimpan notifikasi ke database jika diperlukan
        // $donatur->notify(new FoodExpiryNotification($makanan, $daysLeft));
    }
        /**
 * Tampilkan detail makanan yang hampir kedaluwarsa
 */
public function show($id)
{
    $makanan = Makanan::with('donatur')->findOrFail($id);
    return view('admin.ExpiredReminder.show', compact('makanan'));
}

/**
 * Kirim notifikasi untuk makanan tertentu
 */
public function notify($id)
{
    $makanan = Makanan::findOrFail($id);
    
    try {
        $this->sendNotification($makanan);
        $makanan->markAsNotified();
        
        return redirect()->back()
            ->with('success', 'Notifikasi berhasil dikirim ke donatur');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal mengirim notifikasi: ' . $e->getMessage());
    }
}
}