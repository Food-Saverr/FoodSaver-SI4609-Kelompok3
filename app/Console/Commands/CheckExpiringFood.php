<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Makanan;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckExpiringFood extends Command
{
    protected $signature = 'food:check-expiring';
    protected $description = 'Check for food items that are about to expire and send notifications to donors';

    public function handle(NotificationService $notificationService)
    {
        $this->info('Checking for expiring food items...');
        
        // Get all active food items that are not expired and not notified
        $expiringFood = Makanan::where('Status_Makanan', '!=', 'Habis')
            ->where('Tanggal_Kedaluwarsa', '>', Carbon::now())
            ->where('Tanggal_Kedaluwarsa', '<=', Carbon::now()->addDays(2))
            ->where('notified', false)
            ->get();

        $this->info("Found {$expiringFood->count()} food items that are about to expire.");

        foreach ($expiringFood as $makanan) {
            try {
                $donatur = $makanan->donatur;
                $this->info("Processing food: {$makanan->Nama_Makanan} (ID: {$makanan->ID_Makanan})");
                $this->info("Expiration date: {$makanan->Tanggal_Kedaluwarsa}");
                
                if (!$donatur) {
                    $this->warn("No donatur found for food ID {$makanan->ID_Makanan}");
                    continue;
                }

                $this->info("Donatur found: {$donatur->Nama_Pengguna} (ID: {$donatur->id_user})");
                
                // Check if donor has enabled expiration notifications
                if (!$donatur->notificationPreference) {
                    $this->warn("No notification preferences found for donatur ID {$donatur->id_user}");
                    continue;
                }

                if (!$donatur->notificationPreference->expiration_alerts) {
                    $this->info("Expiration alerts are disabled for donatur ID {$donatur->id_user}");
                    continue;
                }

                // Perbaikan perhitungan hari
                $expirationDate = Carbon::parse($makanan->Tanggal_Kedaluwarsa);
                $now = Carbon::now();
                $totalHours = $now->diffInHours($expirationDate, false);
                $daysLeft = max(0, floor($totalHours / 24));
                $hoursLeft = $totalHours % 24;

                $this->info("Time until expiration: {$daysLeft} days and {$hoursLeft} hours");
                
                $notificationService->notifyExpiringFood($donatur, [
                    'makanan_id' => $makanan->ID_Makanan,
                    'makanan_nama' => $makanan->Nama_Makanan,
                    'days_left' => $daysLeft,
                    'hours_left' => $hoursLeft
                ]);

                $makanan->markAsNotified();
                $this->info("Successfully sent notification for {$makanan->Nama_Makanan}");
            } catch (\Exception $e) {
                Log::error("Failed to send expiration notification for food ID {$makanan->ID_Makanan}: " . $e->getMessage());
                $this->error("Failed to process {$makanan->Nama_Makanan}: " . $e->getMessage());
            }
        }

        $this->info('Finished checking expiring food items.');
    }
} 