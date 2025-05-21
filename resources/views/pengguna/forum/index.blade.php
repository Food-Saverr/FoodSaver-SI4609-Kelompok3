@extends('layouts.app')

@section('title', 'Forum Diskusi')

@section('content')
<!-- Animated Background Elements -->
<div class="fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-[10%] -right-[10%] w-[35%] h-[40%] bg-gradient-to-br from-green-100/30 to-green-200/20 blur-3xl rounded-full animate-blob"></div>
    <div class="absolute top-[30%] -left-[5%] w-[25%] h-[30%] bg-gradient-to-br from-blue-100/20 to-green-100/20 blur-3xl rounded-full animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-[10%] right-[20%] w-[30%] h-[40%] bg-gradient-to-br from-green-100/20 to-blue-100/20 blur-3xl rounded-full animate-blob animation-delay-4000"></div>
</div>

<!-- Hero Section -->
<div class="relative min-h-[400px] flex items-center overflow-hidden bg-gradient-to-r from-green-600 to-green-500 shadow-xl">
    <!-- Animated Shapes -->
    <div class="absolute w-96 h-96 bg-white/5 rounded-full -top-20 -right-20"></div>
    <div class="absolute w-64 h-64 bg-white/5 rounded-full bottom-0 left-1/4"></div>
    
    <!-- Hero Content -->
    <div class="container mx-auto px-4 py-16 relative z-10">
        <div class="max-w-3xl">
            <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4 flex items-center animate-fadeInDown">
                <span class="bg-white text-green-600 p-2 rounded-lg mr-4 shadow-lg transform -rotate-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                    </svg>
                </span>
                <span class="drop-shadow-xl">Forum Diskusi<br class="md:hidden"> Food Saver</span>
            </h1>
            <p class="text-white text-lg opacity-90 max-w-2xl mb-8 animate-fadeInUp animation-delay-300">
                Berbagi pengalaman, inspirasi & tips penyelamatan makanan untuk<br class="hidden md:block"> masa depan yang lebih berkelanjutan bersama komunitas.
            </p>
            
            <!-- Action Buttons with Animations -->
            <div class="flex flex-wrap gap-4 animate-fadeInUp animation-delay-600">
                <a href="{{ route('pengguna.forum.create') }}" class="relative overflow-hidden group inline-flex items-center px-6 py-3.5 bg-white text-green-600 font-medium rounded-xl shadow-lg transition-all duration-300 hover:shadow-green-900/20 transform hover:-translate-y-1">
                    <span class="absolute inset-0 bg-gradient-to-r from-white to-white/80 group-hover:scale-x-0 transition-transform origin-left duration-500"></span>
                    <span class="absolute inset-0 bg-gradient-to-r from-green-50 to-white scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 relative z-10" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="relative z-10">Buat Postingan Baru</span>
                </a>
                
                <button type="button" id="filterButton" class="relative overflow-hidden group inline-flex items-center px-6 py-3.5 bg-green-700 text-white font-medium rounded-xl shadow-lg transition-all duration-300 hover:shadow-green-900/30 transform hover:-translate-y-1">
                    <span class="absolute inset-0 bg-gradient-to-r from-green-700 to-green-600 group-hover:scale-x-0 transition-transform origin-left duration-500"></span>
                    <span class="absolute inset-0 bg-gradient-to-r from-green-800 to-green-700 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span class="relative z-10">Filter Diskusi</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Decorative Wave -->
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-b from-green-500/0 to-green-500">
        <svg class="absolute bottom-0 w-full h-16 text-white" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 74">
            <path fill="currentColor" d="M456.464 0.0433865C277.158 -1.70575 0 50.0141 0 50.0141V74H1440V50.0141C1440 50.0141 1320.4 31.1925 1243.09 27.0276C1099.33 19.2816 1019.08 53.1981 875.138 50.0141C710.527 46.3727 621.108 1.64949 456.464 0.0433865Z"></path>
        </svg>
    </div>
</div>

<!-- Container for Filter Panel and Search Bar -->
<div class="container mx-auto px-4 relative z-20">
    <!-- Filter Panel (Initially Hidden) -->
    <div id="filterPanel" class="z-30 bg-white shadow-xl rounded-2xl mx-auto max-w-3xl -mt-6 transform transition-all duration-500 scale-y-0 origin-top opacity-0 mb-4 absolute left-0 right-0">
        <div class="p-6">
            <form action="{{ route('pengguna.forum.index') }}" method="GET" class="space-y-6" id="filterForm">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kata Kunci</label>
                        <div class="relative">
                            <input type="text" name="search" placeholder="Cari berdasarkan judul atau konten" 
                                value="{{ request('search') }}" 
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-48">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select name="sort" class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            <option value="most_comments" {{ request('sort') == 'most_comments' ? 'selected' : '' }}>Banyak Komentar</option>
                        </select>
                    </div>
                </div>
            
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('pengguna.forum.index') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all">
                        Reset
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-green-600 text-white rounded-lg shadow-sm hover:shadow hover:bg-green-700 transition-all">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Bar - Moved down to provide space for filter panel -->
    <div class="max-w-2xl mx-auto mt-20">
        <div class="relative">
            <form id="quickSearchForm" action="{{ route('pengguna.forum.index') }}" method="GET">
                <input type="text" id="quickSearch" name="search" placeholder="Cari diskusi..." 
                    value="{{ request('search') }}" 
                    class="w-full py-4 pl-14 pr-12 text-gray-700 bg-white rounded-full shadow-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-300 transition-all">
                <div class="absolute inset-y-0 left-0 flex items-center pl-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-5">
                    <button type="submit" class="text-green-500 hover:text-green-600" id="quickSearchButton">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <!-- Add a clear search button when search is active -->
                @if(request('search'))
                <div class="absolute inset-y-0 right-12 flex items-center">
                    <a href="{{ route('pengguna.forum.index') }}" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                @endif
            </form>
        </div>
        <!-- If search is active, show search status and clear option -->
        @if(request('search'))
        <div class="mt-2 text-center">
            <span class="text-sm text-gray-600">
                Hasil pencarian untuk: <span class="font-medium">{{ request('search') }}</span>
                <a href="{{ route('pengguna.forum.index') }}" class="ml-2 text-green-500 hover:text-green-600 font-medium">
                    Hapus pencarian
                </a>
            </span>
        </div>
        @endif
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 pb-16 mt-8">
    @if(session('success'))
        <div id="successAlert" class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-md animate-fadeIn">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" onclick="document.getElementById('successAlert').remove()" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Posts Container -->
    @if($posts->isEmpty())
        <!-- Empty State -->
        <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl p-10 text-center transform transition-all hover:shadow-2xl animate-fadeIn">
            <div class="bg-green-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h4 class="text-2xl font-bold text-gray-800 mb-3">
                @if(request('search'))
                    Tidak ditemukan hasil pencarian untuk "{{ request('search') }}"
                @else
                    Belum ada postingan
                @endif
            </h4>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                @if(request('search'))
                    Coba gunakan kata kunci yang berbeda atau <a href="{{ route('pengguna.forum.index') }}" class="text-green-500 hover:text-green-600 font-medium">lihat semua postingan</a>.
                @else
                    Jadilah yang pertama membuat postingan di forum ini dan mulai berbagi pengalaman Anda!
                @endif
            </p>
            <a href="{{ route('pengguna.forum.create') }}" class="inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-green-500 to-green-600 text-white font-medium rounded-xl shadow-lg hover:shadow-green-200/50 transform transition-all hover:-translate-y-1 active:translate-y-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Buat Postingan Sekarang
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6 mb-10">
            <!-- Dynamic Forum Posts -->
            @foreach($posts as $post)
                <div class="animate-fadeIn animation-delay-{{ $loop->index * 100 }}">
                    <a href="{{ route('pengguna.forum.show', $post->ID_ForumPost) }}" class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 overflow-hidden block border border-gray-100/50">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:items-start">
                                <!-- User Avatar with Animation -->
                                <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6 group">
                                    <div class="relative">
                                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-green-400 to-green-500 opacity-10 group-hover:opacity-30 transform group-hover:scale-110 transition-all duration-300"></div>
                                        <img src="{{ $post->pengguna->foto ? asset('storage/'.$post->pengguna->foto) : asset('images/default-avatar.png') }}" 
                                            class="w-14 h-14 rounded-full object-cover ring-2 ring-green-100 group-hover:ring-green-300 transition-all z-10 relative" 
                                            alt="{{ $post->pengguna->nama }}"
                                            onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=80'">
                                        <div class="absolute -bottom-0.5 -right-0.5 w-5 h-5 rounded-full bg-green-100 border-2 border-white flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Post Content -->
                                <div class="flex-grow">
                                    <!-- Post Title with Hover Gradient Effect -->
                                    <h2 class="text-xl font-bold mb-2 transition-colors group-hover:text-green-700">
                                        <span class="post-title-gradient">{{ $post->judul }}</span>
                                    </h2>
                                    
                                    <!-- Post Meta Information -->
                                    <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-3">
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span class="truncate max-w-[120px]">{{ $post->pengguna->nama }}</span>
                                        </span>
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                            <span>{{ $post->comments_count ?? 0 }} Komentar</span>
                                        </span>
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            <span>{{ $post->likes_count ?? 0 }} Suka</span>
                                        </span>
                                        @if($post->attachments && $post->attachments->count() > 0)
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                </svg>
                                                <span>{{ $post->attachments->count() }} Lampiran</span>
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Post Excerpt with Fade-out Effect -->
                                    <div class="excerpt-container">
                                        <div class="text-gray-600">{{ Str::limit(strip_tags($post->konten), 200) }}</div>
                                        <div class="excerpt-fade"></div>
                                    </div>
                                    
                                    <!-- Post Tags with Animation -->
                                    @if(isset($post->tags) && count($post->tags) > 0)
                                        <div class="mt-4 flex flex-wrap gap-2">
                                            @foreach($post->tags as $tag)
                                                <span class="inline-block px-3 py-1 bg-green-100 text-green-600 text-xs font-medium rounded-full tag-bubble">
                                                    #{{ $tag->nama }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Post Thumbnail with Hover Effect -->
                                @if($post->attachments && $post->attachments->isNotEmpty() && $post->attachments->first()->isImage())
                                    <div class="flex-shrink-0 mt-4 md:mt-0 md:ml-6">
                                        <div class="w-full md:w-36 h-28 rounded-xl overflow-hidden shadow-sm group-hover:shadow-md transition-all">
                                            <div class="w-full h-full overflow-hidden">
                                                <img src="{{ asset('storage/' . $post->attachments->first()->path) }}" 
                                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-all duration-700" 
                                                    alt="Thumbnail">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Post Footer with Action Hints -->
                        <div class="bg-gray-50/80 px-6 py-3 flex justify-between items-center border-t border-gray-100">
                            <span class="text-sm text-gray-500">{{ $post->comments_count ?? 0 }} balasan • {{ $post->updated_at->diffForHumans() }}</span>
                            <span class="text-green-600 font-medium text-sm flex items-center group-hover:text-green-700">
                                <span>Baca Selengkapnya</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </span>
                        </div>
                    </a>
                </div>
            @endforeach
            
            <!-- Pagination with Custom Styling -->
            <div class="mt-10 flex justify-center">
                <div class="pagination">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
        
        <!-- Forum Stats with Enhanced Design -->
        <div class="mt-16">
            <h2 class="text-xl font-bold text-center mb-8 text-gray-800 relative">
                <span class="bg-gradient-to-r from-green-500 to-green-600 bg-clip-text text-transparent">Statistik Forum</span>
                <div class="absolute h-1 w-20 bg-green-500 bottom-0 left-1/2 transform -translate-x-1/2"></div>
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <!-- Total Discussions -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100/50 p-6 flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h10z" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $posts->total() }}</h3>
                    <p class="text-sm text-gray-500">Total Diskusi</p>
                    
                    <!-- Animated Accent Line -->
                    <div class="mt-4 w-1/2 h-1 bg-blue-100 relative overflow-hidden rounded-full">
                        <div class="absolute inset-0 bg-blue-400 animate-pulse-slow"></div>
                    </div>
                </div>
                
                <!-- Active Members -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100/50 p-6 flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ isset($activeUsers) ? $activeUsers : '250+' }}</h3>
                    <p class="text-sm text-gray-500">Member Aktif</p>
                    
                    <!-- Animated Accent Line -->
                    <div class="mt-4 w-1/2 h-1 bg-green-100 relative overflow-hidden rounded-full">
                        <div class="absolute inset-0 bg-green-400 animate-pulse-slow animation-delay-300"></div>
                    </div>
                </div>
                
                <!-- Shared Tips -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100/50 p-6 flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ isset($tipsCount) ? $tipsCount : '120+' }}</h3>
                    <p class="text-sm text-gray-500">Tips Dibagikan</p>
                    
                    <!-- Animated Accent Line -->
                    <div class="mt-4 w-1/2 h-1 bg-amber-100 relative overflow-hidden rounded-full">
                        <div class="absolute inset-0 bg-amber-400 animate-pulse-slow animation-delay-600"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Community Engagement Section -->
        <div class="mt-16 max-w-5xl mx-auto bg-gradient-to-r from-green-50 to-blue-50 rounded-3xl p-8 shadow-sm">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-6 md:mb-0 md:pr-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Jadilah Bagian dari Komunitas Food Saver</h3>
                    <p class="text-gray-600 mb-6">Bergabunglah dalam diskusi dan berbagi ide Anda untuk membangun masa depan yang lebih berkelanjutan dalam pengelolaan makanan.</p>
                    <a href="{{ route('pengguna.forum.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-medium rounded-xl shadow-lg transition-all transform hover:-translate-y-1 hover:shadow-green-200/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Mulai Menulis
                    </a>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <div class="relative">
                        <div class="absolute -top-4 -left-4 w-16 h-16 bg-green-200/50 rounded-full"></div>
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-blue-200/50 rounded-full"></div>
                        <div class="relative z-10 bg-white shadow-xl rounded-2xl p-4 transform rotate-3">
                            <img src="{{ asset('Foodsaver.png') }}" alt="Community" class="w-64 h-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    /* Custom Animations */
    @keyframes blob {
        0% {transform: scale(1) translate(0px, 0px);}
        33% {transform: scale(1.1) translate(20px, -20px);}
        66% {transform: scale(0.9) translate(-20px, 20px);}
        100% {transform: scale(1) translate(0px, 0px);}
    }
    
    @keyframes pulse-slow {
        0%, 100% {
            transform: translateX(-100%);
        }
        50% {
            transform: translateX(100%);
        }
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
    
    .animate-blob {
        animation: blob 10s infinite alternate;
    }
    
    .animate-pulse-slow {
        animation: pulse-slow 3s infinite;
    }
    
    /* Title Gradient Effect */
    .post-title-gradient {
        background-image: linear-gradient(to right, #374151, #374151);
        background-position: 0 100%;
        background-repeat: no-repeat;
        background-size: 100% 1px;
        transition: color 0.3s, background-size 0.3s;
        padding-bottom: 2px;
    }
    
    a:hover .post-title-gradient {
        color: #047857;
        background-image: linear-gradient(to right, #059669, #10B981);
        background-size: 100% 2px;
    }
    
    /* Line Clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2; /* Standar properti untuk kompatibilitas */
        -webkit-box-orient: vertical;
        box-orient: vertical; /* Standar properti untuk kompatibilitas */
        overflow: hidden;
        text-overflow: ellipsis; /* Tambahan untuk kompatibilitas yang lebih baik */
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3; /* Standar properti untuk kompatibilitas */
        -webkit-box-orient: vertical;
        box-orient: vertical; /* Standar properti untuk kompatibilitas */
        overflow: hidden;
        text-overflow: ellipsis; /* Tambahan untuk kompatibilitas yang lebih baik */
    }
    
    /* Excerpt Container with Fade Effect */
    .excerpt-container {
        position: relative;
        max-height: 4.8em;
        overflow: hidden;
        line-height: 1.6;
    }
    
    .excerpt-fade {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1.6em;
        background: linear-gradient(to bottom, transparent, white);
    }
    
    /* Tag Checkboxes */
    .tag-checkbox input:checked + span {
        background-color: #059669;
        color: white;
    }
    
    /* Tag Animation */
    .tag-bubble {
        position: relative;
        overflow: hidden;
    }
    
    .tag-bubble::after {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: all 0.6s;
    }
    
    a:hover .tag-bubble::after {
        left: 100%;
    }
    
    /* Custom Pagination Style */
    .pagination {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .pagination nav {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination span {
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        margin: 0 0.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        transition: all 0.3s;
    }
    
    .pagination .bg-gray-50 {
        background-color: rgba(249, 250, 251, 0.7);
    }
    
    .pagination a {
        color: #059669;
    }
    
    .pagination span.bg-blue-50 {
        background-color: rgba(239, 246, 255, 0.7);
        color: #059669;
        font-weight: 600;
    }
    
    .pagination a:hover {
        background-color: rgba(209, 250, 229, 0.4);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-wave {
            height: 40px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter Toggle
    const filterButton = document.getElementById('filterButton');
    const filterPanel = document.getElementById('filterPanel');
    const searchBar = document.getElementById('quickSearch');
    let filterPanelVisible = false;
    
    if (filterButton && filterPanel) {
        filterButton.addEventListener('click', function() {
            toggleFilterPanel();
        });
        
        // Close filter panel when clicking outside
        document.addEventListener('click', function(event) {
            if (filterPanelVisible && 
                !filterPanel.contains(event.target) && 
                event.target !== filterButton && 
                !filterButton.contains(event.target)) {
                hideFilterPanel();
            }
        });
    }
    
    function toggleFilterPanel() {
        if (filterPanel.classList.contains('scale-y-0')) {
            showFilterPanel();
        } else {
            hideFilterPanel();
        }
    }
    
    function showFilterPanel() {
        filterPanel.classList.remove('scale-y-0', 'opacity-0');
        filterPanel.classList.add('scale-y-100', 'opacity-100');
        filterPanelVisible = true;
    }
    
    function hideFilterPanel() {
        filterPanel.classList.remove('scale-y-100', 'opacity-100');
        filterPanel.classList.add('scale-y-0', 'opacity-0');
        filterPanelVisible = false;
    }
    
    // Quick Search Functionality
    const quickSearch = document.getElementById('quickSearch');
    const quickSearchForm = document.getElementById('quickSearchForm');
    const quickSearchButton = document.getElementById('quickSearchButton');
    
    if (quickSearch && quickSearchButton) {
        // Pre-populate search field with URL parameter if it exists
        const urlParams = new URLSearchParams(window.location.search);
        const searchParam = urlParams.get('search');
        if (searchParam) {
            quickSearch.value = searchParam;
        }
        
        quickSearchButton.addEventListener('click', function(e) {
            e.preventDefault();
            submitSearch();
        });
        
        quickSearch.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                submitSearch();
            }
        });
    }
    
    function submitSearch() {
        quickSearchForm.submit();
    }
    
    // Auto-dismiss success alert
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.classList.remove('animate-fadeIn');
            successAlert.classList.add('opacity-0');
            setTimeout(() => {
                successAlert.remove();
            }, 300);
        }, 5000);
    }
    
    // Tag Checkboxes Animation
    const tagCheckboxes = document.querySelectorAll('.tag-checkbox input');
    tagCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const span = this.nextElementSibling;
            if (this.checked) {
                span.classList.add('transform', 'scale-105');
                setTimeout(() => {
                    span.classList.remove('transform', 'scale-105');
                }, 300);
            }
        });
    });
    
    // Only show filter panel if explicitly requested by URL parameter
    const showFilter = urlParams.get('showFilter');
    if (showFilter === 'true') {
        setTimeout(() => {
            showFilterPanel();
        }, 500);
    }
    
    const resetButton = document.querySelector('button[type="reset"]');
    if (resetButton) {
        resetButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '{{ route("pengguna.forum.index") }}';
        });
    }
});
</script>
@endpush
@endsection