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

/**
 * Update status makanan oleh donatur setelah menerima pemberitahuan
 */
public function updateStatus(Request $request, $id)
{
    $makanan = Makanan::where('id_user', Auth::id())
        ->where('ID_Makanan', $id)
        ->firstOrFail();
    
    // Validasi input
    $request->validate([
        'Tanggal_Kedaluwarsa' => 'required|date',
        'Status_Makanan' => 'required|in:Tersedia,Habis,Didonasikan',
    ]);
    
    // Update data makanan
    $makanan->Tanggal_Kedaluwarsa = $request->Tanggal_Kedaluwarsa;
    $makanan->Status_Makanan = $request->Status_Makanan;
    $makanan->save();
    
    return redirect()->route('donatur.expired-reminders.index')
        ->with('success', 'Status makanan berhasil diperbarui');
}

/**
 * Tampilkan form untuk membuat pemberitahuan baru oleh admin
 */
public function create()
{
    // Ambil semua pengguna dengan role Donatur
    $donaturs = \App\Models\Pengguna::where('Role_Pengguna', 'Donatur')->get();
    
    return view('admin.ExpiredReminder.create', compact('donaturs'));
}

/**
 * Simpan pemberitahuan baru dan kirim ke donatur
 */
public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'donatur_id' => 'required|exists:penggunas,id_user',
        'makanan_id' => 'required|exists:makanans,ID_Makanan',
        'judul' => 'required|string|max:255',
        'pesan' => 'required|string',
    ]);
    
    // Ambil data makanan
    $makanan = Makanan::findOrFail($request->makanan_id);
    
    // Periksa apakah makanan ini milik donatur yang dipilih
    if ($makanan->id_user != $request->donatur_id) {
        return redirect()->back()
            ->with('error', 'Makanan ini bukan milik donatur yang dipilih.')
            ->withInput();
    }
    
    try {
        // Kirim notifikasi kustom
        $this->sendCustomNotification($makanan, $request->judul, $request->pesan);
        
        // Tandai makanan sebagai sudah diberi notifikasi
        $makanan->markAsNotified();
        
        return redirect()->route('admin.expired-reminders.index')
            ->with('success', 'Pemberitahuan berhasil dikirim ke donatur');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal mengirim pemberitahuan: ' . $e->getMessage())
            ->withInput();
    }
}

/**
 * Ambil daftar makanan milik donatur tertentu
 */
public function getMakanan($donaturId)
{
    $makanan = Makanan::where('id_user', $donaturId)
        ->where('Status_Makanan', 'Tersedia') // Hanya tampilkan makanan yang masih tersedia
        ->select('ID_Makanan', 'Nama_Makanan', 'Tanggal_Kedaluwarsa')
        ->get();
    
    return response()->json($makanan);
}

/**
 * Kirim notifikasi kustom ke donatur
 */
private function sendCustomNotification(Makanan $makanan, $judul, $pesan)
{
    $donatur = $makanan->donatur;
    if (!$donatur) {
        Log::warning("Tidak dapat menemukan data donatur untuk makanan ID: {$makanan->ID_Makanan}");
        throw new \Exception('Data donatur tidak ditemukan');
    }
    
    // Di sini Anda bisa menambahkan pengiriman email atau notifikasi real-time
    // Contoh: Mail::to($donatur->email)->send(new CustomNotification($makanan, $judul, $pesan));
    
    // Untuk saat ini, kita hanya log pesan
    Log::info("Notifikasi kustom untuk donatur ID {$donatur->id_user}: $judul - $pesan");
}
}