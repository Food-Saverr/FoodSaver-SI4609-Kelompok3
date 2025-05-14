@extends('layouts.app')

@section('title', 'Forum Diskusi')

@section('content')
<div class="bg-gradient-to-b from-green-50 to-white min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-500 text-white py-8 shadow-lg">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl md:text-4xl font-bold flex items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h10z" />
                </svg>
                Forum Diskusi Food Saver
            </h1>
            <p class="text-white text-lg opacity-90 max-w-2xl">
                Bagikan pengalaman dan tips tentang penyelamatan makanan bersama komunitas.
            </p>
            <div class="mt-6 flex flex-wrap gap-4">
                <a href="{{ route('pengguna.forum.create') }}" class="inline-flex items-center px-5 py-3 bg-white text-green-600 font-medium rounded-lg shadow-md transition-all transform hover:scale-105 hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Buat Postingan Baru
                </a>
                <button class="inline-flex items-center px-5 py-3 bg-green-700 hover:bg-green-800 text-white font-medium rounded-lg shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter Diskusi
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Search Bar -->
        <div class="mb-8">
            <div class="relative max-w-2xl mx-auto">
                <input type="text" placeholder="Cari diskusi..." class="w-full py-3 pl-12 pr-4 text-gray-700 bg-white rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Posts Container -->
        @if($posts->isEmpty())
            <div class="bg-white rounded-xl shadow-md p-10 text-center">
                <div class="bg-green-50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h4 class="text-2xl font-bold text-gray-800 mb-3">Belum ada postingan</h4>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">Jadilah yang pertama membuat postingan di forum ini dan mulai berbagi pengalaman Anda!</p>
                <a href="{{ route('pengguna.forum.create') }}" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Buat Postingan Sekarang
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach($posts as $post)
                    <a href="{{ route('pengguna.forum.show', $post->ID_ForumPost) }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-1 overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:items-start">
                                <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-5">
                                    <img src="{{ $post->pengguna->foto ? asset('storage/'.$post->pengguna->foto) : asset('images/default-avatar.png') }}" 
                                        class="w-12 h-12 rounded-full object-cover ring-2 ring-green-100" alt="{{ $post->pengguna->nama }}">
                                </div>
                                <div class="flex-grow">
                                    <h2 class="text-xl font-bold text-green-600 mb-2 line-clamp-2 hover:text-green-700">{{ $post->judul }}</h2>
                                    <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-3">
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $post->pengguna->nama }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                            {{ $post->comments_count }} Komentar
                                        </span>
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            {{ $post->likes_count }} Suka
                                        </span>
                                        @if($post->attachments->count() > 0)
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                {{ $post->attachments->count() }} Lampiran
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-gray-600 line-clamp-3">{{ Str::limit(strip_tags($post->konten), 200) }}</p>
                                    
                                    <!-- Post Tags if available -->
                                    @if(isset($post->tags) && count($post->tags) > 0)
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach($post->tags as $tag)
                                            <span class="inline-block px-3 py-1 bg-green-100 text-green-600 text-xs font-medium rounded-full">
                                                {{ $tag->nama }}
                                            </span>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                @if($post->attachments->isNotEmpty() && $post->attachments->first()->isImage())
                                    <div class="flex-shrink-0 mt-4 md:mt-0 md:ml-4">
                                        <div class="w-full md:w-32 h-24 rounded-lg overflow-hidden">
                                            <img src="{{ asset('storage/' . $post->attachments->first()->path) }}" 
                                                class="w-full h-full object-cover" alt="Thumbnail">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-3 flex justify-between items-center border-t border-gray-100">
                            <span class="text-sm text-gray-500">Terakhir diupdate {{ $post->updated_at->diffForHumans() }}</span>
                            <span class="text-green-600 font-medium text-sm hover:text-green-700">Lihat Detail →</span>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-10 flex justify-center">
                {{ $posts->links() }}
            </div>
            
            <!-- Quick Stats -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="bg-blue-100 rounded-lg p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h10z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Total Diskusi</p>
                            <h3 class="text-2xl font-bold">{{ $posts->total() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="bg-green-100 rounded-lg p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Member Aktif</p>
                            <h3 class="text-2xl font-bold">{{ isset($activeUsers) ? $activeUsers : '250+' }}</h3>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 rounded-lg p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Tips Dibagikan</p>
                            <h3 class="text-2xl font-bold">{{ isset($tipsCount) ? $tipsCount : '120+' }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush