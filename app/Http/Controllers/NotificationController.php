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
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function preferences()
    {
        $preferences = Auth::user()->notificationPreference;
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
        // Set default value jika checkbox tidak dicentang
        $data = [
            'request_status' => $request->has('request_status'),
            'new_requests' => $request->has('new_requests'),
            'maintenance' => $request->has('maintenance'),
        ];

        Auth::user()->notificationPreference()->update($data);

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

        // Filter user valid
        $users = collect($users)->filter();

        // Debug: log user target
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
