@extends('layouts.app')

@section('title', $post->judul)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-sm" aria-label="Breadcrumb">
        <ol class="flex flex-wrap items-center space-x-2">
            <li>
                <a href="{{ route('pengguna.forum.index') }}" class="text-gray-500 hover:text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                </a>
            </li>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </li>
            <li>
                <a href="{{ route('pengguna.forum.index') }}" class="text-gray-500 hover:text-green-600">Forum</a>
            </li>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </li>
            <li>
                <span class="text-gray-700 font-medium" aria-current="page">{{ Str::limit($post->judul, 40) }}</span>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Konten Utama -->
        <div class="lg:col-span-2">
            <!-- Postingan -->
            <div class="bg-white rounded-xl shadow-sm mb-8 overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center">
                            <img src="{{ $post->pengguna->foto ? asset('storage/'.$post->pengguna->foto) : asset('images/default-avatar.png') }}" 
                                class="w-12 h-12 rounded-full object-cover ring-2 ring-gray-200" alt="{{ $post->pengguna->nama }}">
                            <div class="ml-4">
                                <h4 class="font-bold text-gray-900">{{ $post->pengguna->nama }}</h4>
                                <p class="text-sm text-gray-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $post->created_at->format('d M Y, H:i') }}
                                    @if($post->created_at != $post->updated_at)
                                        <span class="ml-2 text-xs">(Diperbarui {{ $post->updated_at->diffForHumans() }})</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Dropdown menu untuk aksi -->
                        @if(Auth::id() == $post->ID_Pengguna)
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>
                            <div x-show="open" 
                                 @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-10">
                                <a href="{{ route('pengguna.forum.edit', $post->ID_ForumPost) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Postingan
                                </a>
                                <button @click="open = false" type="button" data-modal-target="deleteModal" data-modal-toggle="deleteModal" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus Postingan
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $post->judul }}</h1>
                    
                    <div class="post-content prose max-w-none mb-8">
                        {!! $post->konten !!}
                    </div>
                    
                    <!-- Attachments -->
                    @if($post->attachments->isNotEmpty())
                    <div class="mt-8 border-t border-gray-100 pt-6">
                        <h6 class="font-bold text-gray-700 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            Lampiran ({{ $post->attachments->count() }})
                        </h6>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($post->attachments as $attachment)
                                @if($attachment->isImage())
                                    <a href="{{ asset('storage/' . $attachment->path) }}" class="block" data-lightbox="post-images" data-title="{{ $attachment->nama_file }}">
                                        <div class="relative group bg-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all h-40">
                                            <img src="{{ asset('storage/' . $attachment->path) }}" class="w-full h-full object-cover group-hover:opacity-90 transition-opacity" alt="{{ $attachment->nama_file }}">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 flex items-center justify-center transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white opacity-0 group-hover:opacity-100 transform scale-50 group-hover:scale-100 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                </svg>
                                            </div>
                                            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white text-xs px-3 py-2 truncate">
                                                {{ $attachment->nama_file }}
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ asset('storage/' . $attachment->path) }}" class="block" target="_blank" rel="noopener">
                                        <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center justify-center h-40 hover:bg-gray-100 border border-gray-200 transition-colors">
                                            @php
                                                $fileExt = pathinfo($attachment->nama_file, PATHINFO_EXTENSION);
                                                $iconClass = 'document';
                                                $iconColor = 'text-blue-500';
                                                
                                                if (in_array($fileExt, ['pdf'])) {
                                                    $iconClass = 'document-text';
                                                    $iconColor = 'text-red-500';
                                                }
                                                elseif (in_array($fileExt, ['doc', 'docx'])) {
                                                    $iconClass = 'document-text';
                                                    $iconColor = 'text-blue-600';
                                                }
                                                elseif (in_array($fileExt, ['xls', 'xlsx'])) {
                                                    $iconClass = 'table';
                                                    $iconColor = 'text-green-600';
                                                }
                                            @endphp
                                            
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 {{ $iconColor }} mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-xs text-gray-700 font-medium text-center line-clamp-1 w-full">{{ $attachment->nama_file }}</span>
                                            <span class="text-xs text-gray-500 mt-1">{{ number_format($attachment->ukuran / 1024, 0) }} KB</span>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Aksi (like & comment) -->
                    <div class="border-t border-gray-100 mt-8 pt-4">
                        <div class="grid grid-cols-2 gap-4">
                            <form action="{{ route('pengguna.forum.like', $post->ID_ForumPost) }}" method="POST" class="like-form">
                                @csrf
                                <button type="submit" class="flex items-center justify-center w-full py-2.5 px-4 rounded-lg bg-gray-50 hover:bg-gray-100 {{ $isLiked ? 'text-red-500 font-medium' : 'text-gray-700' }} transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="{{ $isLiked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $isLiked ? '0' : '1.5' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span class="like-count">{{ $post->likeCount() }}</span> Suka
                                </button>
                            </form>
                            <button onclick="focusCommentBox()" class="flex items-center justify-center w-full py-2.5 px-4 rounded-lg bg-gray-50 hover:bg-gray-100 text-gray-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <span>{{ $post->commentCount() }}</span> Komentar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Komentar -->
            <div class="bg-white rounded-xl shadow-sm mb-8 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Komentar ({{ $post->comments->count() }})
                    </h2>
                </div>
                <div class="p-6">
                    <!-- Formulir komentar -->
                    <form action="{{ route('pengguna.forum.comment', $post->ID_ForumPost) }}" method="POST" class="mb-8">
                        @csrf
                        <div class="mb-4">
                            <label for="comment-box" class="block text-sm font-medium text-gray-700 mb-1">Tulis komentar</label>
                            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('konten') border-red-500 @enderror" 
                                id="comment-box" name="konten" rows="4" placeholder="Bagikan pemikiran Anda..." required>{{ old('konten') }}</textarea>
                            @error('konten')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                                Kirim Komentar
                            </button>
                        </div>
                    </form>
                    
                    <!-- Daftar komentar -->
                    @if($post->comments->isEmpty())
                        <div class="text-center py-16">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <p class="text-gray-500">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($post->comments as $comment)
                                <div class="bg-gray-50 rounded-lg p-4 transition-all hover:bg-gray-100">
                                    <div class="flex">
                                        <img src="{{ $comment->pengguna->foto ? asset('storage/'.$comment->pengguna->foto) : asset('images/default-avatar.png') }}" 
                                             class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-200" alt="{{ $comment->pengguna->nama }}">
                                        <div class="ml-3 flex-grow">
                                            <div class="flex justify-between items-center mb-1">
                                                <h5 class="text-sm font-bold text-gray-900">{{ $comment->pengguna->nama }}</h5>
                                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-700 text-sm mb-2">{{ $comment->konten }}</p>
                                            
                                            @if(Auth::id() == $comment->ID_Pengguna)
                                                <div class="text-right">
                                                    <form action="{{ route('pengguna.forum.comment.delete', $comment->ID_Comment) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 flex items-center justify-end ml-auto" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div>
            <!-- Penulis -->
            <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Tentang Penulis
                    </h3>
                </div>
                <div class="p-6 text-center">
                    <img src="{{ $post->pengguna->foto ? asset('storage/'.$post->pengguna->foto) : asset('images/default-avatar.png') }}" 
                         class="h-24 w-24 mx-auto rounded-full object-cover ring-2 ring-gray-200" alt="{{ $post->pengguna->nama }}">
                    <h4 class="mt-4 font-bold text-gray-900">{{ $post->pengguna->nama }}</h4>
                    <p class="text-sm text-gray-500 mb-6">Bergabung sejak {{ $post->pengguna->created_at->format('M Y') }}</p>
                    
                    <a href="#" class="inline-flex items-center px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Lihat Profil
                    </a>
                </div>
            </div>
            
            <!-- Postingan Terkait -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                        Diskusi Terbaru
                    </h3>
                </div>
                <div>
                    @php
                        $recentPosts = \App\Models\ForumPost::where('ID_ForumPost', '!=', $post->ID_ForumPost)
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    
                    @forelse($recentPosts as $recentPost)
                        <a href="{{ route('pengguna.forum.show', $recentPost->ID_ForumPost) }}" class="block p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <h5 class="font-medium text-gray-900 mb-1 line-clamp-1">{{ $recentPost->judul }}</h5>
                            <p class="text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $recentPost->pengguna->nama }}
                                </span>
                                <span class="flex items-center mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $recentPost->created_at->diffForHumans() }}
                                </span>
                            </p>
                        </a>
                    @empty
                        <div class="p-6 text-center">
                            <p class="text-sm text-gray-500">Belum ada diskusi lainnya.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Konfirmasi Hapus</h3>
                <p class="text-gray-700 mb-5">Apakah Anda yakin ingin menghapus postingan ini? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex items-center justify-end space-x-4">
                    <button data-modal-hide="deleteModal" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Batal
                    </button>
                    <form action="{{ route('pengguna.forum.destroy', $post->ID_ForumPost) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
                            Hapus Permanen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .post-content {
        font-size: 1.05rem;
        line-height: 1.7;
    }
    
    .post-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
    }
    
    .post-content h1, .post-content h2, .post-content h3, .post-content h4 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: 700;
        line-height: 1.2;
    }
    
    .post-content p {
        margin-bottom: 1rem;
    }
    
    .post-content ul, .post-content ol {
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }
    
    .post-content li {
        margin-bottom: 0.5rem;
    }
    
    .post-content a {
        color: #10b981;
        text-decoration: underline;
    }
    
    .post-content blockquote {
        border-left: 4px solid #e5e7eb;
        padding-left: 1rem;
        color: #6b7280;
        font-style: italic;
        margin: 1.5rem 0;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    // Focus on comment box
    function focusCommentBox() {
        document.getElementById('comment-box').focus();
    }
    
    // Like functionality with AJAX
    document.addEventListener('DOMContentLoaded', function() {
        const likeForm = document.querySelector('.like-form');
        if (likeForm) {
            likeForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(Object.fromEntries(new FormData(this)))
                })
                .then(response => response.json())
                .then(data => {
                    const likeBtn = document.querySelector('.like-form button');
                    const likeIcon = likeBtn.querySelector('svg');
                    const likeCount = likeBtn.querySelector('.like-count');
                    
                    if (data.isLiked) {
                        likeBtn.classList.add('text-red-500', 'font-medium');
                        likeIcon.setAttribute('fill', 'currentColor');
                        likeIcon.setAttribute('stroke-width', '0');
                    } else {
                        likeBtn.classList.remove('text-red-500', 'font-medium');
                        likeIcon.setAttribute('fill', 'none');
                        likeIcon.setAttribute('stroke-width', '1.5');
                    }
                    
                    likeCount.textContent = data.likeCount;
                })
                .catch(error => console.error('Error:', error));
            });
        }
    });
    
    // Initialize lightbox
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'showImageNumberLabel': false
    });
    
    // Initialize Flowbite (for modal)
    document.addEventListener('DOMContentLoaded', function() {
        const modalButtons = document.querySelectorAll('[data-modal-target]');
        const modalCloseButtons = document.querySelectorAll('[data-modal-hide]');
        const modals = document.querySelectorAll('[id^="deleteModal"]');
        
        modalButtons.forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                const modal = document.getElementById(modalId);
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });
        
        modalCloseButtons.forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-hide');
                const modal = document.getElementById(modalId);
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        });
        
        window.addEventListener('click', (event) => {
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        });
    });
</script>
@endpush