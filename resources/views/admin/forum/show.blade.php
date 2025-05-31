@extends('layouts.appadmin')

@section('title', $post->judul)

@section('content')
<!-- CSRF Token Meta Tag -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Extra padding/margin at top to create spacing -->
<div class="pt-6 bg-gray-50"></div>

<!-- Page Header with Dynamic Gradient -->
<div class="relative bg-gradient-to-r from-blue-700 to-indigo-800 shadow-lg overflow-hidden mt-4">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-white"></div>
        <div class="absolute right-20 top-20 w-16 h-16 rounded-full bg-white"></div>
        <div class="absolute left-20 bottom-5 w-24 h-24 rounded-full bg-white"></div>
    </div>
    
    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    
    <div class="container mx-auto px-4 sm:px-6 py-10 relative z-10">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col space-y-4">
                <!-- Back to Forum Button -->
                <div class="mb-4">
                    <a href="{{ route('admin.forum.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white rounded-lg shadow-md text-blue-700 hover:bg-blue-50 transition-colors duration-200 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Forum
                    </a>
                </div>
                
                <!-- Breadcrumb Navigation -->
                <nav class="flex text-sm">
                    <ol class="flex items-center space-x-2 text-blue-100">
                        <li>
                            <a href="{{ route('admin.forum.index') }}" class="hover:text-white transition-colors duration-200">Forum</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </li>
                        <li class="text-white font-medium">Detail Postingan</li>
                    </ol>
                </nav>
                
                <!-- Post Title -->
                <h1 class="text-3xl font-bold text-white flex items-center">
                    {{ $post->judul }}
                    @if($post->trashed())
                        <span class="ml-3 px-2 py-1 bg-red-500 text-white text-sm font-medium rounded-md">
                            Dihapus
                        </span>
                    @endif
                </h1>
                
                <!-- Post Meta -->
                <div class="flex items-center text-blue-100 text-sm">
                    <span class="flex items-center">
                        <i class="fas fa-user-edit mr-1.5"></i> Oleh 
                        <span class="font-medium ml-1">{{ $post->pengguna->Nama_Pengguna }}</span>
                    </span>
                    <span class="mx-3">•</span>
                    <span class="flex items-center">
                        <i class="fas fa-clock mr-1.5"></i> 
                        {{ $post->created_at->format('d M Y, H:i') }}
                    </span>
                    @if($post->created_at != $post->updated_at)
                        <span class="ml-2 italic">(Diubah: {{ $post->updated_at->format('d M Y, H:i') }})</span>
                    @endif
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex justify-end mt-4">
                <div class="flex space-x-2">
                    @if($post->trashed())
                        <form action="{{ route('admin.forum.restore', $post->ID_ForumPost) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center">
                                <i class="fas fa-undo-alt mr-1.5"></i> Pulihkan
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('admin.forum.edit', $post->ID_ForumPost) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center">
                        <i class="fas fa-edit mr-1.5"></i> Edit
                    </a>
                    
                    <button type="button" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center" 
                            onclick="document.getElementById('deletePostModal').classList.remove('hidden')">
                        <i class="fas fa-trash-alt mr-1.5"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave Pattern -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="fill-white">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gray-50 min-h-screen pb-12 pt-4">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Post Content - Main Column -->
                <div class="lg:col-span-2">
                    <!-- Post Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                        <!-- Author Section -->
                        <div class="p-6 border-b border-gray-100 bg-gray-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ $post->pengguna->foto ? asset('storage/'.$post->pengguna->foto) : 'https://ui-avatars.com/api/?name='.urlencode($post->pengguna->Nama_Pengguna).'&color=7F9CF5&background=EBF4FF' }}" 
                                        class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm" alt="{{ $post->pengguna->Nama_Pengguna }}">
                                </div>
                                <div class="ml-4">
                                    <h5 class="text-lg font-bold text-gray-800">{{ $post->pengguna->Nama_Pengguna }}</h5>
                                    <div class="flex items-center text-sm">
                                        <span class="px-2 py-0.5 rounded-md text-xs {{ 
                                            $post->pengguna->Role_Pengguna == 'Admin' ? 'bg-red-100 text-red-800' : 
                                            ($post->pengguna->Role_Pengguna == 'Donatur' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') 
                                        }} mr-2">
                                            {{ $post->pengguna->Role_Pengguna }}
                                        </span>
                                        <span class="text-gray-500">
                                            <i class="far fa-clock mr-1"></i> Bergabung {{ $post->pengguna->created_at->format('M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Post Content -->
                        <div class="p-8 prose max-w-none">
                            {!! $post->konten !!}
                        </div>
                        
                        <!-- Attachments -->
                        @if($post->attachments->isNotEmpty())
                        <div class="px-6 pb-6 pt-2 border-t border-gray-100">
                            <h6 class="flex items-center font-bold text-gray-700 mb-4">
                                <i class="fas fa-paperclip text-blue-600 mr-2"></i>
                                Lampiran (<span id="attachment-count">{{ $post->attachments->count() }}</span>)
                            </h6>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="attachments-grid">
                                @foreach($post->attachments as $attachment)
                                    <div class="attachment-item bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                        @if($attachment->isImage())
                                            <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank" data-lightbox="post-images" data-title="{{ $attachment->nama_file }}">
                                                <div class="aspect-w-16 aspect-h-9">
                                                    <img src="{{ asset('storage/' . $attachment->path) }}" class="w-full h-full object-cover" alt="{{ $attachment->nama_file }}">
                                                </div>
                                            </a>
                                        @else
                                            <div class="aspect-w-16 aspect-h-9 bg-gray-50 flex items-center justify-center">
                                                @php
                                                    $fileExt = pathinfo($attachment->nama_file, PATHINFO_EXTENSION);
                                                    $iconClass = 'fa-file';
                                                    $bgColor = 'bg-blue-100';
                                                    $textColor = 'text-blue-600';
                                                    
                                                    if (in_array($fileExt, ['pdf'])) {
                                                        $iconClass = 'fa-file-pdf';
                                                        $bgColor = 'bg-red-100';
                                                        $textColor = 'text-red-600';
                                                    }
                                                    elseif (in_array($fileExt, ['doc', 'docx'])) {
                                                        $iconClass = 'fa-file-word';
                                                        $bgColor = 'bg-blue-100';
                                                        $textColor = 'text-blue-600';
                                                    }
                                                    elseif (in_array($fileExt, ['xls', 'xlsx'])) {
                                                        $iconClass = 'fa-file-excel';
                                                        $bgColor = 'bg-green-100';
                                                        $textColor = 'text-green-600';
                                                    }
                                                @endphp
                                                <div class="p-4 rounded-full {{ $bgColor }}">
                                                    <i class="fas {{ $iconClass }} {{ $textColor }} text-3xl"></i>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="p-4">
                                            <h6 class="font-medium text-gray-800 truncate mb-1" title="{{ $attachment->nama_file }}">
                                                {{ $attachment->nama_file }}
                                            </h6>
                                            <p class="text-xs text-gray-500 mb-3">
                                                {{ number_format($attachment->ukuran / 1024, 1) }} KB
                                            </p>
                                            <div class="flex justify-between">
                                                <a href="{{ route('admin.forum.attachment.download', $attachment->ID_Attachment) }}" 
                                                   class="px-3 py-1 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-sm font-medium transition-colors duration-200">
                                                    <i class="fas fa-download mr-1"></i> Download
                                                </a>
                                                
                                                <!-- FIXED: Using AlpineJS dropdown for attachment action -->
                                                <div class="relative" x-data="{ open: false }">
                                                    <button @click="open = !open" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-sm transition-colors duration-200">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    <div x-show="open" 
                                                         @click.away="open = false"
                                                         x-transition:enter="transition ease-out duration-200"
                                                         x-transition:enter-start="opacity-0 scale-95"
                                                         x-transition:enter-end="opacity-100 scale-100"
                                                         x-transition:leave="transition ease-in duration-100"
                                                         x-transition:leave-start="opacity-100 scale-100"
                                                         x-transition:leave-end="opacity-0 scale-95"
                                                         class="absolute right-0 bottom-10 w-48 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50">
                                                        <div class="py-1">
                                                            <form action="{{ route('admin.forum.attachment.delete', $attachment->ID_Attachment) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="redirect" value="{{ route('admin.forum.show', $post->ID_ForumPost) }}">
                                                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center" 
                                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus lampiran {{ $attachment->nama_file }}?')">
                                                                    <i class="fas fa-trash-alt mr-2"></i> Hapus Lampiran
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <!-- Post Metadata -->
                        <div class="px-6 py-4 border-t border-gray-100 flex justify-between items-center bg-gray-50">
                            <div class="flex space-x-2">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-comments mr-1.5"></i> {{ $post->comments->count() }} Komentar
                                </span>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-heart mr-1.5"></i> {{ $post->likes->count() }} Suka
                                </span>
                            </div>
                            <div class="text-xs text-gray-500">
                                ID: {{ $post->ID_ForumPost }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Post Navigation -->
                    <div class="flex justify-between mb-8">
                        @if($previousPost)
                            <a href="{{ route('admin.forum.show', $previousPost->ID_ForumPost) }}" 
                               class="flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm">
                                <i class="fas fa-chevron-left mr-1.5"></i> Postingan Sebelumnya
                            </a>
                        @else
                            <div></div>
                        @endif
                        
                        @if($nextPost)
                            <a href="{{ route('admin.forum.show', $nextPost->ID_ForumPost) }}" 
                               class="flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm">
                                Postingan Selanjutnya <i class="fas fa-chevron-right ml-1.5"></i>
                            </a>
                        @else
                            <div></div>
                        @endif
                    </div>
                    
                    <!-- Comments Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center bg-gray-50">
                            <h5 class="font-bold text-gray-800 flex items-center text-lg">
                                <i class="fas fa-comments text-blue-600 mr-3"></i>
                                Komentar ({{ $post->comments->count() }})
                            </h5>
                        </div>
                        
                        <div class="p-6">
                            @if($post->comments->isEmpty())
                                <div class="flex flex-col items-center justify-center py-8">
                                    <div class="bg-blue-50 p-4 rounded-full mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <h5 class="text-lg font-medium text-gray-800 mb-1">Belum ada komentar</h5>
                                    <p class="text-gray-500 text-center max-w-sm">Belum ada komentar pada postingan ini.</p>
                                </div>
                            @else
                                <div class="space-y-6">
                                    @foreach($post->comments as $comment)
                                        <div class="flex {{ $comment->trashed() ? 'opacity-60' : '' }}">
                                            <div class="flex-shrink-0">
                                                <img src="{{ $comment->pengguna->foto ? asset('storage/'.$comment->pengguna->foto) : 'https://ui-avatars.com/api/?name='.urlencode($comment->pengguna->Nama_Pengguna).'&color=7F9CF5&background=EBF4FF' }}" 
                                                     class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm" alt="{{ $comment->pengguna->Nama_Pengguna }}">
                                            </div>
                                            <div class="ml-3 flex-grow bg-gray-50 rounded-2xl px-4 py-3 relative">
                                                <div class="flex justify-between items-start mb-1">
                                                    <div>
                                                        <span class="font-medium text-gray-800">{{ $comment->pengguna->Nama_Pengguna }}</span>
                                                        <span class="inline-flex items-center ml-2 px-1.5 py-0.5 rounded-md text-xs {{ 
                                                            $comment->pengguna->Role_Pengguna == 'Admin' ? 'bg-red-100 text-red-800' : 
                                                            ($comment->pengguna->Role_Pengguna == 'Donatur' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') 
                                                        }}">
                                                            {{ $comment->pengguna->Role_Pengguna }}
                                                        </span>
                                                        <span class="text-gray-500 text-xs ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <!-- Comment dropdown using AlpineJS -->
                                                    <div class="relative" x-data="{ open: false }">
                                                        <button @click="open = !open" class="p-1 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
                                                             class="absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50">
                                                            <div class="py-1">
                                                                @if($comment->trashed())
                                                                    <form action="{{ route('admin.forum.comment.delete', $comment->ID_Comment) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <input type="hidden" name="permanent" value="1">
                                                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center" 
                                                                                onclick="return confirm('Hapus komentar ini secara permanen?')">
                                                                            <i class="fas fa-trash mr-2"></i> Hapus Permanen
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <form action="{{ route('admin.forum.comment.delete', $comment->ID_Comment) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center" 
                                                                                onclick="return confirm('Hapus komentar ini?')">
                                                                            <i class="fas fa-trash mr-2"></i> Hapus Komentar
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-gray-700">
                                                    {{ $comment->konten }}
                                                </div>
                                                @if($comment->trashed())
                                                    <div class="mt-2 text-sm text-red-600 flex items-center">
                                                        <i class="fas fa-info-circle mr-1.5"></i> Komentar telah dihapus
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Back to Forum Button for Mobile -->
                    <div class="block lg:hidden mb-6">
                        <a href="{{ route('admin.forum.index') }}" 
                           class="flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Forum
                        </a>
                    </div>

                    <!-- User Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h5 class="font-bold text-gray-800 flex items-center">
                                <i class="fas fa-user text-blue-600 mr-2"></i>
                                Informasi Penulis
                            </h5>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-col items-center mb-6">
                                <div class="relative">
                                    <div class="w-24 h-24 rounded-full overflow-hidden ring-4 ring-blue-100">
                                        <img src="{{ $post->pengguna->foto ? asset('storage/'.$post->pengguna->foto) : 'https://ui-avatars.com/api/?name='.urlencode($post->pengguna->Nama_Pengguna).'&color=7F9CF5&background=EBF4FF&size=150' }}" 
                                            class="w-full h-full object-cover" alt="{{ $post->pengguna->Nama_Pengguna }}">
                                    </div>
                                    <div class="absolute bottom-0 right-0 w-6 h-6 rounded-full bg-green-500 border-2 border-white"></div>
                                </div>
                                <h5 class="mt-4 text-lg font-bold text-gray-800">{{ $post->pengguna->Nama_Pengguna }}</h5>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                                    $post->pengguna->Role_Pengguna == 'Admin' ? 'bg-red-100 text-red-800' : 
                                    ($post->pengguna->Role_Pengguna == 'Donatur' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') 
                                }}">
                                    {{ $post->pengguna->Role_Pengguna }}
                                </span>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600 text-sm">Email</span>
                                    <span class="font-medium text-sm">{{ $post->pengguna->Email_Pengguna }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600 text-sm">Bergabung</span>
                                    <span class="font-medium text-sm">{{ $post->pengguna->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 text-sm">Jumlah Postingan</span>
                                    <span class="px-2.5 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                        {{ $post->pengguna->forumPosts->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- People Who Liked -->
                    @if($post->likes->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h5 class="font-bold text-gray-800 flex items-center">
                                <i class="fas fa-heart text-red-500 mr-2"></i>
                                Disukai Oleh ({{ $post->likes->count() }})
                            </h5>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach($post->likes as $like)
                                <div class="flex items-center justify-between px-6 py-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center">
                                        <img src="{{ $like->pengguna->foto ? asset('storage/'.$like->pengguna->foto) : 'https://ui-avatars.com/api/?name='.urlencode($like->pengguna->Nama_Pengguna).'&color=7F9CF5&background=EBF4FF' }}" 
                                             class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm" alt="{{ $like->pengguna->Nama_Pengguna }}">
                                        <div class="ml-3">
                                            <h6 class="text-sm font-medium text-gray-800">{{ $like->pengguna->Nama_Pengguna }}</h6>
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-xs {{ 
                                                $like->pengguna->Role_Pengguna == 'Admin' ? 'bg-red-100 text-red-800' : 
                                                ($like->pengguna->Role_Pengguna == 'Donatur' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') 
                                            }}">
                                                {{ $like->pengguna->Role_Pengguna }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $like->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Actions Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h5 class="font-bold text-gray-800 flex items-center">
                                <i class="fas fa-cog text-gray-600 mr-2"></i>
                                Tindakan Moderasi
                            </h5>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('admin.forum.edit', $post->ID_ForumPost) }}" class="flex items-center justify-center w-full px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-edit text-yellow-500 mr-2"></i> Edit Postingan
                            </a>
                            
                            @if($post->trashed())
                                <form action="{{ route('admin.forum.restore', $post->ID_ForumPost) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center justify-center w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        <i class="fas fa-undo-alt mr-2"></i> Pulihkan Postingan
                                    </button>
                                </form>
                                
                                <button type="button" class="flex items-center justify-center w-full px-4 py-2 bg-white border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition-colors" 
                                        onclick="document.getElementById('deletePostModal').classList.remove('hidden')">
                                    <i class="fas fa-trash-alt mr-2"></i> Hapus Permanen
                                </button>
                            @else
                                <button type="button" class="flex items-center justify-center w-full px-4 py-2 bg-white border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition-colors" 
                                        onclick="document.getElementById('deletePostModal').classList.remove('hidden')">
                                    <i class="fas fa-trash-alt mr-2"></i> Hapus Postingan
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Other Posts by User -->
                    @if($post->pengguna->forumPosts->count() > 1)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h5 class="font-bold text-gray-800 flex items-center">
                                <i class="fas fa-list-alt text-blue-600 mr-2"></i>
                                Postingan Lain dari Penulis
                            </h5>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach($post->pengguna->forumPosts->where('ID_ForumPost', '!=', $post->ID_ForumPost)->take(5) as $otherPost)
                                <a href="{{ route('admin.forum.show', $otherPost->ID_ForumPost) }}" class="block px-6 py-3 hover:bg-blue-50 transition-colors {{ $otherPost->trashed() ? 'line-through text-gray-500' : '' }}">
                                    <div class="flex justify-between items-start">
                                        <h6 class="text-sm font-medium text-gray-800 mb-1">{{ $otherPost->judul }}</h6>
                                        <span class="text-xs text-gray-500 ml-2">{{ $otherPost->created_at->format('d M') }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 truncate">
                                        {{ strip_tags($otherPost->konten) }}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                        <div class="px-6 py-3 bg-gray-50 text-center">
                            <a href="{{ route('admin.forum.index') }}?search={{ $post->pengguna->Nama_Pengguna }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center justify-center">
                                <i class="fas fa-search mr-1.5"></i>
                                Lihat Semua Postingan
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Back to forum button at the bottom -->
            <div class="flex justify-center mt-8 mb-4">
                <a href="{{ route('admin.forum.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Forum
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Delete Post Modal -->
<div id="deletePostModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="deletePostModalLabel">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="document.getElementById('deletePostModal').classList.add('hidden')"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="deletePostModalLabel">
                            {{ $post->trashed() ? 'Hapus Permanen Postingan' : 'Hapus Postingan' }}
                        </h3>
                        <div class="mt-4">
                            @if($post->trashed())
                                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-red-700">Peringatan: Tindakan ini tidak dapat dibatalkan!</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">Apakah Anda yakin ingin <strong>menghapus secara permanen</strong> postingan ini?</p>
                                <p class="text-sm text-gray-600 mt-2">Judul: <span class="font-semibold">{{ $post->judul }}</span></p>
                                <p class="text-sm text-gray-600 mt-2">Semua komentar, lampiran, dan data terkait juga akan dihapus secara permanen.</p>
                            @else
                                <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus postingan ini?</p>
                                <p class="text-sm text-gray-600 mt-2">Judul: <span class="font-semibold">{{ $post->judul }}</span></p>
                                <p class="text-sm text-gray-600 mt-2">Postingan akan di-nonaktifkan namun dapat dipulihkan kembali.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form action="{{ route('admin.forum.destroy', $post->ID_ForumPost) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    @if($post->trashed())
                        <input type="hidden" name="permanent" value="1">
                    @endif
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ $post->trashed() ? 'Hapus Permanen' : 'Hapus' }}
                    </button>
                </form>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm" 
                        onclick="document.getElementById('deletePostModal').classList.add('hidden')">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Meta tags for session messages -->
<meta name="session-success" content="{{ session('success') }}">
<meta name="session-error" content="{{ session('error') }}">
@endsection

@push('scripts')
<!-- Alpine.js for Interactions -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show toast for session success message
    const successMessage = document.querySelector('meta[name="session-success"]')?.getAttribute('content');
    if (successMessage && successMessage.trim() !== '') {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successMessage,
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }
    }
    
    // Show toast for session error message
    const errorMessage = document.querySelector('meta[name="session-error"]')?.getAttribute('content');
    if (errorMessage && errorMessage.trim() !== '') {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: errorMessage,
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }
    }
    
    // Initialize lightbox for images if available
    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': "Gambar %1 dari %2"
        });
    }
});
</script>

<style>
/* Animation for dropdown visibility */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Image styling for the post content */
.prose img {
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
    border-radius: 0.5rem;
}

/* Spacing and layout styles */
.aspect-w-16 {
    position: relative;
    padding-bottom: calc(var(--tw-aspect-h) / var(--tw-aspect-w) * 100%);
    --tw-aspect-w: 16;
}

.aspect-h-9 {
    --tw-aspect-h: 9;
}

.aspect-w-16 > * {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

/* Background color consistency */
.bg-gray-50 {
    background-color: #f9fafb;
}

/* Ensure Alpine.js transitions work properly */
[x-cloak] {
    display: none !important;
}
</style>
@endpush