@extends('layouts.appadmin')

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

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

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
function markAsRead(id) {
    fetch(`/admin/notifications/${id}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notification = document.getElementById(`notification-${id}`);
            notification.classList.remove('bg-blue-50');
            notification.classList.add('bg-white');
            const button = notification.querySelector('button');
            if (button) {
                button.remove();
            }
        }
    });
}

document.getElementById('mark-all-read').addEventListener('click', function() {
    fetch('/admin/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    });
});
</script>
@endpush
@endsection 