@extends('layouts.appadmin')

@section('title', 'Kelola Forum')

@section('content')
<!-- Page Header with Dynamic Gradient -->
<div class="relative bg-gradient-to-r from-blue-700 to-indigo-800 shadow-lg overflow-hidden">
    <!-- Decorative Patterns with reduced opacity -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-white"></div>
        <div class="absolute right-20 top-20 w-16 h-16 rounded-full bg-white"></div>
        <div class="absolute left-20 bottom-5 w-24 h-24 rounded-full bg-white"></div>
    </div>
    
    <!-- Semi-transparent overlay for better text contrast -->
    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    
    <div class="container mx-auto px-4 sm:px-6 py-10 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="text-white">
                <h1 class="mt-14 text-3xl font-bold flex items-center text-shadow">
                    <div class="p-2 bg-white bg-opacity-20 backdrop-blur-sm rounded-lg mr-3">
                        <i class="fas fa-comments text-white"></i>
                    </div>
                    Kelola Forum
                </h1>
                <p class="mt-2 text-white max-w-xl font-medium text-shadow-sm bg-black bg-opacity-10 inline-block px-3 py-1 rounded-lg">
                    Administrasi dan moderasi konten forum diskusi untuk memastikan kualitas dan keamanan komunitas
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.forum.statistics') }}" class="inline-flex items-center px-4 py-2 bg-white rounded-lg shadow-md text-blue-700 hover:bg-blue-50 transition-colors duration-200 font-medium">
                    <i class="fas fa-chart-bar mr-2"></i> Statistik Forum
                </a>
                <button type="button" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 backdrop-blur-sm border border-white border-opacity-30 rounded-lg shadow-md text-white hover:bg-opacity-30 transition-colors duration-200 font-medium">
                    <i class="fas fa-cog mr-2"></i> Pengaturan
                </button>
            </div>
        </div>
    </div>
    
    <!-- Wave Pattern with adjusted opacity -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="fill-white">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</div>

<!-- Page Content -->
<div class="bg-gray-50 min-h-screen pb-12">
    <div class="container mx-auto px-4 sm:px-6 -mt-6">
        <!-- Stats Dashboard -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Total Posts -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transform transition-all hover:shadow-lg hover:-translate-y-1">
                <div class="p-6 flex items-center">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl group-hover:scale-105 transition-transform mr-5">
                        <i class="fas fa-file-alt text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wider text-gray-500 font-medium">Total Postingan</div>
                        <div class="mt-1 flex items-center">
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalPosts) }}</h3>
                            <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i> 12%
                            </span>
                        </div>
                    </div>
                </div>
                <div class="h-1 w-full bg-gradient-to-r from-blue-500 to-blue-600"></div>
            </div>
            
            <!-- Total Comments -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transform transition-all hover:shadow-lg hover:-translate-y-1">
                <div class="p-6 flex items-center">
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl group-hover:scale-105 transition-transform mr-5">
                        <i class="fas fa-comments text-green-600 text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wider text-gray-500 font-medium">Total Komentar</div>
                        <div class="mt-1 flex items-center">
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalComments) }}</h3>
                            <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i> 8%
                            </span>
                        </div>
                    </div>
                </div>
                <div class="h-1 w-full bg-gradient-to-r from-green-500 to-green-600"></div>
            </div>
            
            <!-- Total Attachments -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transform transition-all hover:shadow-lg hover:-translate-y-1">
                <div class="p-6 flex items-center">
                    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 p-4 rounded-xl group-hover:scale-105 transition-transform mr-5">
                        <i class="fas fa-paperclip text-cyan-600 text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wider text-gray-500 font-medium">Total Lampiran</div>
                        <div class="mt-1 flex items-center">
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalAttachments) }}</h3>
                            <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i> 5%
                            </span>
                        </div>
                    </div>
                </div>
                <div class="h-1 w-full bg-gradient-to-r from-cyan-500 to-cyan-600"></div>
            </div>
            
            <!-- Deleted Posts -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transform transition-all hover:shadow-lg hover:-translate-y-1">
                <div class="p-6 flex items-center">
                    <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-xl group-hover:scale-105 transition-transform mr-5">
                        <i class="fas fa-trash-alt text-red-600 text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wider text-gray-500 font-medium">Postingan Dihapus</div>
                        <div class="mt-1 flex items-center">
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($deletedPosts) }}</h3>
                            <span class="ml-2 px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded-full flex items-center">
                                <i class="fas fa-arrow-down mr-1"></i> 3%
                            </span>
                        </div>
                    </div>
                </div>
                <div class="h-1 w-full bg-gradient-to-r from-red-500 to-red-600"></div>
            </div>
        </div>
        
        <!-- Filter & Search Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
            <div class="p-6">
                <h5 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                    <i class="fas fa-filter text-blue-600 mr-2"></i> Filter & Pencarian
                </h5>
                <form action="{{ route('admin.forum.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <!-- Search Input -->
                        <div class="md:col-span-5">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Kata Kunci</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" id="search" class="h-11 block w-full pl-10 pr-3 py-2 sm:text-sm rounded-xl border-gray-300 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
                                    placeholder="Cari berdasarkan judul atau konten..." 
                                    value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <!-- Role Filter -->
                        <div class="md:col-span-2">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <select name="role" id="role" class="h-11 block w-full py-2 px-3 rounded-xl border-gray-300 bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Role</option>
                                <option value="Pengguna" {{ request('role') == 'Pengguna' ? 'selected' : '' }}>Pengguna</option>
                                <option value="Donatur" {{ request('role') == 'Donatur' ? 'selected' : '' }}>Donatur</option>
                                <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        
                        <!-- Status Filter -->
                        <div class="md:col-span-2">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="h-11 block w-full py-2 px-3 rounded-xl border-gray-300 bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="deleted" {{ request('status') == 'deleted' ? 'selected' : '' }}>Terhapus</option>
                            </select>
                        </div>
                        
                        <!-- Sort Filter -->
                        <div class="md:col-span-3">
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                            <div class="flex space-x-2">
                                <select name="sort" id="sort" class="h-11 block w-full py-2 px-3 rounded-xl border-gray-300 bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="latest" {{ (request('sort') == 'latest' || !request('sort')) ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                                    <option value="most_comments" {{ request('sort') == 'most_comments' ? 'selected' : '' }}>Komentar Terbanyak</option>
                                </select>
                                
                                <div class="flex space-x-2">
                                    <button type="submit" class="h-11 px-5 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-colors flex items-center justify-center">
                                        <i class="fas fa-filter mr-2"></i> Filter
                                    </button>
                                    
                                    <a href="{{ route('admin.forum.index') }}" class="h-11 w-11 flex items-center justify-center border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="grid grid-cols-12 gap-8">
            <!-- Forum Posts List -->
            <div class="col-span-12 lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-list text-blue-600 mr-3 text-lg"></i>
                            <h5 class="font-bold text-gray-800 text-lg">Daftar Postingan Forum</h5>
                            <span class="ml-3 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                {{ $posts->total() }} Postingan
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" class="text-gray-500 hover:text-blue-600">
                                <i class="fas fa-download"></i>
                            </button>
                            <div class="h-4 w-px bg-gray-300"></div>
                            <button type="button" class="text-gray-500 hover:text-blue-600">
                                <i class="fas fa-print"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        @if($posts->isEmpty())
                            <div class="flex flex-col items-center justify-center py-16">
                                <div class="bg-blue-50 p-4 rounded-full mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800">Tidak Ada Postingan</h3>
                                <p class="text-gray-500 mt-2 max-w-sm text-center">Tidak ditemukan postingan forum yang sesuai dengan filter yang dipilih</p>
                                <button type="button" class="mt-4 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors font-medium">
                                    Reset Filter
                                </button>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="bg-gray-50 text-xs uppercase tracking-wider text-gray-600 font-semibold">
                                            <th class="px-6 py-3 text-left">#</th>
                                            <th class="px-6 py-3 text-left">Judul & Detail</th>
                                            <th class="px-6 py-3 text-left">Penulis</th>
                                            <th class="px-6 py-3 text-center">Statistik</th>
                                            <th class="px-6 py-3 text-center">Status</th>
                                            <th class="px-6 py-3 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($posts as $index => $post)
                                        <tr class="{{ $post->trashed() ? 'bg-red-50' : 'hover:bg-gray-50' }} transition-colors">
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $posts->firstItem() + $index }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('admin.forum.show', $post->ID_ForumPost) }}" class="text-blue-600 hover:text-blue-800 font-medium {{ $post->trashed() ? 'line-through' : '' }}">
                                                    {{ $post->judul }}
                                                    @if($post->is_reported)
                                                        <span class="inline-flex items-center ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            <i class="fas fa-flag mr-1"></i> Dilaporkan
                                                        </span>
                                                    @endif
                                                </a>
                                                <div class="flex flex-wrap items-center mt-2 text-xs">
                                                    <span class="flex items-center text-gray-500 mr-3">
                                                        <i class="far fa-clock mr-1.5"></i>
                                                        {{ $post->created_at->format('d M Y, H:i') }}
                                                    </span>
                                                    @if($post->attachments_count > 0)
                                                        <span class="flex items-center px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full mr-2">
                                                            <i class="fas fa-paperclip mr-1.5"></i>
                                                            {{ $post->attachments_count }}
                                                        </span>
                                                    @endif
                                                    <span class="flex items-center px-2 py-0.5 {{ $post->created_at->diffInHours() < 24 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }} rounded-full">
                                                        {{ $post->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="relative">
                                                        <img src="{{ $post->pengguna->foto ? asset('storage/'.$post->pengguna->foto) : 'https://ui-avatars.com/api/?name='.urlencode($post->pengguna->Nama_Pengguna).'&color=7F9CF5&background=EBF4FF' }}" 
                                                             class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm" 
                                                             alt="{{ $post->pengguna->Nama_Pengguna }}">
                                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                                                    </div>
                                                    <div class="ml-3">
                                                        <div class="text-sm font-medium text-gray-800">{{ $post->pengguna->Nama_Pengguna }}</div>
                                                        <div class="flex items-center mt-0.5">
                                                            <span class="px-1.5 py-0.5 text-xs rounded-md {{ 
                                                                $post->pengguna->Role_Pengguna == 'Admin' ? 'bg-red-100 text-red-800' : 
                                                                ($post->pengguna->Role_Pengguna == 'Donatur' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') 
                                                            }}">
                                                                {{ $post->pengguna->Role_Pengguna }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex justify-center space-x-6 text-sm">
                                                    <div class="flex flex-col items-center">
                                                        <div class="flex items-center text-gray-700">
                                                            <i class="fas fa-comments text-green-500 mr-1.5"></i>
                                                            <span class="font-semibold">{{ $post->comments_count }}</span>
                                                        </div>
                                                        <span class="text-xs text-gray-500 mt-1">Komentar</span>
                                                    </div>
                                                    <div class="flex flex-col items-center">
                                                        <div class="flex items-center text-gray-700">
                                                            <i class="fas fa-heart text-red-500 mr-1.5"></i>
                                                            <span class="font-semibold">{{ $post->likes_count }}</span>
                                                        </div>
                                                        <span class="text-xs text-gray-500 mt-1">Suka</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @if($post->trashed())
                                                    <span class="inline-flex items-center px-2.5 py-1.5 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                                        <i class="fas fa-ban mr-1"></i> Dihapus
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-1.5 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                        <i class="fas fa-check-circle mr-1"></i> Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="relative" x-data="{ open: false }">
                                                    <button @click="open = !open" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <i class="fas fa-ellipsis-v text-gray-600"></i>
                                                    </button>
                                                    <div x-show="open" 
                                                         @click.away="open = false"
                                                         x-transition:enter="transition ease-out duration-200"
                                                         x-transition:enter-start="opacity-0 scale-95"
                                                         x-transition:enter-end="opacity-100 scale-100"
                                                         x-transition:leave="transition ease-in duration-100"
                                                         x-transition:leave-start="opacity-100 scale-100"
                                                         x-transition:leave-end="opacity-0 scale-95"
                                                         class="absolute z-50 right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                                                        <div class="py-1">
                                                            <a href="{{ route('admin.forum.show', $post->ID_ForumPost) }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 group">
                                                                <i class="fas fa-eye w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                                                Lihat Detail
                                                            </a>
                                                            <a href="{{ route('admin.forum.edit', $post->ID_ForumPost) }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-yellow-600 group">
                                                                <i class="fas fa-edit w-5 h-5 mr-3 text-gray-400 group-hover:text-yellow-500"></i>
                                                                Edit Postingan
                                                            </a>
                                                        </div>
                                                        <div class="py-1">
                                                            @if($post->trashed())
                                                                <form action="{{ route('admin.forum.restore', $post->ID_ForumPost) }}" method="POST" class="delete-form">
                                                                    @csrf
                                                                    <button type="submit" class="flex w-full items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-600 group">
                                                                        <i class="fas fa-undo-alt w-5 h-5 mr-3 text-gray-400 group-hover:text-green-500"></i>
                                                                        Pulihkan Postingan
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('admin.forum.destroy', $post->ID_ForumPost) }}" method="POST" class="delete-form">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="permanent" value="1">
                                                                    <button type="submit" class="flex w-full items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 group" onclick="return confirm('PERHATIAN! Postingan ini akan dihapus secara permanen dan tidak dapat dipulihkan. Lanjutkan?')">
                                                                        <i class="fas fa-trash-alt w-5 h-5 mr-3 text-red-500"></i>
                                                                        Hapus Permanen
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <form action="{{ route('admin.forum.destroy', $post->ID_ForumPost) }}" method="POST" class="delete-form">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="flex w-full items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 group" onclick="return confirm('Apakah Anda yakin ingin menghapus postingan ini?')">
                                                                        <i class="fas fa-trash-alt w-5 h-5 mr-3 text-red-500"></i>
                                                                        Hapus Postingan
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="px-6 py-4 border-t border-gray-100">
                                {{ $posts->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-span-12 lg:col-span-4 space-y-8">
                <!-- Add this to the admin.forum.index page, in the sidebar section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-red-50 to-red-100">
                        <h5 class="font-bold text-gray-800 flex items-center">
                            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                <i class="fas fa-flag text-red-500"></i>
                            </div>
                            Laporan Forum
                        </h5>
                    </div>
                    <div class="p-6">
                        @php
                            $pendingReports = \App\Models\ForumReport::pending()->count();
                            $latestReports = \App\Models\ForumReport::with(['reporter', 'post'])
                                ->latest()
                                ->take(3)
                                ->get();
                        @endphp
                        
                        @if($pendingReports > 0)
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-red-100 text-red-800 text-sm font-medium">
                                    <i class="fas fa-exclamation-circle mr-2"></i> {{ $pendingReports }} laporan menunggu tindakan
                                </span>
                                <a href="{{ route('admin.forum.reports', ['status' => 'pending']) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    Tinjau Sekarang
                                </a>
                            </div>
                        @endif
                        
                        <div class="space-y-3 mt-3">
                            @forelse($latestReports as $report)
                                <a href="{{ route('admin.forum.reports.show', $report->ID_Report) }}" class="block p-3 rounded-lg hover:bg-gray-50 border border-gray-100 transition-colors">
                                    <div class="flex justify-between items-center mb-1">
                                        <div class="text-sm font-medium text-gray-900 truncate max-w-[200px]">
                                            {{ Str::limit($report->post->judul ?? '[Postingan Dihapus]', 35) }}
                                        </div>
                                        <span class="inline-block px-2 py-0.5 text-xs rounded-full 
                                            {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $report->status == 'reviewed' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $report->status == 'rejected' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $report->status == 'actioned' ? 'bg-green-100 text-green-800' : '' }}
                                        ">
                                            @if($report->status == 'pending')
                                                Menunggu
                                            @elseif($report->status == 'reviewed')
                                                Ditinjau
                                            @elseif($report->status == 'rejected')
                                                Ditolak
                                            @elseif($report->status == 'actioned')
                                                Ditindak
                                            @endif
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 flex items-center">
                                        <i class="fas fa-user-circle mr-1"></i>
                                        {{ $report->reporter->Nama_Pengguna }} &bull; {{ $report->created_at->diffForHumans() }}
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4 text-gray-500">
                                    Belum ada laporan forum
                                </div>
                            @endforelse
                        </div>
                        
                        <div class="mt-4 pt-3 border-t border-gray-200">
                            <a href="{{ route('admin.forum.reports') }}" class="flex items-center justify-center w-full px-4 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                                <i class="fas fa-list-ul mr-2"></i> Lihat Semua Laporan
                            </a>
                        </div>
                    </div>
                </div>   
                <!-- Top Posters Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h5 class="font-bold text-gray-800 flex items-center">
                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                <i class="fas fa-trophy text-yellow-500"></i>
                            </div>
                            Top Poster
                        </h5>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat Semua
                        </a>
                    </div>
                    <div>
                        @forelse($topPosters as $index => $user)
                            <div class="flex items-center justify-between px-6 py-3 hover:bg-blue-50 transition-colors border-l-4 {{ $index === 0 ? 'border-yellow-400' : ($index === 1 ? 'border-gray-400' : ($index === 2 ? 'border-amber-600' : 'border-transparent')) }}">
                                <div class="flex items-center space-x-3">
                                    <div class="relative">
                                        <div class="w-10 h-10 rounded-full overflow-hidden ring-2 {{ $index === 0 ? 'ring-yellow-400' : ($index === 1 ? 'ring-gray-400' : ($index === 2 ? 'ring-amber-600' : 'ring-transparent')) }}">
                                            <img src="{{ $user->foto ? asset('storage/'.$user->foto) : 'https://ui-avatars.com/api/?name='.urlencode($user->Nama_Pengguna).'&color=7F9CF5&background=EBF4FF' }}" 
                                                class="w-full h-full object-cover" alt="{{ $user->Nama_Pengguna }}">
                                        </div>
                                        @if($index < 3)
                                            <div class="absolute -top-1 -right-1 w-5 h-5 flex items-center justify-center rounded-full bg-{{ $index === 0 ? 'yellow' : ($index === 1 ? 'gray' : 'amber') }}-400 text-white text-xs font-bold border-2 border-white">
                                                {{ $index + 1 }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-800">{{ $user->Nama_Pengguna }}</div>
                                        <div class="flex items-center mt-1">
                                            <span class="px-1.5 py-0.5 text-xs rounded-md {{ 
                                                $user->Role_Pengguna == 'Admin' ? 'bg-red-100 text-red-800' : 
                                                ($user->Role_Pengguna == 'Donatur' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') 
                                            }}">
                                                {{ $user->Role_Pengguna }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <span class="inline-block px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                        {{ $user->forum_posts_count }} Post
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-users text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-500">Belum ada data</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Quick Tips Widget -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h5 class="font-bold text-gray-800 flex items-center">
                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                <i class="fas fa-lightbulb text-yellow-500"></i>
                            </div>
                            Tips Moderasi
                        </h5>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-200 flex items-center justify-center mr-3">
                                    <i class="fas fa-shield-alt text-green-600"></i>
                                </div>
                                <div>
                                    <h6 class="font-semibold text-green-800 mb-2">Pedoman Moderasi</h6>
                                    <p class="text-sm text-green-700">Pastikan semua konten mematuhi pedoman komunitas. Hapus konten yang mengandung ujaran kebencian, pelecehan, atau informasi yang menyesatkan.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-200 flex items-center justify-center mr-3">
                                    <i class="fas fa-balance-scale text-blue-600"></i>
                                </div>
                                <div>
                                    <h6 class="font-semibold text-blue-800 mb-2">Bersikap Adil</h6>
                                    <p class="text-sm text-blue-700">Terapkan aturan dengan konsisten untuk semua pengguna. Berikan peringatan sebelum mengambil tindakan moderasi yang lebih serius.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 border border-red-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-200 flex items-center justify-center mr-3">
                                    <i class="fas fa-user-shield text-red-600"></i>
                                </div>
                                <div>
                                    <h6 class="font-semibold text-red-800 mb-2">Keamanan Data</h6>
                                    <p class="text-sm text-red-700">Jangan menghapus konten secara permanen kecuali benar-benar diperlukan. Gunakan fitur soft delete untuk sebagian besar kasus.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reflection -->
                    <div class="border-t border-gray-100 p-6 bg-gradient-to-r from-gray-50 to-gray-100">
                        <h6 class="font-semibold text-gray-700 mb-2">Aktivitas Terakhir</h6>
                        <div class="flex items-center">
                            <div class="w-1 h-12 bg-blue-400 rounded-full mr-3"></div>
                            <div>
                                <p class="text-sm text-gray-600">Anda menghapus <span class="font-medium">3 postingan</span> dan memulihkan <span class="font-medium">1 postingan</span> dalam 24 jam terakhir.</p>
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-xs font-medium mt-1 inline-block">Lihat Log Aktivitas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Hidden Elements for JavaScript -->
@php
$sessionMessages = json_encode([
    'success' => session('success'),
    'error' => session('error'),
    'warning' => session('warning')
]);
@endphp

@push('scripts')
<!-- Session Data for Notifications -->
<input type="hidden" id="session-messages" 
    data-success="{{ session('success') }}" 
    data-error="{{ session('error') }}" 
    data-warning="{{ session('warning') }}">

<!-- Alpine.js for Interactions -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Chart.js for Analytics - Add to your layouts if not already included -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Sweet Alert Notifications with Enhanced Animation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Animations for UI elements
    const animateItems = document.querySelectorAll('.animate-fade-in');
    animateItems.forEach((item, index) => {
        setTimeout(() => {
            item.classList.add('opacity-100');
            item.classList.remove('opacity-0');
        }, 100 * index);
    });
    
    // Get session messages
    const sessionElement = document.getElementById('session-messages');
    const sessionData = {
        success: sessionElement.getAttribute('data-success'),
        error: sessionElement.getAttribute('data-error'),
        warning: sessionElement.getAttribute('data-warning')
    };
    
    // Configure SweetAlert toast with enhanced styling
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    
    // Show notifications if available
    if (sessionData.success) {
        Toast.fire({
            icon: 'success',
            title: sessionData.success,
            iconColor: '#10B981',
            customClass: {
                popup: 'colored-toast bg-white border-l-4 border-green-500'
            }
        });
    }
    
    if (sessionData.error) {
        Toast.fire({
            icon: 'error',
            title: sessionData.error,
            iconColor: '#EF4444',
            customClass: {
                popup: 'colored-toast bg-white border-l-4 border-red-500'
            }
        });
    }
    
    if (sessionData.warning) {
        Toast.fire({
            icon: 'warning',
            title: sessionData.warning,
            iconColor: '#F59E0B',
            customClass: {
                popup: 'colored-toast bg-white border-l-4 border-yellow-500'
            }
        });
    }
});
</script>

<style>
/* Custom Styles for Enhanced UI */

.text-shadow {
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.text-shadow-sm {
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.colored-toast {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
}

.w-1\/7 {
    width: 14.285714%;
}

/* Include Animate.css for smoother notifications - Add to your layouts if not already included */
@import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

/* Animate elements */
.animate-fade-in {
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
}
</style>
@endpush