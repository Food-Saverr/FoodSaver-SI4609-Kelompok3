<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        \Log::info('Notifications fetched for user', [
            'user_id' => Auth::id(),
            'notification_count' => $notifications->count(),
            'notifications' => $notifications->pluck('id')->toArray()
        ]);

        $role = Auth::user()->Role_Pengguna;
        if ($role == 'Admin') {
            return view('admin.notifications.index', compact('notifications'));
        } elseif ($role == 'Donatur') {
            return view('donatur.notifications.index', compact('notifications'));
        } else {
            return view('pengguna.notifications.index', compact('notifications'));
        }
    }

    public function markAsRead($id)
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->update(['is_read' => true, 'read_at' => now()]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Failed to mark notification as read', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'Notification not found or unauthorized'], 404);
        }
    }

    public function markAllAsRead()
    {
        try {
            $updated = Auth::user()->notifications()
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            return response()->json(['success' => true, 'updated' => $updated]);
        } catch (\Exception $e) {
            \Log::error('Failed to mark all notifications as read', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'Failed to mark all notifications as read'], 500);
        }
    }

    public function preferences()
    {
        $preferences = Auth::user()->notificationPreference()->firstOrNew();
        $role = Auth::user()->Role_Pengguna;
        if ($role == 'Admin') {
            return view('admin.notifications.preferences', compact('preferences'));
        } elseif ($role == 'Donatur') {
            return view('donatur.notifications.preferences', compact('preferences'));
        } else {
            return view('pengguna.notifications.preferences', compact('preferences'));
        }
    }

    public function updatePreferences(Request $request)
    {
        $data = [
            'request_status' => $request->has('request_status'),
            'new_requests' => $request->has('new_requests'),
            'maintenance' => $request->has('maintenance'),
            'announcements_enabled' => $request->has('announcements_enabled'),
            'ads_enabled' => $request->has('ads_enabled'),
        ];

        Auth::user()->notificationPreference()->updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        return redirect()->back()->with('success', 'Notification preferences updated successfully');
    }

    public function getUnreadCount()
    {
        $count = Auth::user()->notifications()
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function showSendForm()
    {
        $donaturs = \App\Models\Pengguna::where('Role_Pengguna', 'Donatur')->get();
        $penggunas = \App\Models\Pengguna::where('Role_Pengguna', 'Pengguna')->get();
        return view('admin.notifications.send', compact('donaturs', 'penggunas'));
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'target' => 'required|in:all_donatur,all_pengguna,all,single',
            'type' => 'required|string',
            'title' => 'required|string|max:100',
            'message' => 'required|string|max:255',
            'user_id' => 'nullable|exists:penggunas,ID_Pengguna'
        ]);

        $service = app(\App\Services\NotificationService::class);

        if ($request->target == 'all_donatur') {
            $users = \App\Models\Pengguna::where('Role_Pengguna', 'Donatur')->get();
        } elseif ($request->target == 'all_pengguna') {
            $users = \App\Models\Pengguna::where('Role_Pengguna', 'Pengguna')->get();
        } elseif ($request->target == 'all') {
            $users = \App\Models\Pengguna::whereIn('Role_Pengguna', ['Donatur', 'Pengguna'])->get();
        } else {
            $users = [\App\Models\Pengguna::find($request->user_id)];
        }

        $users = collect($users)->filter();

        \Log::info('Target users for notification', ['ids' => $users->pluck('ID_Pengguna')->toArray(), 'count' => $users->count()]);

        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada user yang valid untuk dikirimi notifikasi.');
        }

        foreach ($users as $user) {
            $service->createNotification($user, $request->type, $request->title, $request->message);
        }

        return redirect()->route('admin.notifications.index')->with('success', 'Notifikasi berhasil dikirim ke ' . $users->count() . ' user!');
    }
}