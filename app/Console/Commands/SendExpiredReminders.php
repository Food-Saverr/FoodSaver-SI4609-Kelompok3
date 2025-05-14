<?php

namespace App\Console\Commands;

use App\Models\Makanan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendExpiredReminders extends Command
{
    /**
     * Nama dan signature perintah console.
     *
     * @var string
     */
    protected $signature = 'reminders:send-expired';

    /**
     * Deskripsi perintah console.
     *
     * @var string
     */
    protected $description = 'Mengirim notifikasi untuk makanan yang hampir kedaluwarsa';

    /**
     * Eksekusi perintah console.
     */
    
     public function handle()
    {
        $this->info('Mengirim pengingat makanan yang hampir kedaluwarsa...');
        
        // Ambil makanan yang akan kedaluwarsa dalam 2 hari ke depan
        $foods = Makanan::where('Tanggal_Kedaluwarsa', '<=', Carbon::now()->addDays(2))
            ->where(function($query) {
                $query->whereNull('notified')
                      ->orWhere('notified', false);
            })
            ->get();

        $count = 0;
        
        foreach ($foods as $food) {
            if ($food->isAlmostExpired()) {
                try {
                    // Kirim notifikasi
                    $this->sendNotification($food);
                    
                    // Tandai sudah diberi notifikasi
                    $food->markAsNotified();
                    
                    $count++;
                    $this->info("Notifikasi terkirim untuk: {$food->Nama_Makanan} (ID: {$food->ID_Makanan})");
                    Log::info("Notifikasi terkirim untuk makanan: {$food->Nama_Makanan} (ID: {$food->ID_Makanan})");
                } catch (\Exception $e) {
                    $this->error("Gagal mengirim notifikasi untuk makanan ID {$food->ID_Makanan}: " . $e->getMessage());
                    Log::error("Gagal mengirim notifikasi untuk makanan ID {$food->ID_Makanan}: " . $e->getMessage());
                }
            }
        }
        
        $this->info("Selesai! Total {$count} notifikasi terkirim.");
        return 0;
    }
    
    /**
     * Kirim notifikasi ke donatur
     */
    private function sendNotification($food)
    {
        $donatur = $food->donatur;
        if (!$donatur) {
            throw new \Exception("Data donatur tidak ditemukan untuk makanan ID: {$food->ID_Makanan}");
        }
        
        $daysLeft = Carbon::parse($food->Tanggal_Kedaluwarsa)->diffInDays(now());
        $expiryDate = Carbon::parse($food->Tanggal_Kedaluwarsa)->format('d M Y');
        
        // Di sini Anda bisa menambahkan pengiriman email atau notifikasi real-time
        // Contoh: 
        // Mail::to($donatur->email)->send(new FoodExpiryNotification($food, $daysLeft));
        
        // Untuk saat ini, kita hanya log pesan
        $message = "Peringatan! Makanan '{$food->Nama_Makanan}' akan kedaluwarsa dalam {$daysLeft} hari (pada {$expiryDate}).";
        Log::info("Notifikasi untuk donatur ID {$donatur->id_user}: $message");
    }
}