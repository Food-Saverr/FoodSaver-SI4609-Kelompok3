@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 mt-24">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
                    <div class="flex space-x-4">
                        <a href="{{ route('pengguna.notifications.preferences') }}" class="text-blue-600 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
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

            @if($notifications->hasPages())
                <div class="p-4 border-t">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function markAsRead(id) {
    fetch(`/pengguna/notifications/${id}/mark-as-read`, {
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
    fetch('/pengguna/notifications/mark-all-read', {
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