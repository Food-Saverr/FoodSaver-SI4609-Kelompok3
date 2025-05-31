<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationPreference;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        // Explicitly get the Pengguna model instance for the authenticated user
        $penggunaUser = Pengguna::find(Auth::id());

        if (!$penggunaUser) {
            // Handle case where user is not authenticated or not found
            // Redirect or return an appropriate response, e.g., an empty collection for the view
            return view('pengguna.notifications.index', ['notifications' => collect()]);
        }

        $notifications = $penggunaUser->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $role = $penggunaUser->Role_Pengguna;
        // Assuming 'pengguna.notifications.index' view exists for regular users and 'donatur.notifications.index' for donaturs
        if ($role == 'Donatur') {
            return view('donatur.notifications.index', compact('notifications'));
        } else {
            return view('pengguna.notifications.index', compact('notifications'));
        }
    }

    public function markAsRead($id)
    {
        try {
            $penggunaUser = Pengguna::find(Auth::id());
             if (!$penggunaUser) {
                 return response()->json(['success' => false, 'error' => 'User not authenticated or invalid'], 401);
            }
            $notification = $penggunaUser->notifications()->findOrFail($id);
            $notification->update(['is_read' => true, 'read_at' => now()]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Failed to mark notification as read', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'Notification not found or unauthorized'], 404);
        }
    }

    public function markAllAsRead()
    {
        try {
            $penggunaUser = Pengguna::find(Auth::id());
             if (!$penggunaUser) {
                 return response()->json(['success' => false, 'error' => 'User not authenticated or invalid'], 401);
            }
            $updated = $penggunaUser->notifications()
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            return response()->json(['success' => true, 'updated' => $updated]);
        } catch (\Exception $e) {
            Log::error('Failed to mark all notifications as read', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'Failed to mark all notifications as read'], 500);
        }
    }

    public function preferences()
    {
        $penggunaUser = Pengguna::find(Auth::id());
         if (!$penggunaUser) {
             // Handle case where user is not authenticated or not a Pengguna instance
             // Redirect or return an appropriate response
              return redirect('/')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        $preferences = $penggunaUser->notificationPreference()->firstOrNew();
        $role = $penggunaUser->Role_Pengguna;
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
         $penggunaUser = Pengguna::find(Auth::id());
         if (!$penggunaUser) {
              return redirect('/')->with('error', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
        $data = [
            'request_status' => $request->has('request_status'),
            'new_requests' => $request->has('new_requests'),
            'maintenance' => $request->has('maintenance'),
            'announcements_enabled' => $request->has('announcements_enabled'),
            'ads_enabled' => $request->has('ads_enabled'),
        ];

        $penggunaUser->notificationPreference()->updateOrCreate(
            ['user_id' => $penggunaUser->id_user],
            $data
        );

        return redirect()->back()->with('success', 'Notification preferences updated successfully');
    }

    public function getUnreadCount()
    {
        $penggunaUser = Pengguna::find(Auth::id());
         if (!$penggunaUser) {
             return response()->json(['count' => 0]);
        }
        $count = $penggunaUser->notifications()
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function showSendForm()
    {
        // This method is likely for admin, so we should fetch Pengguna users specifically.
        $donaturs = Pengguna::where('Role_Pengguna', 'Donatur')->get();
        $penggunas = Pengguna::where('Role_Pengguna', 'Pengguna')->get();
        return view('admin.notifications.send', compact('donaturs', 'penggunas'));
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'target' => 'required|in:all_donatur,all_pengguna,all,single',
            'type' => 'required|string',
            'title' => 'required|string|max:100',
            'message' => 'required|string|max:255',
            'user_id' => 'nullable|exists:penggunas,id_user'
        ]);

        Log::info('Notification request received', [
            'target' => $request->target,
            'user_id' => $request->user_id,
            'type' => $request->type,
            'all_request_data' => $request->all()
        ]);

        // Debug: Check if users exist in database
        $allUsers = Pengguna::all();
        Log::info('All users in database', [
            'total_count' => $allUsers->count(),
            'users' => $allUsers->map(function($user) {
                return [
                    'id' => $user->id_user,
                    'name' => $user->Nama_Pengguna,
                    'role' => $user->Role_Pengguna
                ];
            })->toArray()
        ]);

        $service = app(\App\Services\NotificationService::class);

        if ($request->target == 'all_donatur') {
            $query = Pengguna::where('Role_Pengguna', 'Donatur');
            Log::info('Donatur query SQL', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
            $users = $query->get();
            Log::info('Querying all donatur users', [
                'count' => $users->count(),
                'users' => $users->map(function($user) {
                    return ['id' => $user->id_user, 'name' => $user->Nama_Pengguna];
                })->toArray()
            ]);
        } elseif ($request->target == 'all_pengguna') {
            $query = Pengguna::where('Role_Pengguna', 'Pengguna');
            Log::info('Pengguna query SQL', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
            $users = $query->get();
            Log::info('Querying all pengguna users', [
                'count' => $users->count(),
                'users' => $users->map(function($user) {
                    return ['id' => $user->id_user, 'name' => $user->Nama_Pengguna];
                })->toArray()
            ]);
        } elseif ($request->target == 'all') {
            $query = Pengguna::whereIn('Role_Pengguna', ['Donatur', 'Pengguna']);
            Log::info('All users query SQL', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
            $users = $query->get();
            Log::info('Querying all users', [
                'count' => $users->count(),
                'users' => $users->map(function($user) {
                    return ['id' => $user->id_user, 'name' => $user->Nama_Pengguna, 'role' => $user->Role_Pengguna];
                })->toArray()
            ]);
        } else { // target == 'single'
            $user = Pengguna::find($request->user_id);
            Log::info('Querying single user', [
                'user_id' => $request->user_id,
                'found' => $user ? true : false,
                'user_data' => $user ? [
                    'id' => $user->id_user,
                    'name' => $user->Nama_Pengguna,
                    'role' => $user->Role_Pengguna
                ] : null
            ]);
            $users = $user ? collect([$user]) : collect(); // Ensure $users is a collection
        }

        // Filter out any null users if a single user wasn't found
        $users = $users->filter();
        
        Log::info('Final users collection', [
            'count' => $users->count(),
            'user_ids' => $users->pluck('id_user')->toArray(),
            'roles' => $users->pluck('Role_Pengguna')->toArray(),
            'users' => $users->map(function($user) {
                return [
                    'id' => $user->id_user,
                    'name' => $user->Nama_Pengguna,
                    'role' => $user->Role_Pengguna
                ];
            })->toArray()
        ]);

        if ($users->isEmpty()) {
            Log::warning('No valid users found for notification', [
                'target' => $request->target,
                'user_id' => $request->user_id,
                'request_data' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Tidak ada user yang valid untuk dikirimi notifikasi.');
        }

        foreach ($users as $user) {
            // Use the Pengguna model instance for creating notification
            $service->createNotification($user, $request->type, $request->title, $request->message);
        }

        return redirect()->back()->with('success', 'Notifikasi berhasil dikirim ke ' . $users->count() . ' user!');
    }
}