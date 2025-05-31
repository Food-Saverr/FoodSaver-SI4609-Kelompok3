@props(['notifications'])

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-gray-800 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span id="notification-count-pengguna" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full"
              style="{{ $notifications->where('is_read', false)->count() > 0 ? '' : 'display: none;' }}">
            {{ $notifications->where('is_read', false)->count() }}
        </span>
    </button>

    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg overflow-hidden z-50">
        <div class="p-4 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>
                <button id="mark-all-read-pengguna" class="text-sm text-blue-600 hover:text-blue-800">Mark all as read</button>
            </div>
        </div>
        
        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <div id="dropdown-notification-{{ $notification->id }}" class="p-4 {{ $notification->is_read ? 'bg-white' : 'bg-blue-50' }} hover:bg-gray-50 border-b last:border-b-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-800">{{ $notification->title }}</h4>
                            <p class="mt-1 text-sm text-gray-600">{{ Str::limit($notification->message, 50) }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        @if(!$notification->is_read)
                            <button onclick="markAsReadPengguna({{ $notification->id }})" class="text-xs text-blue-600 hover:text-blue-800">
                                Mark as read
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-gray-500">
                    No notifications
                </div>
            @endforelse
        </div>

        <div class="p-4 border-t">
            <a href="/pengguna/notifications" class="block text-center text-sm text-blue-600 hover:text-blue-800">
                View all notifications
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateNotificationCountPengguna() {
    fetch('/pengguna/notifications/unread-count', {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const countElement = document.getElementById('notification-count-pengguna');
        if (countElement) {
            countElement.textContent = data.count;
            countElement.style.display = data.count > 0 ? 'inline-flex' : 'none';
        }
    })
    .catch(error => console.error('Error fetching pengguna notification count:', error));
}

function markAsReadPengguna(id) {
    fetch(`/pengguna/notifications/${id}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const notification = document.getElementById(`dropdown-notification-${id}`);
            if (notification) {
                notification.classList.remove('bg-blue-50');
                notification.classList.add('bg-white');
                const button = notification.querySelector('button');
                if (button) {
                    button.remove();
                }
                updateNotificationCountPengguna(); // Update count after single read
            }
        } else {
            console.error('Error marking pengguna notification as read:', data.error);
            alert('Gagal menandai notifikasi pengguna sebagai dibaca: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Fetch error marking pengguna notification as read:', error);
        alert('Terjadi kesalahan saat menandai notifikasi pengguna sebagai dibaca.');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Initial count update on page load
    updateNotificationCountPengguna();

    const markAllButton = document.getElementById('mark-all-read-pengguna');
    if (markAllButton) {
        markAllButton.addEventListener('click', function() {
            fetch('/pengguna/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                 if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update all notifications visually
                    document.querySelectorAll('[id^="dropdown-notification-"]').forEach(notification => {
                        notification.classList.remove('bg-blue-50');
                        notification.classList.add('bg-white');
                        const button = notification.querySelector('button');
                        if (button) {
                            button.remove();
                        }
                    });
                    updateNotificationCountPengguna(); // Update count after marking all as read
                } else {
                    console.error('Error marking all pengguna notifications as read:', data.error);
                    alert('Gagal menandai semua notifikasi pengguna sebagai dibaca: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Fetch error marking all pengguna notifications as read:', error);
                alert('Terjadi kesalahan saat menandai semua notifikasi pengguna sebagai dibaca.');
            });
        });
    }
});
</script>
@endpush 