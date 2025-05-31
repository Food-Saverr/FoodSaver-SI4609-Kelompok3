@php
    $role = Auth::check() ? Auth::user()->Role_Pengguna : null;
    $prefix = $role == 'Admin' ? 'admin' : ($role == 'Donatur' ? 'donatur' : 'pengguna');
@endphp

<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-gray-800 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span id="notification-badge" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg overflow-hidden z-50">
        <div class="p-4 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">notifikasi</h3>
                <button id="mark-all-read" class="text-sm text-blue-600 hover:text-blue-800">Mark all as read</button>
            </div>
        </div>
        <div class="max-h-96 overflow-y-auto" id="notifications-list">
            <!-- Notifications will be loaded here -->
        </div>
        <div class="p-4 border-t">
            <a href="{{ route($prefix . '.notifications.index') }}" class="block text-center text-blue-600 hover:text-blue-800">View all notifications</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const prefix = '{{ $prefix }}';  // Get the prefix from PHP

    function updateNotificationBadge() {
        fetch('/' + prefix + '/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notification-badge');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            });
    }

    function loadNotifications() {
        fetch('/' + prefix + '/notifications/dropdown')
            .then(response => response.text())
            .then(html => {
                document.getElementById('notifications-list').innerHTML = html;
            });
    }

    document.getElementById('mark-all-read').addEventListener('click', function(e) {
        e.preventDefault();
        fetch('/' + prefix + '/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateNotificationBadge();
                loadNotifications();
            }
        });
    });

    // Initial load
    updateNotificationBadge();
    loadNotifications();

    // Update every minute
    setInterval(updateNotificationBadge, 60000);
});
</script>
@endpush 