@extends('layouts.appadmin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-orange-600">Edit Notifikasi Expired Reminder</h1>
            <a href="{{ route('admin.expired-reminders.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.expired-reminders.update', $notification) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Informasi Makanan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Makanan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $notification->makanan->Nama_Makanan }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Donatur</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $notification->makanan->donatur->nama_user }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">
                        Subjek Notifikasi
                    </label>
                    <input type="text" name="subject" id="subject" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('subject') border-red-500 @enderror"
                           value="{{ old('subject', $notification->subject) }}">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                        Pesan Notifikasi
                    </label>
                    <textarea name="message" id="message" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('message') border-red-500 @enderror">
                        {{ old('message', $notification->message) }}
                    </textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="send_at" class="block text-sm font-medium text-gray-700 mb-1">
                        Waktu Pengiriman
                    </label>
                    <input type="datetime-local" name="send_at" id="send_at"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('send_at') border-red-500 @enderror"
                           value="{{ old('send_at', $notification->send_at->format('Y-m-d\TH:i')) }}">
                    @error('send_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Status Notifikasi
                    </label>
                    <select name="status" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 @error('status') border-red-500 @enderror">
                        <option value="pending" {{ old('status', $notification->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="sent" {{ old('status', $notification->status) === 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="failed" {{ old('status', $notification->status) === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.expired-reminders.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
