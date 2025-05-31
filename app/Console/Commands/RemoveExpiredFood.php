<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Makanan;
use App\Models\ExpiredFoodHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RemoveExpiredFood extends Command
{
    protected $signature = 'food:remove-expired';
    protected $description = 'Remove expired food donations from the system';

    public function handle()
    {
        $this->info('Checking for expired food items...');
        
        // Get all food items that have expired
        $expiredFood = Makanan::where('Status_Makanan', '!=', 'Habis')
            ->where('Tanggal_Kedaluwarsa', '<=', Carbon::now())
            ->get();

        $this->info("Found {$expiredFood->count()} expired food items.");

        foreach ($expiredFood as $makanan) {
            try {
                $this->info("Processing expired food: {$makanan->Nama_Makanan} (ID: {$makanan->ID_Makanan})");
                $this->info("Expiration date: {$makanan->Tanggal_Kedaluwarsa}");
                
                // Simpan riwayat sebelum mengupdate status
                ExpiredFoodHistory::create([
                    'ID_Makanan' => $makanan->ID_Makanan,
                    'Nama_Makanan' => $makanan->Nama_Makanan,
                    'Deskripsi_Makanan' => $makanan->Deskripsi_Makanan,
                    'Kategori_Makanan' => $makanan->Kategori_Makanan,
                    'Foto_Makanan' => $makanan->Foto_Makanan,
                    'Tanggal_Kedaluwarsa' => $makanan->Tanggal_Kedaluwarsa,
                    'Jumlah_Makanan' => $makanan->Jumlah_Makanan,
                    'Jumlah_Didonasi' => $makanan->Jumlah_Didonasi ?? 0,
                    'id_user' => $makanan->id_user,
                    'expired_at' => Carbon::now()
                ]);

                // Update the food status to expired
                $makanan->update([
                    'Status_Makanan' => 'Habis',
                    'Jumlah_Makanan' => 0
                ]);

                $this->info("Successfully marked food as expired: {$makanan->Nama_Makanan}");
                
                // Log the removal
                Log::info("Food item automatically marked as expired", [
                    'food_id' => $makanan->ID_Makanan,
                    'food_name' => $makanan->Nama_Makanan,
                    'expiration_date' => $makanan->Tanggal_Kedaluwarsa,
                    'donor_id' => $makanan->id_user
                ]);
            } catch (\Exception $e) {
                $this->error("Failed to process expired food ID {$makanan->ID_Makanan}: {$e->getMessage()}");
                Log::error("Failed to process expired food", [
                    'food_id' => $makanan->ID_Makanan,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info('Finished processing expired food items.');
    }
} 