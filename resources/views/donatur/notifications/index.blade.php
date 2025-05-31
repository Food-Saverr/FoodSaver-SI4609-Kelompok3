@extends('layouts.appdonatur')

@section('content')
<div class="container mx-auto px-4 py-8 mt-24">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
                    <div class="flex space-x-4">
                        <button id="mark-all-read" class="text-blue-600 hover:text-blue-800">
                            Mark all as read
                        </button>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse($notifications as $notification)
                    <div class="p-6 {{ $notification->is_read ? 'bg-white' : 'bg-blue-50' }}" id="notification-{{ $notification->id }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $notification->title }}</h3>
                                <p class="mt-1 text-gray-600">{{ $notification->message }}</p>
                                <p class="mt-2 text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            @if(!$notification->is_read)
                                <button onclick="markAsRead({{ $notification->id }})" class="text-blue-600 hover:text-blue-800">
                                    Mark as read
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        No notifications found
                    </div>
                @endforelse
            </div>

            <div class="p-4 border-t">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateNotificationCount() {
        fetch('/donatur/notifications/unread-count', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const countElement = document.getElementById('notification-count');
            if (countElement) {
                countElement.textContent = data.count;
                countElement.style.display = data.count > 0 ? 'inline-flex' : 'none';
            }
        })
        .catch(error => console.error('Error fetching notification count:', error));
    }

    function markAsRead(id) {
        fetch(`/donatur/notifications/${id}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
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
                const notification = document.getElementById(`notification-${id}`);
                if (notification) {
                    notification.classList.remove('bg-blue-50');
                    notification.classList.add('bg-white');
                    const button = notification.querySelector('button');
                    if (button) {
                        button.remove();
                    }
                    updateNotificationCount();
                }
            } else {
                console.error('Error:', data.error);
                alert('Gagal menandai notifikasi sebagai dibaca: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Terjadi kesalahan saat menandai notifikasi sebagai dibaca.');
        });
    }

    const markAllButton = document.getElementById('mark-all-read');
    if (markAllButton) {
        markAllButton.addEventListener('click', function() {
            fetch('/donatur/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
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
                    document.querySelectorAll('[id^="notification-"]').forEach(notification => {
                        notification.classList.remove('bg-blue-50');
                        notification.classList.add('bg-white');
                        const button = notification.querySelector('button');
                        if (button) {
                            button.remove();
                        }
                    });
                    updateNotificationCount();
                } else {
                    console.error('Error:', data.error);
                    alert('Gagal menandai semua notifikasi sebagai dibaca: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Terjadi kesalahan saat menandai semua notifikasi sebagai dibaca.');
            });
        });
    }
});
</script>
@endpush
@endsection
