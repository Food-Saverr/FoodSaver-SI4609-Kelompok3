@extends('layouts.app')

@section('title', $post->judul)

@section('content')
<!-- Animated Background Elements -->
<div class="fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-[10%] -right-[10%] w-[35%] h-[40%] bg-gradient-to-br from-green-100/30 to-green-200/20 blur-3xl rounded-full animate-blob"></div>
    <div class="absolute top-[30%] -left-[5%] w-[25%] h-[30%] bg-gradient-to-br from-blue-100/20 to-green-100/20 blur-3xl rounded-full animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-[10%] right-[20%] w-[30%] h-[40%] bg-gradient-to-br from-green-100/20 to-blue-100/20 blur-3xl rounded-full animate-blob animation-delay-4000"></div>
</div>

<!-- Hero Section with Semi-transparent Overlay for better text contrast -->
<div class="relative py-10 mb-8">
    <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-500 shadow-xl"></div>
    <div class="absolute inset-0 bg-black/20"></div> <!-- Dark overlay for better text contrast -->
    
    <div class="container mx-auto px-4 relative z-10">
        <!-- Breadcrumb with improved styling -->
        <nav class="flex mb-4 text-sm" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center space-x-2">
                <li>
                    <a href="{{ route('pengguna.forum.index') }}" class="text-white hover:text-white/90 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li>
                    <a href="{{ route('pengguna.forum.index') }}" class="text-white hover:text-white/90 transition-colors">Forum</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li>
                    <span class="text-white font-medium" aria-current="page">{{ Str::limit($post->judul, 40) }}</span>
                </li>
            </ol>
        </nav>

        <!-- Post Title with Animation and improved text contrast -->
        <h1 class="mt-16 text-3xl md:text-4xl font-bold text-white mb-4 max-w-4xl animate-fadeInDown drop-shadow-lg">
            {{ $post->judul }}
        </h1>

        <!-- Redesigned Post Meta Information -->
        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 inline-block animate-fadeInUp animation-delay-300">
            <div class="flex flex-wrap items-center gap-4 text-sm text-white">
                <!-- Author info with avatar -->
                <div class="flex items-center mr-2">
                    <img src="{{ $post->pengguna->foto ? asset('storage/'.$post->pengguna->foto) : asset('images/default-avatar.png') }}" 
                        alt="{{ $post->pengguna->Nama_Pengguna }}" 
                        class="h-8 w-8 rounded-full object-cover border-2 border-white/80 mr-2"
                        onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=80'">
                    <span class="font-medium">{{ $post->pengguna->Nama_Pengguna }}</span>
                </div>
                
                <!-- Time -->
                <span class="flex items-center border-l border-white/30 pl-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $post->created_at->diffForHumans() }}
                </span>
                
                <!-- Comments count -->
                <span class="flex items-center border-l border-white/30 pl-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <span>{{ $post->comments->count() }}</span><span class="ml-1">Komentar</span>
                </span>
                
                <!-- Likes count -->
                <span class="flex items-center border-l border-white/30 pl-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span class="like-count">{{ $post->likeCount() }}</span><span class="ml-1">Suka</span>
                </span>
                
                <!-- Attachments count if any -->
                @if($post->attachments && $post->attachments->count() > 0)
                    <span class="flex items-center border-l border-white/30 pl-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <span>{{ $post->attachments->count() }}</span><span class="ml-1">Lampiran</span>
                    </span>
                @endif
                
                <!-- Updated info if post has been updated -->
                @if($post->created_at != $post->updated_at)
                    <span class="flex items-center border-l border-white/30 pl-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Diperbarui {{ $post->updated_at->diffForHumans() }}</span>
                    </span>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Decorative Wave -->
    <div class="absolute bottom-0 left-0 right-0 h-16">
        <svg class="absolute bottom-0 w-full h-16 text-white" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 74">
            <path fill="currentColor" d="M456.464 0.0433865C277.158 -1.70575 0 50.0141 0 50.0141V74H1440V50.0141C1440 50.0141 1320.4 31.1925 1243.09 27.0276C1099.33 19.2816 1019.08 53.1981 875.138 50.0141C731.199 46.8301 628.44 -0.575744 456.464 0.0433865Z" />
        </svg>
    </div>
</div>

<div class="container mx-auto px-4 pb-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content Column -->
        <div class="lg:col-span-2">
            <!-- Main Post Card -->
            <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-md mb-8 overflow-hidden border border-gray-100 animate-fadeIn hover:shadow-lg transition-all duration-300">
                <div class="p-6 md:p-8">
                    <!-- Author Information -->
                    <div class="flex items-start mb-8">
                        <div class="relative group">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-green-400 to-green-500 opacity-10 group-hover:opacity-30 transform group-hover:scale-110 transition-all"></div>
                            <img src="{{ $post->pengguna->foto ? asset('storage/'.$post->pengguna->foto) : asset('images/default-avatar.png') }}" 
                                class="w-14 h-14 rounded-full object-cover ring-2 ring-green-100 group-hover:ring-green-300 transition-all z-10 relative" 
                                alt="{{ $post->pengguna->Nama_Pengguna }}"
                                onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=80'">
                            <div class="absolute -bottom-0.5 -right-0.5 w-5 h-5 rounded-full bg-green-100 border-2 border-white flex items-center justify-center z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-grow">
                            <h4 class="font-bold text-gray-900">{{ $post->pengguna->Nama_Pengguna }}</h4>
                            <p class="text-sm text-gray-500">
                                Dibuat {{ $post->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        
                        <!-- Action Dropdown for Post Author with improved functionality -->
                        @if(Auth::id() == $post->id_user)
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>
                            <div x-show="open" 
                                 @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-10">
                                <a href="{{ route('pengguna.forum.edit', $post->ID_ForumPost) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Postingan
                                </a>
                                <form action="{{ route('pengguna.forum.destroy', $post->ID_ForumPost) }}" method="POST" class="w-full" id="delete-post-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100" onclick="return confirm('Apakah Anda yakin ingin menghapus postingan ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus Postingan
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Post Content with improved styling -->
                    <div class="post-content prose max-w-none mb-8">
                        {!! $post->konten !!}
                    </div>
                    
                    <!-- Attachments with Enhanced Design -->
                    @if($post->attachments->isNotEmpty())
                    <div class="mt-8 border-t border-gray-200 pt-6">
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
                                            <img src="{{ asset('storage/' . $attachment->path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700" alt="{{ $attachment->nama_file }}">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 flex items-center justify-center transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white opacity-0 group-hover:opacity-100 transform scale-50 group-hover:scale-100 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                </svg>
                                            </div>
                                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent text-white text-xs px-3 py-2 truncate">
                                                {{ $attachment->nama_file }}
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ asset('storage/' . $attachment->path) }}" class="block" target="_blank" rel="noopener">
                                        <div class="bg-gray-50/80 rounded-lg p-4 flex flex-col items-center justify-center h-40 hover:bg-gray-100 border border-gray-200/50 transition-colors group">
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
                                            
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 {{ $iconColor }} mb-4 transform group-hover:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                    
                    <!-- Post Actions with Animation and spacing fix -->
                    <div class="border-t border-gray-200 mt-8 pt-6">
                        <div class="grid grid-cols-2 gap-4">
                            <form action="{{ route('pengguna.forum.like', $post->ID_ForumPost) }}" method="POST" class="like-form">
                                @csrf
                                <button type="submit" class="flex items-center justify-center w-full py-3 px-4 rounded-xl bg-gray-50 hover:bg-gray-100 {{ $isLiked ? 'text-red-500 font-medium' : 'text-gray-700' }} transition-all transform hover:shadow-md group">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:scale-125 transition-transform" fill="{{ $isLiked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $isLiked ? '0' : '1.5' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span class="like-count">{{ $post->likeCount() }}</span><span class="ml-1">Suka</span>
                                </button>
                            </form>
                            <button onclick="focusCommentBox()" class="flex items-center justify-center w-full py-3 px-4 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-700 transition-all transform hover:shadow-md group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:scale-125 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <span>{{ $post->commentCount() }}</span><span class="ml-1">Komentar</span>
                            </button>
                            <!-- Report Button -->
                            <button 
                                @if(Auth::check()) 
                                    @if($post->isReportedByUser(Auth::id()))
                                        disabled
                                        class="flex items-center justify-center w-full py-3 px-4 rounded-xl bg-red-50 text-red-500 font-medium cursor-not-allowed"
                                    @else
                                        onclick="openReportModal()" 
                                        class="flex items-center justify-center w-full py-3 px-4 rounded-xl bg-gray-50 hover:bg-red-50 text-gray-700 hover:text-red-600 transition-all transform hover:-translate-y-1 group"
                                    @endif
                                @else
                                    onclick="window.location.href='{{ route('login') }}'" 
                                    class="flex items-center justify-center w-full py-3 px-4 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-700 transition-all transform hover:-translate-y-1 group"
                                @endif
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:scale-125 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                @if(Auth::check() && $post->isReportedByUser(Auth::id()))
                                    <span>Dilaporkan</span>
                                @else
                                    <span>Laporkan</span>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Comments Section -->
            <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-md mb-8 overflow-hidden border border-gray-100 animate-fadeIn animation-delay-300 hover:shadow-lg transition-all duration-300">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Komentar ({{ $post->comments->count() }})
                    </h2>
                </div>
                <div class="p-6">
                    <!-- Comment Form with Enhanced Design -->
                    <form action="{{ route('pengguna.forum.comment', $post->ID_ForumPost) }}" method="POST" class="mb-8 animate-fadeIn animation-delay-600">
                        @csrf
                        <div class="mb-4">
                            <label for="comment-box" class="block text-sm font-medium text-gray-700 mb-2">Tulis komentar sebagai <span class="font-semibold text-green-600">{{ Auth::user()->Nama_Pengguna }}</span></label>
                            <div class="relative">
                                <textarea 
                                    class="w-full px-4 py-3 border {{ $errors->has('konten') ? 'border-red-500' : 'border-gray-200' }} rounded-xl bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" 
                                    id="comment-box" 
                                    name="konten" 
                                    rows="4" 
                                    placeholder="Bagikan pemikiran Anda..." 
                                    required
                                >{{ old('konten') }}</textarea>
                                <div class="absolute right-2 bottom-2 text-xs text-gray-400" id="comment-counter">0/1000</div>
                            </div>
                            @error('konten')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="relative overflow-hidden group inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                                <span class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-700 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 relative z-10" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                                <span class="relative z-10">Kirim Komentar</span>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Comment List with Enhanced Design and better hover effect -->
                    @if($post->comments->isEmpty())
                        <div class="text-center py-16 bg-gray-50/50 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <p class="text-gray-500">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($post->comments as $index => $comment)
                                <div class="bg-gray-50/70 rounded-xl p-4 transition-all hover:bg-gray-100/80 animate-fadeIn" 
                                    @style([
                                        'animation-delay' => 300 + ($index * 100) . 'ms'
                                    ])>
                                    <div class="flex">
                                        <!-- Fixed avatar hover effect -->
                                        <div class="relative flex-shrink-0">
                                            <div class="h-10 w-10 overflow-hidden rounded-full ring-2 ring-gray-200 hover:ring-green-300 transition-all duration-300">
                                                <img src="{{ $comment->pengguna->foto ? asset('storage/'.$comment->pengguna->foto) : asset('images/default-avatar.png') }}" 
                                                     class="h-full w-full object-cover transition-transform duration-300 hover:scale-110" 
                                                     alt="{{ $comment->pengguna->Nama_Pengguna }}"
                                                     onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=80'">
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-grow">
                                            <div class="flex justify-between items-center mb-1">
                                                <h5 class="text-sm font-bold text-gray-900">{{ $comment->pengguna->Nama_Pengguna }}</h5>
                                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-700 text-sm mb-2">{{ $comment->konten }}</p>
                                            
                                            @if(Auth::id() == $comment->id_user)
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
        
        <!-- Sidebar Column -->
        <div class="space-y-6 animate-fadeIn animation-delay-600">
            <!-- Author Card -->
            <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-blue-50">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Tentang Penulis
                    </h3>
                </div>
                <div class="p-6 text-center">
                    <div class="inline-block relative mb-4 group">
                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-green-400/30 to-green-500/20 group-hover:from-green-400/40 group-hover:to-green-500/30 transform group-hover:scale-110 transition-all duration-300"></div>
                        <img src="{{ $post->pengguna->foto ? asset('storage/'.$post->pengguna->foto) : asset('images/default-avatar.png') }}" 
                             class="h-24 w-24 relative z-10 rounded-full object-cover ring-4 ring-white shadow-lg" 
                             alt="{{ $post->pengguna->Nama_Pengguna }}"
                             onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=128'">
                    </div>
                    <h4 class="mt-2 text-lg font-bold text-gray-900">{{ $post->pengguna->Nama_Pengguna }}</h4>
                    <p class="text-sm text-gray-500 mb-6">Bergabung sejak {{ $post->pengguna->created_at->format('M Y') }}</p>
                
                </div>
                
                <!-- Author Stats with improved styling -->
                <div class="grid grid-cols-3 border-t border-gray-200 bg-gradient-to-r from-green-50 to-blue-50">
                    <div class="p-4 text-center hover:bg-white/50 transition-colors">
                        <div class="text-2xl font-bold text-green-600">
                            @php
                                $postCount = $post->pengguna->forumPosts()->count();
                            @endphp
                            {{ $postCount }}
                        </div>
                        <div class="text-xs text-gray-500 mt-1">Postingan</div>
                    </div>
                    <div class="p-4 text-center border-x border-gray-200 hover:bg-white/50 transition-colors">
                        <div class="text-2xl font-bold text-green-600">
                            @php
                                $commentCount = \App\Models\ForumComment::where('id_user', $post->pengguna->id_user)->count();
                            @endphp
                            {{ $commentCount }}
                        </div>
                        <div class="text-xs text-gray-500 mt-1">Komentar</div>
                    </div>
                    <div class="p-4 text-center hover:bg-white/50 transition-colors">
                        <div class="text-2xl font-bold text-green-600">
                            @php
                                $likeCount = \App\Models\ForumLike::where('id_user', $post->pengguna->id_user)->count();
                            @endphp
                            {{ $likeCount }}
                        </div>
                        <div class="text-xs text-gray-500 mt-1">Disukai</div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Posts Card -->
            <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-green-50">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                        <a href="{{ route('pengguna.forum.show', $recentPost->ID_ForumPost) }}" class="block p-4 border-b border-gray-200 hover:bg-gray-50 transition-colors group">
                            <h5 class="font-medium text-gray-900 mb-1 line-clamp-1 group-hover:text-green-600 transition-colors">{{ $recentPost->judul }}</h5>
                            <div class="flex justify-between items-center">
                                <p class="text-xs text-gray-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $recentPost->pengguna->Nama_Pengguna }}
                                </p>
                                <span class="text-xs text-gray-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $recentPost->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="p-6 text-center">
                            <p class="text-sm text-gray-500">Belum ada diskusi lainnya.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Quick Actions Card -->
            <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-green-50">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Aksi Cepat
                    </h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('pengguna.forum.create') }}" class="flex items-center p-3 bg-gray-50 hover:bg-green-50 rounded-xl transition-colors group">
                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 text-sm">Buat Diskusi Baru</h4>
                                <p class="text-xs text-gray-500">Bagikan pemikiran Anda</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('pengguna.forum.index') }}" class="flex items-center p-3 bg-gray-50 hover:bg-blue-50 rounded-xl transition-colors group">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 text-sm">Kembali ke Forum</h4>
                                <p class="text-xs text-gray-500">Lihat semua diskusi</p>
                            </div>
                        </a>
                        
                        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="flex items-center p-3 bg-gray-50 hover:bg-amber-50 rounded-xl transition-colors group w-full text-left">
                            <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center mr-3 group-hover:bg-amber-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 text-sm">Kembali ke Atas</h4>
                                <p class="text-xs text-gray-500">Scroll ke awal halaman</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Post Share Card - New -->
            <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-blue-50">
                    <h3 class="font-bold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Bagikan Diskusi
                    </h3>
                </div>
                <div class="p-4">
                    <div class="flex justify-center space-x-4">
                        <button onclick="shareToMedia('whatsapp')" class="flex flex-col items-center p-3 hover:bg-green-50 rounded-xl transition-all">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mb-2 hover:bg-green-200 transition-colors">
                                <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </div>
                            <span class="text-xs text-gray-600">WhatsApp</span>
                        </button>
                        
                        <button onclick="shareToMedia('facebook')" class="flex flex-col items-center p-3 hover:bg-blue-50 rounded-xl transition-all">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mb-2 hover:bg-blue-200 transition-colors">
                                <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </div>
                            <span class="text-xs text-gray-600">Facebook</span>
                        </button>
                        
                        <button onclick="shareToMedia('twitter')" class="flex flex-col items-center p-3 hover:bg-blue-50 rounded-xl transition-all">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mb-2 hover:bg-blue-200 transition-colors">
                                <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </div>
                            <span class="text-xs text-gray-600">Twitter</span>
                        </button>
                        
                        <button onclick="copyToClipboard()" class="flex flex-col items-center p-3 hover:bg-gray-50 rounded-xl transition-all">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mb-2 hover:bg-gray-200 transition-colors">
                                <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </div>
                            <span class="text-xs text-gray-600">Copy Link</span>
                        </button>
                    </div>
                    <div id="copy-message" class="hidden mt-3 text-center text-xs text-green-600 font-medium py-1 bg-green-50 rounded-lg">
                        Link berhasil disalin!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="reportModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeReportModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" onclick="closeReportModal()" class="bg-white rounded-full p-1 hover:bg-gray-100 focus:outline-none">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Laporkan Postingan
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Laporkan postingan yang menurut Anda melanggar pedoman komunitas kami. Laporan Anda akan ditinjau oleh tim moderator.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5">
                    <form id="reportForm" action="{{ route('pengguna.forum.report', $post->ID_ForumPost) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="alasan_laporan" class="block text-sm font-medium text-gray-700 mb-1">Alasan Pelaporan <span class="text-red-500">*</span></label>
                            <select id="alasan_laporan" name="alasan_laporan" class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-xl" required>
                                <option value="">Pilih alasan</option>
                                <option value="spam">Spam atau Konten Promosi</option>
                                <option value="inappropriate">Konten Tidak Pantas</option>
                                <option value="harassment">Pelecehan atau Intimidasi</option>
                                <option value="violence">Konten Kekerasan</option>
                                <option value="hate_speech">Ujaran Kebencian</option>
                                <option value="false_info">Informasi Palsu</option>
                                <option value="other">Alasan Lain</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 block w-full border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-xl" placeholder="Jelaskan detail mengapa postingan ini dilaporkan..."></textarea>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" form="reportForm" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Kirim Laporan
                </button>
                <button type="button" onclick="closeReportModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<style>
    @keyframes like-pulse {
        0% { transform: scale(1); }
        30% { transform: scale(1.4); }
        60% { transform: scale(0.9); }
        100% { transform: scale(1); }
    }
    .like-animate {
        animation: like-pulse 0.45s cubic-bezier(.4,2,.6,1) both;
    }
    /* Custom Animations */
    @keyframes blob {
        0% {transform: scale(1) translate(0px, 0px);}
        33% {transform: scale(1.1) translate(20px, -20px);}
        66% {transform: scale(0.9) translate(-20px, 20px);}
        100% {transform: scale(1) translate(0px, 0px);}
    }
    
    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }
    
    .animate-fadeInDown {
        animation: fadeInDown 0.8s ease forwards;
    }
    
    .animate-fadeInUp {
        animation: fadeInUp 0.8s ease forwards;
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.8s ease forwards;
    }
    
    .animation-delay-300 {
        animation-delay: 0.3s;
    }
    
    .animation-delay-600 {
        animation-delay: 0.6s;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    .animate-blob {
        animation: blob 10s infinite alternate;
    }

    /* Line Clamp */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        line-clamp: 1; /* Add standard property */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2; /* Add standard property */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Post Content Styling */
    .post-content {
        font-size: 1.05rem;
        line-height: 1.7;
    }
    
    .post-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin: 1.5rem 0;
    }
    
    .post-content h1, .post-content h2, .post-content h3, .post-content h4 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: 700;
        line-height: 1.2;
    }
    
    .post-content h1 {
        font-size: 1.8rem;
    }
    
    .post-content h2 {
        font-size: 1.5rem;
    }
    
    .post-content h3 {
        font-size: 1.25rem;
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
        background-color: rgba(243, 244, 246, 0.5);
        padding: 1rem;
        border-radius: 0.5rem;
    }
    
    .post-content code {
        background-color: rgba(243, 244, 246, 0.7);
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-family: monospace;
        font-size: 0.9em;
    }
    
    .post-content pre {
        background-color: rgba(31, 41, 55, 0.9);
        color: #e5e7eb;
        padding: 1rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin: 1rem 0;
    }
    
    .post-content pre code {
        background-color: transparent;
        padding: 0;
        color: inherit;
    }
    
    .post-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }
    
    .post-content th, .post-content td {
        padding: 0.5rem;
        border: 1px solid #e5e7eb;
    }
    
    .post-content th {
        background-color: rgba(243, 244, 246, 0.7);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>

    // Report Modal Functions
    function openReportModal() {
        document.getElementById('reportModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeReportModal() {
        document.getElementById('reportModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    // Focus on comment box
    function focusCommentBox() {
        document.getElementById('comment-box').focus();
    }
    
    // Share to social media
    function shareToMedia(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        
        let shareUrl = '';
        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                break;
            case 'whatsapp':
                shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
                break;
        }
        
        window.open(shareUrl, '_blank', 'width=600,height=450');
    }
    
    // Copy to clipboard
    function copyToClipboard() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const messageElement = document.getElementById('copy-message');
            messageElement.classList.remove('hidden');
            setTimeout(() => {
                messageElement.classList.add('hidden');
            }, 3000);
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
    // Like functionality with AJAX
    const likeForm = document.querySelector('.like-form');
    if (likeForm) {
        likeForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Ambil CSRF token dari meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Gunakan FormData untuk mendapatkan data form
            const formData = new FormData(this);
            
            // Kirim request menggunakan fetch API dengan header yang benar
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                if (response.status === 401 || response.status === 419) {
                    window.location.href = '/login';
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (!data) return;
                
                // Update semua elemen dengan class 'like-count'
                document.querySelectorAll('.like-count').forEach(function(el) {
                    el.textContent = data.likeCount;
                });
                
                const likeBtn = likeForm.querySelector('button');
                const likeIcon = likeBtn.querySelector('svg');
                
                // Tambahkan animasi pada icon
                likeIcon.classList.remove('like-animate'); // reset jika ada
                void likeIcon.offsetWidth; // force reflow
                likeIcon.classList.add('like-animate');
                
                if (data.isLiked) {
                    likeBtn.classList.add('text-red-500', 'font-medium');
                    likeIcon.setAttribute('fill', 'currentColor');
                    likeIcon.setAttribute('stroke-width', '0');
                } else {
                    likeBtn.classList.remove('text-red-500', 'font-medium');
                    likeIcon.setAttribute('fill', 'none');
                    likeIcon.setAttribute('stroke-width', '1.5');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
        
        // Character counter for comment
        const commentBox = document.getElementById('comment-box');
        const commentCounter = document.getElementById('comment-counter');
        
        if (commentBox && commentCounter) {
            commentBox.addEventListener('input', function() {
                const characterCount = this.value.length;
                commentCounter.textContent = `${characterCount}/1000`;
                
                if (characterCount > 1000) {
                    commentCounter.classList.add('text-red-500');
                } else {
                    commentCounter.classList.remove('text-red-500');
                }
            });
        }
    
        // Initialize lightbox
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'showImageNumberLabel': false,
            'fadeDuration': 300,
        });
        
        // Direct deletion via form submission
        const deletePostForm = document.getElementById('delete-post-form');
        if (deletePostForm) {
            deletePostForm.addEventListener('submit', function(e) {
                if (!confirm('Apakah Anda yakin ingin menghapus postingan ini?')) {
                    e.preventDefault();
                }
            });
        }
    });
</script>
@endpush