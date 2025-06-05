<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationPreference;
use App\Models\User;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function createNotification(Pengguna $user, string $type, string $title, string $message, array $data = []): void
    {
        // Debug: log create notification
        \Log::info('Create notification called', [
            'user_id' => $user->id_user,
            'user_name' => $user->Nama_Pengguna,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data
        ]);

        try {
            // Get or create notification preferences
            $preferences = $user->notificationPreference()->firstOrCreate([
                'user_id' => $user->id_user,
            ], [
                'request_status' => true,
                'new_requests' => true,
                'maintenance' => true,
                'announcements_enabled' => true,
                'ads_enabled' => true,
            ])->fresh();

            \Log::info('Notification preferences', [
                'user_id' => $user->id_user,
                'preferences' => $preferences->toArray()
            ]);

            // Check if this type of notification is enabled
            $isEnabled = match($type) {
                'request_status' => $preferences->request_status,
                'new_request' => $preferences->new_requests,
                'maintenance' => $preferences->maintenance,
                'announcement' => $preferences->announcements_enabled,
                'advertisement' => $preferences->ads_enabled,
                'expiration_alert' => $preferences->expiration_alerts,
                default => true
            };

            \Log::info('Notification enabled status', [
                'user_id' => $user->id_user,
                'type' => $type,
                'is_enabled' => $isEnabled
            ]);

            if (!$isEnabled) {
                \Log::info('Notification disabled for user', [
                    'user_id' => $user->id_user,
                    'type' => $type
                ]);
                return;
            }

            // Create the notification
            $notification = $user->notifications()->create([
                'user_id' => $user->id_user,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data,
                'read_at' => null
            ]);

            \Log::info('Notification created successfully', [
                'notification_id' => $notification->id,
                'user_id' => $user->id_user,
                'type' => $type
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create notification', [
                'user_id' => $user->id_user,
                'type' => $type,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function notifyRequestStatus(Pengguna $user, string $status, array $data = []): void
    {
        $title = match($status) {
            'Approved' => 'Permintaan Makanan Diterima',
            'Rejected' => 'Permintaan Makanan Ditolak',
            'Done' => 'Pengambilan Makanan Selesai',
            default => 'Status Permintaan Diperbarui'
        };

        $message = match($status) {
            'Approved' => 'Permintaan makanan Anda telah disetujui oleh donatur.',
            'Rejected' => 'Permintaan makanan Anda telah ditolak oleh donatur.',
            'Done' => 'Pengambilan makanan telah selesai.',
            default => 'Status permintaan makanan Anda telah diperbarui.'
        };

        $this->createNotification($user, 'request_status', $title, $message, $data);
    }

    public function notifyNewRequest(Pengguna $user, array $data = []): void
    {
        $makananName = isset($data['makanan_nama']) ? $data['makanan_nama'] : 'makanan Anda';
        $this->createNotification(
            $user,
            'new_request',
            'Permintaan Baru pada ' . $makananName,
            'Ada permintaan makanan baru untuk ' . $makananName . '.',
            $data
        );
    }

    public function notifyMaintenance(Pengguna $user, string $message, array $data = []): void
    {
        $this->createNotification(
            $user,
            'maintenance',
            'Pemeliharaan Sistem',
            $message,
            $data
        );
    }

    public function notifyExpiringFood(Pengguna $donatur, array $data = []): void
    {
        $daysLeft = $data['days_left'] ?? 0;
        $hoursLeft = $data['hours_left'] ?? 0;
        $makananNama = $data['makanan_nama'] ?? 'makanan';
        
        $title = 'Peringatan Kedaluwarsa Makanan';
        $message = "Makanan '{$makananNama}' akan kedaluwarsa dalam {$daysLeft} hari dan {$hoursLeft} jam. Silakan periksa status makanan Anda.";
        
        $this->createNotification(
            $donatur,
            'expiration_alert',
            $title,
            $message,
            $data
        );
        
        // Log the notification attempt
        Log::info('Expiration notification sent', [
            'donatur_id' => $donatur->id_user,
            'makanan_id' => $data['makanan_id'] ?? null,
            'makanan_nama' => $makananNama,
            'days_left' => $daysLeft,
            'hours_left' => $hoursLeft
        ]);
    }
} 