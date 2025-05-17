<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationPreference;
use App\Models\User;
use App\Models\Pengguna;

class NotificationService
{
    public function createNotification(Pengguna $user, string $type, string $title, string $message, array $data = []): void
    {
        // Debug: log create notification
        \Log::info('Create notification called', [
            'user_id' => $user->ID_Pengguna,
            'type' => $type,
            'title' => $title
        ]);

        // Get or create notification preferences
        $preferences = $user->notificationPreference()->firstOrCreate([
            'user_id' => $user->ID_Pengguna,
        ], [
            'request_status' => true,
            'new_requests' => true,
            'maintenance' => true
        ])->fresh();

        // Check if this type of notification is enabled
        if (in_array($type, ['announcement', 'info'])) {
            $isEnabled = true;
        } else {
            $isEnabled = match($type) {
                'request_status' => $preferences->request_status,
                'new_request' => $preferences->new_requests,
                'maintenance' => $preferences->maintenance,
                default => true
            };
        }

        if (!$isEnabled) {
            return;
        }

        // Create the notification
        $user->notifications()->create([
            'user_id' => $user->ID_Pengguna,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'read_at' => null
        ]);
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
} 