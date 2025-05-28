@extends('layouts.appadmin')

@section('title', 'Edit Postingan Forum')

@section('content')
<!-- Extra padding/margin at top to create spacing -->
<div class="pt-6 bg-gray-50"></div>

<!-- Page Header with Dynamic Gradient -->
<div class="relative bg-gradient-to-r from-blue-700 to-indigo-800 shadow-lg overflow-hidden mt-4">
    <!-- Decorative Patterns with reduced opacity -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-white"></div>
        <div class="absolute right-20 top-20 w-16 h-16 rounded-full bg-white"></div>
        <div class="absolute left-20 bottom-5 w-24 h-24 rounded-full bg-white"></div>
    </div>
    
    <!-- Semi-transparent overlay for better text contrast -->
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
                        <li>
                            <a href="{{ route('admin.forum.show', $post->ID_ForumPost) }}" class="hover:text-white transition-colors duration-200">{{ Str::limit($post->judul, 30) }}</a>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </li>
                        <li class="text-white font-medium">Edit Postingan</li>
                    </ol>
                </nav>
                
                <!-- Page Title -->
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit Postingan Forum
                    @if($post->trashed())
                    <span class="ml-3 px-2 py-1 bg-red-500 text-white text-sm font-medium rounded-md">
                        Postingan Terhapus
                    </span>
                    @endif
                </h1>
                
                <!-- Page Description -->
                <p class="text-blue-100 max-w-3xl text-shadow-sm">
                    Kelola dan perbarui konten postingan forum dengan informasi terkini. Pastikan konten sesuai dengan pedoman komunitas.
                </p>
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
                <!-- Edit Form - Main Column -->
                <div class="lg:col-span-2">
                    <!-- Edit Form Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                        <div class="border-b border-gray-100 px-6 py-4 bg-gray-50 flex justify-between items-center">
                            <h5 class="font-bold text-gray-800 flex items-center text-lg">
                                <i class="fas fa-pen text-blue-600 mr-3"></i>
                                Edit Postingan
                            </h5>
                            @if($post->trashed())
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                    <i class="fas fa-ban mr-1"></i> Postingan terhapus
                                </span>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <form action="{{ route('admin.forum.update', $post->ID_ForumPost) }}" method="POST" enctype="multipart/form-data" id="editPostForm">
                                @csrf
                                @method('PUT')
                                
                                @if($post->trashed())
                                    <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-6 rounded-md">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-exclamation-triangle text-amber-600 text-lg"></i>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-amber-800">Postingan Telah Dihapus</h3>
                                                <div class="mt-2 text-sm text-amber-700">
                                                    <p>Postingan ini telah dihapus. Anda dapat memulihkannya saat menyimpan perubahan.</p>
                                                </div>
                                                <div class="mt-3 flex items-center">
                                                    <label class="inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-5 w-5" id="restorePost" name="restore" value="1">
                                                        <span class="ml-2 text-sm text-amber-800 font-medium">Pulihkan postingan saat menyimpan</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Post Title -->
                                <div class="mb-6">
                                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">
                                        <span class="bg-blue-100 p-1 rounded-md text-blue-600 mr-2">
                                            <i class="fas fa-heading"></i>
                                        </span>
                                        Judul Postingan
                                    </label>
                                    <div class="relative rounded-xl border {{ $errors->has('judul') ? 'border-red-500' : 'border-gray-300' }}">
                                        <input type="text" class="block w-full px-3 py-3 text-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                               id="judul" name="judul" value="{{ old('judul', $post->judul) }}" required>
                                    </div>
                                    @error('judul')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Post Content - Using textarea directly for backwards compatibility -->
                                <div class="mb-6">
                                    <label for="konten" class="block text-sm font-medium text-gray-700 mb-1">
                                        <span class="bg-indigo-100 p-1 rounded-md text-indigo-600 mr-2">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        Konten Postingan
                                    </label>
                                    
                                    <!-- Using standard textarea that will be replaced by CKEditor -->
                                    <textarea id="konten" name="konten" class="w-full px-3 py-3 text-gray-700 border {{ $errors->has('konten') ? 'border-red-500' : 'border-gray-300' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="10">{{ old('konten', $post->konten) }}</textarea>
                                    
                                    <div class="bg-gray-50 px-4 py-3 mt-2 border border-gray-200 rounded-lg flex items-center justify-between">
                                        <!-- Word Count -->
                                        <div id="word-count" class="text-xs text-gray-500">0 kata</div>
                                        <!-- Update time -->
                                        <div class="text-xs text-gray-500">
                                            <i class="far fa-clock mr-1"></i>
                                            Terakhir diperbarui: {{ $post->updated_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                    
                                    @error('konten')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- All Attachments Section (Combined) -->
                                <div class="mb-6">
                                    <div class="flex justify-between items-center mb-3">
                                        <label class="text-sm font-medium text-gray-700 flex items-center">
                                            <span class="bg-purple-100 p-1 rounded-md text-purple-600 mr-2">
                                                <i class="fas fa-paperclip"></i>
                                            </span>
                                            Lampiran
                                        </label>
                                        <!-- Attachment counter badge -->
                                        <div class="flex gap-1">
                                            <span class="px-2.5 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                {{ $post->attachments->count() }} Tersimpan
                                            </span>
                                            <span id="new-attachment-count" class="px-2.5 py-0.5 bg-green-100 text-green-800 rounded-full text-xs font-medium hidden">
                                                0 Baru
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Current Attachments -->
                                    @if($post->attachments->isNotEmpty())
                                    <div class="mb-4">
                                        <h6 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">LAMPIRAN TERSIMPAN</h6>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="current-attachments">
                                            @foreach($post->attachments as $attachment)
                                                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow group" id="attachment-{{ $attachment->ID_Attachment }}">
                                                    <div class="p-4">
                                                        <div class="flex">
                                                            <!-- Icon or Thumbnail -->
                                                            <div class="flex-shrink-0 mr-3 relative">
                                                                @if($attachment->isImage())
                                                                    <div class="relative w-16 h-16">
                                                                        <img src="{{ asset('storage/' . $attachment->path) }}" 
                                                                            alt="{{ $attachment->nama_file }}" 
                                                                            class="w-16 h-16 object-cover rounded-lg img-preview" 
                                                                            data-preview="{{ asset('storage/' . $attachment->path) }}">
                                                                        <span class="absolute top-0 right-0 bg-blue-500 text-white text-xs font-bold px-1 rounded-bl">Gambar</span>
                                                                    </div>
                                                                @else
                                                                    @php
                                                                        $fileExt = pathinfo($attachment->nama_file, PATHINFO_EXTENSION);
                                                                        $iconClass = 'fa-file';
                                                                        $bgColor = 'bg-blue-100';
                                                                        $textColor = 'text-blue-600';
                                                                        $labelText = 'File';
                                                                        $labelBg = 'bg-blue-500';
                                                                        
                                                                        if (in_array($fileExt, ['pdf'])) {
                                                                            $iconClass = 'fa-file-pdf';
                                                                            $bgColor = 'bg-red-100';
                                                                            $textColor = 'text-red-600';
                                                                            $labelText = 'PDF';
                                                                            $labelBg = 'bg-red-500';
                                                                        }
                                                                        elseif (in_array($fileExt, ['doc', 'docx'])) {
                                                                            $iconClass = 'fa-file-word';
                                                                            $bgColor = 'bg-blue-100';
                                                                            $textColor = 'text-blue-600';
                                                                            $labelText = 'DOC';
                                                                            $labelBg = 'bg-blue-600';
                                                                        }
                                                                        elseif (in_array($fileExt, ['xls', 'xlsx'])) {
                                                                            $iconClass = 'fa-file-excel';
                                                                            $bgColor = 'bg-green-100';
                                                                            $textColor = 'text-green-600';
                                                                            $labelText = 'Excel';
                                                                            $labelBg = 'bg-green-500';
                                                                        }
                                                                    @endphp
                                                                    <div class="flex justify-center items-center {{ $bgColor }} rounded-lg w-16 h-16 relative">
                                                                        <i class="fas {{ $iconClass }} {{ $textColor }} text-3xl"></i>
                                                                        <span class="absolute top-0 right-0 {{ $labelBg }} text-white text-xs font-bold px-1 rounded-bl">{{ $labelText }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            
                                                            <!-- File Info -->
                                                            <div class="flex-grow">
                                                                <h6 class="font-medium text-gray-800 truncate mb-1" title="{{ $attachment->nama_file }}">
                                                                    {{ $attachment->nama_file }}
                                                                </h6>
                                                                <p class="text-xs text-gray-500">
                                                                    {{ number_format($attachment->ukuran / 1024, 1) }} KB
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="border-t border-gray-100 px-4 py-2 flex justify-between items-center bg-gray-50">
                                                        <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                                            <i class="fas fa-eye mr-1.5"></i> Lihat
                                                        </a>
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input type="checkbox" class="rounded border-gray-300 text-red-600 focus:ring-red-500 h-4 w-4" name="deleted_attachments[]" 
                                                                value="{{ $attachment->ID_Attachment }}" id="delete-{{ $attachment->ID_Attachment }}">
                                                            <span class="ml-2 text-xs font-medium text-red-600">Hapus</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                   
                                    <!-- New Attachments Preview (Pre-uploaded) -->
                                    <div id="new-attachments-section" class="mb-4 hidden">
                                        <h6 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center">
                                            <span>LAMPIRAN BARU</span>
                                            <span class="ml-2 bg-green-100 text-green-800 text-xs py-0.5 px-1.5 rounded-full">
                                                Akan disimpan saat form disubmit
                                            </span>
                                        </h6>
                                        <div id="attachment-preview" class="grid grid-cols-1 sm:grid-cols-2 gap-4"></div>
                                    </div>

                                    <!-- Improved Dropzone -->
                                    <div class="mt-4">
                                        <div class="border-t border-gray-200 pt-4 mb-2">
                                            <h6 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">TAMBAH LAMPIRAN BARU</h6>
                                        </div>
                                        <div class="relative">
                                            <label class="flex flex-col items-center px-4 py-6 bg-white text-blue-600 rounded-xl border border-gray-300 border-dashed cursor-pointer hover:bg-blue-50 transition-colors w-full" id="dropzone">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                </svg>
                                                <span class="mt-2 text-sm text-gray-600 font-medium">Klik untuk memilih file</span>
                                                <span class="mt-1 text-xs text-gray-500">atau seret dan lepas file di sini</span>
                                                <input id="attachments" name="attachments[]" type="file" class="hidden" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx">
                                            </label>
                                            
                                            <!-- Overlay for loading state -->
                                            <div id="upload-overlay" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-80 rounded-xl hidden">
                                                <div class="text-center">
                                                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                                                    <p class="mt-2 text-sm font-medium text-blue-600" id="upload-progress-text">Memproses...</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Progress Bar -->
                                        <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden mt-2 hidden" id="upload-progress-container">
                                            <div class="h-full bg-blue-500 transition-all duration-300" id="upload-progress-bar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- File Info and Validation -->
                                    <div class="flex flex-wrap items-center gap-2 mt-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-check-circle mr-1"></i> JPG, PNG, GIF
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-file-pdf mr-1"></i> PDF
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-file-word mr-1"></i> DOC, DOCX
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            <i class="fas fa-info-circle mr-1"></i> Max 10MB
                                        </span>
                                    </div>
                                    
                                    @error('attachments.*')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Form Buttons -->
                                <div class="flex justify-between items-center mt-8">
                                    <a href="{{ route('admin.forum.show', $post->ID_ForumPost) }}" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors flex items-center">
                                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                                    </a>
                                    <button type="submit" id="submit-btn" class="px-5 py-2.5 bg-blue-600 rounded-lg text-white font-medium hover:bg-blue-700 transition-colors flex items-center">
                                        <i class="fas fa-save mr-2"></i> 
                                        <span>Simpan Perubahan</span>
                                        <span id="submit-attachment-count" class="ml-2 bg-white bg-opacity-20 text-xs py-0.5 px-1.5 rounded-full hidden">
                                            +<span id="submit-count">0</span> lampiran baru
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar Column -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Back Button for Mobile -->
                    <div class="lg:hidden mb-6">
                        <a href="{{ route('admin.forum.show', $post->ID_ForumPost) }}" 
                           class="flex items-center justify-center w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Detail Postingan
                        </a>
                    </div>
                    
                    <!-- Post Info Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="border-b border-gray-100 px-6 py-4 bg-gray-50">
                            <h5 class="font-bold text-gray-800 flex items-center">
                                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                                Informasi Postingan
                            </h5>
                        </div>
                        <div class="p-6 space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 text-sm">ID Postingan</span>
                                <span class="font-medium text-sm">{{ $post->ID_ForumPost }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 text-sm">Status</span>
                                @if($post->trashed())
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Dihapus</span>
                                @else
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Aktif</span>
                                @endif
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 text-sm">Dibuat pada</span>
                                <span class="font-medium text-sm">{{ $post->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 text-sm">Diperbarui pada</span>
                                <span class="font-medium text-sm">{{ $post->updated_at->format('d M Y, H:i') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 text-sm">Jumlah Komentar</span>
                                <span class="px-2.5 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                    {{ $post->comments->count() }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-gray-600 text-sm">Jumlah Suka</span>
                                <span class="px-2.5 py-0.5 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                    {{ $post->likes->count() }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2" id="attachment-status-sidebar">
                                <span class="text-gray-600 text-sm">Lampiran</span>
                                <div class="flex gap-1">
                                    <span class="px-2.5 py-0.5 bg-cyan-100 text-cyan-800 rounded-full text-xs font-medium">
                                        {{ $post->attachments->count() }} tersimpan
                                    </span>
                                    <span class="hidden px-2.5 py-0.5 bg-emerald-100 text-emerald-800 rounded-full text-xs font-medium" id="sidebar-new-attachment-count">
                                        0 baru
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Author Info Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="border-b border-gray-100 px-6 py-4 bg-gray-50">
                            <h5 class="font-bold text-gray-800 flex items-center">
                                <i class="fas fa-user text-blue-600 mr-2"></i>
                                Penulis
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
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 text-sm">Total Postingan</span>
                                    <span class="px-2.5 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                        {{ $post->pengguna->forumPosts->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tips Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="border-b border-gray-100 px-6 py-4 bg-gray-50">
                            <h5 class="font-bold text-gray-800 flex items-center">
                                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                Tips Moderasi
                            </h5>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-100 p-1 rounded-full">
                                    <i class="fas fa-check text-blue-600"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-700">Pastikan konten tidak melanggar ketentuan layanan.</p>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-100 p-1 rounded-full">
                                    <i class="fas fa-check text-blue-600"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-700">Hapus informasi pribadi atau sensitif jika ditemukan.</p>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 bg-blue-100 p-1 rounded-full">
                                    <i class="fas fa-check text-blue-600"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-700">Pastikan setiap attachment tidak mengandung malware atau konten berbahaya.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Back to Post Button at Bottom -->
            <div class="flex justify-center mt-8 mb-4">
                <a href="{{ route('admin.forum.show', $post->ID_ForumPost) }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Detail Postingan
                </a>
            </div>
        </div>
    </div>
</div>

<!-- File Preview Modal (For Images) -->
<div id="file-preview-modal" class="fixed inset-0 z-50 items-center justify-center hidden" aria-modal="true">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-300" id="file-preview-backdrop"></div>
    <div class="bg-white rounded-2xl max-w-3xl w-full mx-auto p-0 shadow-2xl relative top-[10%] opacity-0 transform translate-y-4 transition-all duration-300" id="file-preview-content">
        <!-- Modal Header -->
        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900 truncate" id="file-preview-title">Preview File</h3>
            <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" id="close-file-preview-modal">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-4 flex items-center justify-center min-h-[300px]" id="file-preview-body">
            <img src="" id="file-preview-image" class="max-w-full max-h-[500px] object-contain" alt="Preview">
        </div>
    </div>
</div>

<!-- Upload Success Modal -->
<div id="upload-success-modal" class="fixed inset-0 z-50 items-center justify-center hidden" aria-modal="true">
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm opacity-0 transition-opacity duration-300" id="upload-success-backdrop"></div>
    <div class="bg-white rounded-2xl max-w-md w-full mx-auto p-0 shadow-2xl relative top-[10%] opacity-0 transform translate-y-4 transition-all duration-300" id="upload-success-content">
        <!-- Modal Header -->
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check-circle text-green-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2" id="upload-success-title">File Berhasil Ditambahkan!</h3>
            <p class="text-sm text-gray-600" id="upload-success-message">File telah berhasil ditambahkan ke daftar lampiran.</p>
            <div class="bg-yellow-50 border border-yellow-100 rounded-md p-3 mt-4 text-sm text-yellow-800">
                <p><i class="fas fa-info-circle mr-1"></i> File akan disimpan ke database saat Anda menekan tombol "Simpan Perubahan".</p>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-gray-100 flex justify-center gap-3">
            <button type="button" id="add-more-files" class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                <i class="fas fa-plus mr-1"></i> Tambah Lagi
            </button>
            <button type="button" id="close-upload-success-modal" class="px-4 py-2 bg-blue-600 border border-transparent rounded-lg shadow-sm text-white hover:bg-blue-700 focus:outline-none transition-colors">
                Lanjutkan
            </button>
        </div>
    </div>
</div>

<!-- Upload Error Modal -->
<div id="upload-error-modal" class="fixed inset-0 z-50 items-center justify-center hidden" aria-modal="true">
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm opacity-0 transition-opacity duration-300" id="upload-error-backdrop"></div>
    <div class="bg-white rounded-2xl max-w-md w-full mx-auto p-0 shadow-2xl relative top-[10%] opacity-0 transform translate-y-4 transition-all duration-300" id="upload-error-content">
        <!-- Modal Header -->
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-circle text-red-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Upload Gagal</h3>
            <p class="text-sm text-gray-600" id="upload-error-message">Terjadi kesalahan saat mengunggah file. Silakan coba lagi.</p>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-gray-100 flex justify-center">
            <button type="button" id="close-upload-error-modal" class="px-4 py-2 bg-gray-600 border border-transparent rounded-lg shadow-sm text-white hover:bg-gray-700 focus:outline-none transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-4 right-4 z-50"></div>

<!-- Meta tags for session messages -->
<meta name="session-success" content="{{ session('success') }}">
<meta name="session-error" content="{{ session('error') }}">
@endsection

@push('styles')
<style>
/* File upload styles */
.preview-item {
    position: relative;
    transition: all 0.3s ease;
}

.preview-remove {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background-color: rgba(239, 68, 68, 0.8);
    color: white;
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 9999px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.2s;
}

.preview-item:hover .preview-remove {
    opacity: 1;
}

/* Animation for added elements */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-in {
    animation: fadeIn 0.3s ease-out forwards;
}

@keyframes scaleIn {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.scale-in {
    animation: scaleIn 0.3s ease-out forwards;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.5); }
    70% { box-shadow: 0 0 0 6px rgba(59, 130, 246, 0); }
    100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
}

.pulse-animation {
    animation: pulse 1.5s infinite;
}

/* Additional draggable file area */
.drag-active {
    background-color: rgba(219, 234, 254, 0.5);
    border-color: #3b82f6;
}

/* Toast notification */
@keyframes toastIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.toast {
    animation: toastIn 0.3s ease-out forwards;
}

/* Pulse Animation for Loading */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.pulse {
    animation: pulse 1.5s infinite;
}

/* CKEditor custom styling */
.ck-editor__editable {
    min-height: 300px !important;
    max-height: 600px !important;
}

.ck.ck-editor {
    width: 100% !important;
}

.ck-content {
    font-size: 1rem !important;
    line-height: 1.6 !important;
    color: #374151 !important;
}

.ck-content h3 {
    font-size: 1.25rem !important;
    font-weight: 600 !important;
    margin-bottom: 1rem !important;
    margin-top: 1.5rem !important;
}

.ck-content p {
    margin-bottom: 1rem !important;
}

.ck-content ul {
    list-style-type: disc !important;
    margin-left: 1.5rem !important;
    margin-bottom: 1rem !important;
}

.ck-content ol {
    list-style-type: decimal !important;
    margin-left: 1.5rem !important;
    margin-bottom: 1rem !important;
}

.ck-content a {
    color: #3b82f6 !important;
    text-decoration: underline !important;
}

.ck-content img {
    max-width: 100% !important;
    height: auto !important;
    margin: 1rem 0 !important;
    border-radius: 0.5rem !important;
}

/* Fix Ckeditor height issue */
.ck-editor__main {
    max-height: 600px;
    min-height: 300px; 
}

/* Progress Bar Animation */
@keyframes progressAnimation {
    0% { width: 0%; }
    20% { width: 20%; }
    40% { width: 40%; }
    60% { width: 60%; }
    80% { width: 80%; }
    100% { width: 95%; }
}

.animate-progress {
    animation: progressAnimation 1.5s ease-in-out;
}

/* File type badge */
.file-type-badge {
    position: absolute;
    top: -6px;
    left: -6px;
    padding: 2px 6px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    z-index: 1;
}

/* Highlight new attachments */
.attachment-new {
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25);
    border-color: #10B981;
    position: relative;
}

.attachment-new::before {
    content: 'Baru';
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: #10B981;
    color: white;
    font-size: 10px;
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 12px;
    z-index: 2;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.file-preview-hover:hover {
    cursor: zoom-in;
    transform: scale(1.02);
    transition: transform 0.2s;
}

/* Animated counter */
@keyframes countUp {
    from { transform: translateY(10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.counter-animation {
    animation: countUp 0.5s ease-out;
}

/* Confetti animation for success */
.confetti {
    position: absolute;
    width: 10px;
    height: 10px;
    background-color: #3b82f6;
    border-radius: 50%;
    animation: confetti 1s ease-out forwards;
    transform-origin: center;
    pointer-events: none;
    z-index: 1000;
}

@keyframes confetti {
    0% { transform: translateY(0) rotate(0deg); opacity: 1; }
    100% { transform: translateY(100px) rotate(360deg); opacity: 0; }
}

/* Loading spinner animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.img-preview {
    cursor: pointer;
    transition: all 0.2s ease;
}

.img-preview:hover {
    transform: scale(1.05);
    box-shadow: 0 0 8px rgba(59, 130, 246, 0.5);
}

.debug-info {
    position: fixed;
    bottom: 10px;
    left: 10px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 8px;
    border-radius: 4px;
    font-size: 12px;
    z-index: 9999;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug info panel (akan muncul di pojok kiri bawah)
    const debugMode = true; // Set ke true untuk mengaktifkan debug info
    let debugPanel;
    
    if (debugMode) {
        debugPanel = document.createElement('div');
        debugPanel.className = 'debug-info';
        debugPanel.innerHTML = 'Upload Debug: Menunggu aktivitas...';
        document.body.appendChild(debugPanel);
    }
    
    function updateDebugInfo(message) {
        if (debugMode && debugPanel) {
            debugPanel.innerHTML = `Upload Debug: ${message}`;
            console.log(`Debug: ${message}`);
        }
    }

    // Tracking added attachments
    let newAttachmentCount = 0;
    const newAttachmentCountEl = document.getElementById('new-attachment-count');
    const submitAttachmentCount = document.getElementById('submit-attachment-count');
    const submitCount = document.getElementById('submit-count');
    const sidebarNewAttachmentCount = document.getElementById('sidebar-new-attachment-count');
    const newAttachmentsSection = document.getElementById('new-attachments-section');

    // Ambil textarea element
    const kontenTextarea = document.getElementById('konten');
    
    updateDebugInfo('Initializing editor and components...');
    
    // Inisialisasi CKEditor dengan konfigurasi yang lebih lengkap
    ClassicEditor
        .create(kontenTextarea, {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'bulletedList', 'numberedList', '|',
                'link', 'imageUpload', '|',
                'alignment', '|',
                'undo', 'redo'
            ],
            placeholder: 'Tulis konten postingan di sini...',
            language: 'id'
        })
        .then(editor => {
            // Sukses membuat editor
            updateDebugInfo('CKEditor initialized successfully');
            
            // Update word count pada setiap perubahan
            editor.model.document.on('change:data', () => {
                updateWordCount(editor);
            });
            
            // Hitung kata awal
            updateWordCount(editor);
            
            // Show success notification
            showToast('Editor konten berhasil dimuat', 'success');
        })
        .catch(error => {
            // Log error dan fallback ke textarea biasa
            updateDebugInfo(`CKEditor failed: ${error.message}`);
            showToast('Gagal memuat editor, menggunakan textarea standar', 'error');
            
            // Tampilkan textarea jika CKEditor gagal dimuat
            kontenTextarea.style.display = 'block';
            kontenTextarea.style.minHeight = '300px';
        });

    // Form dan elemen lainnya
    const form = document.getElementById('editPostForm');
    const submitBtn = document.getElementById('submit-btn');
    
    // Fungsi untuk menghitung jumlah kata
    function updateWordCount(editor) {
        const text = editor.getData().replace(/<[^>]*>/g, ' ');
        const words = text.trim().split(/\s+/).filter(word => word.length > 0);
        const count = words.length;
        document.getElementById('word-count').textContent = count + ' kata';
    }
    
    // ==== UPLOAD FUNCTIONALITY - ENHANCED ==== 
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('attachments');
    const attachmentPreview = document.getElementById('attachment-preview');
    const uploadOverlay = document.getElementById('upload-overlay');
    const progressContainer = document.getElementById('upload-progress-container');
    const progressBar = document.getElementById('upload-progress-bar');
    const progressText = document.getElementById('upload-progress-text');
    
    // File validation constants
    const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB
    const ALLOWED_TYPES = [
        'image/jpeg', 'image/jpg', 'image/png', 'image/gif', 
        'application/pdf', 
        'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    
    // Handle file input change - PERBAIKAN: Peningkatan robust error handling
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            e.preventDefault();
            const files = this.files;
            
            updateDebugInfo(`File input change detected. Files: ${files?.length || 0}`);
            
            if (files && files.length > 0) {
                // Show loading overlay
                showUploadingState();
                
                // Validate and handle files
                validateAndProcessFiles(files);
            } else {
                updateDebugInfo('No files selected');
            }
        });
    } else {
        updateDebugInfo('ERROR: File input element not found!');
    }
    
    // Open file dialog when dropzone is clicked - PERBAIKAN: Menambahkan debug info
    if (dropzone) {
        dropzone.addEventListener('click', function(e) {
            updateDebugInfo('Dropzone clicked');
            
            // Don't trigger if we're clicking on children elements that already have their own behaviors
            if (e.target === this || e.target.tagName !== 'INPUT') {
                fileInput.click();
            }
        });
        
        // Prevent default behavior for drag events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });
        
        // Highlight drop area when dragging over it with animation
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });
        
        // Handle dropped files
        dropzone.addEventListener('drop', function(e) {
            const files = e.dataTransfer.files;
            updateDebugInfo(`Files dropped. Count: ${files.length}`);
            
            if (files && files.length > 0) {
                // Show loading overlay
                showUploadingState();
                
                // Validate and handle files
                validateAndProcessFiles(files);
            }
        });
    } else {
        updateDebugInfo('ERROR: Dropzone element not found!');
    }
    
    // Helper functions for file upload
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight() {
        updateDebugInfo('Drag hover: highlighting dropzone');
        dropzone.classList.add('drag-active');
        dropzone.classList.add('ring-2', 'ring-blue-500');
    }

    function unhighlight() {
        updateDebugInfo('Drag leave/drop: unhighlighting dropzone');
        dropzone.classList.remove('drag-active');
        dropzone.classList.remove('ring-2', 'ring-blue-500');
    }
    
    // Function to show uploading state with progress bar - PERBAIKAN: Memperjelas tampilan loading
    function showUploadingState() {
        updateDebugInfo('Showing upload loading state');
        
        if (uploadOverlay && progressContainer && progressBar) {
            uploadOverlay.classList.remove('hidden');
            uploadOverlay.classList.add('flex');
            progressContainer.classList.remove('hidden');
            
            // Reset progress
            progressBar.style.width = '0%';
            
            // Animate progress bar
            progressBar.classList.add('animate-progress');
            
            // Simulate progress until actual processing is done
            let progress = 0;
            const interval = setInterval(() => {
                progress += 5;
                if (progress > 90) {
                    clearInterval(interval);
                } else {
                    progressBar.style.width = progress + '%';
                    if (progressText) {
                        progressText.textContent = 'Memproses... ' + progress + '%';
                    }
                    updateDebugInfo(`Upload progress: ${progress}%`);
                }
            }, 100);
            
            return interval;
        } else {
            updateDebugInfo('ERROR: Upload overlay or progress elements missing!');
            console.error('Missing elements:', { uploadOverlay, progressContainer, progressBar });
            return null;
        }
    }
    
    // Function to hide uploading state - PERBAIKAN: Memperjelas pengecekan elemen
    function hideUploadingState() {
        updateDebugInfo('Hiding upload state');
        
        if (uploadOverlay) uploadOverlay.classList.add('hidden');
        if (uploadOverlay) uploadOverlay.classList.remove('flex');
        if (progressContainer) progressContainer.classList.add('hidden');
        if (progressBar) progressBar.classList.remove('animate-progress');
    }
    
    // Show upload complete state - PERBAIKAN: Menambahkan validasi elemen
    function showUploadComplete() {
        updateDebugInfo('Upload complete!');
        
        if (progressBar && progressText) {
            progressBar.style.width = '100%';
            progressText.textContent = 'Selesai!';
            
            setTimeout(() => {
                hideUploadingState();
            }, 500);
        } else {
            updateDebugInfo('ERROR: Progress elements missing!');
            hideUploadingState();
        }
    }
    
    // Validate files before processing - PERBAIKAN: Lebih jelas tampilkan file info
    function validateAndProcessFiles(files) {
        let validFiles = [];
        let invalidFiles = [];
        
        updateDebugInfo(`Validating ${files.length} files...`);
        
        Array.from(files).forEach((file, index) => {
            updateDebugInfo(`Checking file ${index+1}: ${file.name} (${formatFileSize(file.size)}, ${file.type})`);
            
            // Check file size and type
            if (file.size > MAX_FILE_SIZE) {
                invalidFiles.push({
                    file: file,
                    error: `Ukuran file terlalu besar (${formatFileSize(file.size)})`
                });
                updateDebugInfo(`File ${file.name} rejected: too large`);
            } else if (!ALLOWED_TYPES.includes(file.type)) {
                invalidFiles.push({
                    file: file,
                    error: `Tipe file tidak didukung (${file.type})`
                });
                updateDebugInfo(`File ${file.name} rejected: invalid type ${file.type}`);
            } else {
                validFiles.push(file);
                updateDebugInfo(`File ${file.name} accepted`);
            }
        });
        
        updateDebugInfo(`Validation complete: ${validFiles.length} valid, ${invalidFiles.length} invalid`);
        
        // Process files with slight delay to show loading
        setTimeout(() => {
            // Process valid files
            if (validFiles.length > 0) {
                updateDebugInfo(`Creating previews for ${validFiles.length} valid files`);
                
                // Complete the progress animation
                showUploadComplete();
                
                // Make sure new attachments section is visible
                if (newAttachmentsSection) {
                    newAttachmentsSection.classList.remove('hidden');
                } else {
                    updateDebugInfo('ERROR: New attachments section not found');
                }
                
                // Create previews for valid files
                validFiles.forEach(file => {
                    createFilePreview(file);
                });
                
                // Update attachment counters
                updateAttachmentCounters(validFiles.length);
                
                // Show success notification
                if (validFiles.length > 0) {
                    showUploadSuccessModal(validFiles.length);
                }
            } else {
                hideUploadingState();
                updateDebugInfo('No valid files to process');
            }
            
            // Show errors for invalid files
            if (invalidFiles.length > 0) {
                updateDebugInfo(`Showing error for ${invalidFiles.length} invalid files`);
                
                let errorMessage = 'File tidak valid:<br>';
                invalidFiles.forEach(item => {
                    errorMessage += `• ${item.file.name}: ${item.error}<br>`;
                });
                
                showUploadErrorModal(errorMessage);
            }
        }, 1200); // Simulate processing time - bit longer for user to see progress
    }

    // Update all attachment counters - PERBAIKAN: Menambahkan validasi elemen
    function updateAttachmentCounters(count) {
        // Increment the count
        newAttachmentCount += count;
        updateDebugInfo(`Updating attachment counters: ${count} new files (total ${newAttachmentCount})`);
        
        // Update all counter displays
        if (newAttachmentCountEl) {
            newAttachmentCountEl.textContent = `${newAttachmentCount} Baru`;
            newAttachmentCountEl.classList.remove('hidden');
        }
        
        if (submitAttachmentCount && submitCount) {
            submitAttachmentCount.classList.remove('hidden');
            submitCount.textContent = newAttachmentCount;
        }
        
        if (sidebarNewAttachmentCount) {
            sidebarNewAttachmentCount.textContent = `${newAttachmentCount} baru`;
            sidebarNewAttachmentCount.classList.remove('hidden');
        }
        // Add animation
        if (newAttachmentCountEl) newAttachmentCountEl.classList.add('counter-animation');
        if (sidebarNewAttachmentCount) sidebarNewAttachmentCount.classList.add('counter-animation');
        if (submitAttachmentCount) submitAttachmentCount.classList.add('counter-animation');
        
        // Remove animation after it finishes
        setTimeout(() => {
            if (newAttachmentCountEl) newAttachmentCountEl.classList.remove('counter-animation');
            if (sidebarNewAttachmentCount) sidebarNewAttachmentCount.classList.remove('counter-animation');
            if (submitAttachmentCount) submitAttachmentCount.classList.remove('counter-animation');
        }, 500);
        
        // Pulse the submit button to draw attention
        if (submitBtn) {
            submitBtn.classList.add('pulse-animation');
            setTimeout(() => {
                submitBtn.classList.remove('pulse-animation');
            }, 1500);
        }
    }

    // Create file preview with animation and better UX
    function createFilePreview(file) {
        updateDebugInfo(`Creating preview for file: ${file.name}`);
        
        // Create preview item with animation
        const previewItem = document.createElement('div');
        previewItem.className = 'preview-item bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm scale-in attachment-new';
        previewItem.style.opacity = '0';
        
        // Determine file type and create appropriate preview
        let previewContent;
        let typeBadge = '';
        let previewClass = '';
        
        if (file.type.startsWith('image/')) {
            // Create a preview URL for the image
            const imgUrl = URL.createObjectURL(file);
            updateDebugInfo(`Created URL for image: ${imgUrl}`);
            
            typeBadge = `<span class="file-type-badge bg-blue-500 text-white border border-white">IMAGE</span>`;
            previewClass = 'img-preview file-preview-hover';
            previewContent = `
                <div class="p-4">
                    <div class="flex">
                        <div class="flex-shrink-0 mr-3 relative">
                            <img src="${imgUrl}" data-preview="${imgUrl}" class="w-16 h-16 object-cover rounded-lg ${previewClass}" alt="${file.name}">
                            <span class="absolute top-0 right-0 bg-blue-500 text-white text-xs font-bold px-1 rounded-bl">Gambar</span>
                        </div>
                        <div class="flex-grow">
                            <h6 class="font-medium text-gray-800 truncate mb-1" title="${file.name}">${file.name}</h6>
                            <div class="flex items-center">
                                <p class="text-xs text-gray-500 mr-2">${formatFileSize(file.size)}</p>
                                <span class="px-1.5 py-0.5 bg-green-100 text-green-800 rounded text-xs">Baru</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else {
            // Determine icon based on file extension
            let iconClass = 'fa-file';
            let bgColor = 'bg-blue-100';
            let textColor = 'text-blue-600';
            let badgeColor = 'bg-blue-500';
            let typeLabel = 'FILE';
            
            const ext = file.name.split('.').pop().toLowerCase();
            if (ext === 'pdf') {
                iconClass = 'fa-file-pdf';
                bgColor = 'bg-red-100';
                textColor = 'text-red-600';
                badgeColor = 'bg-red-500';
                typeLabel = 'PDF';
            } else if (['doc', 'docx'].includes(ext)) {
                iconClass = 'fa-file-word';
                bgColor = 'bg-blue-100';
                textColor = 'text-blue-600';
                badgeColor = 'bg-blue-600';
                typeLabel = 'DOC';
            } else if (['xls', 'xlsx'].includes(ext)) {
                iconClass = 'fa-file-excel';
                bgColor = 'bg-green-100';
                textColor = 'text-green-600';
                badgeColor = 'bg-green-500';
                typeLabel = 'EXCEL';
            }
            
            typeBadge = `<span class="file-type-badge ${badgeColor} text-white border border-white">${typeLabel}</span>`;
            
            previewContent = `
                <div class="p-4">
                    <div class="flex">
                        <div class="flex-shrink-0 mr-3 relative">
                            <div class="flex justify-center items-center ${bgColor} rounded-lg w-16 h-16">
                                <i class="fas ${iconClass} ${textColor} text-3xl"></i>
                            </div>
                            <span class="absolute top-0 right-0 ${badgeColor} text-white text-xs font-bold px-1 rounded-bl">${typeLabel}</span>
                        </div>
                        <div class="flex-grow">
                            <h6 class="font-medium text-gray-800 truncate mb-1" title="${file.name}">${file.name}</h6>
                            <div class="flex items-center">
                                <p class="text-xs text-gray-500 mr-2">${formatFileSize(file.size)}</p>
                                <span class="px-1.5 py-0.5 bg-green-100 text-green-800 rounded text-xs">Baru</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Create element structure with improved UI
        previewItem.innerHTML = `
            ${typeBadge}
            ${previewContent}
            <div class="border-t border-gray-100 px-4 py-2 flex justify-between items-center bg-gray-50">
                <span class="text-xs text-green-600 font-medium flex items-center">
                    <i class="fas fa-check-circle mr-1.5"></i> Siap diunggah
                </span>
                <button type="button" class="remove-file text-xs text-red-600 hover:text-red-700 focus:outline-none font-medium flex items-center">
                    <i class="fas fa-trash mr-1.5"></i> Hapus
                </button>
            </div>
        `;
        
        // Add remove button functionality
        const removeButton = previewItem.querySelector('.remove-file');
        if (removeButton) {
            removeButton.addEventListener('click', function() {
                updateDebugInfo(`Removing file: ${file.name}`);
                // Add a removal animation
                previewItem.style.opacity = '0';
                previewItem.style.transform = 'scale(0.9)';
                
                // Decrement counter
                updateAttachmentCounters(-1);
                
                setTimeout(() => {
                    previewItem.remove();
                    
                    // If no more attachments, hide the section
                    if (attachmentPreview.children.length === 0 && newAttachmentsSection) {
                        newAttachmentsSection.classList.add('hidden');
                        updateDebugInfo('No attachments left, hiding section');
                    }
                }, 300);
            });
        }
        
        // Add preview image functionality for images
        const previewImage = previewItem.querySelector('.img-preview');
        if (previewImage) {
            previewImage.addEventListener('click', function() {
                updateDebugInfo('Showing image preview modal');
                showFilePreviewModal(this.dataset.preview, file.name);
            });
        }
        
        // Add to container with staggered animation
        if (attachmentPreview) {
            attachmentPreview.appendChild(previewItem);
            
            // Trigger animation after a small delay
            setTimeout(() => {
                previewItem.style.opacity = '1';
                
                // Create confetti effect at the preview item position
                createConfettiEffect(previewItem);
                
                updateDebugInfo(`File preview created for: ${file.name}`);
            }, 10);
        } else {
            updateDebugInfo('ERROR: Attachment preview container not found!');
        }
    }
    
    // Function to create confetti effect
    function createConfettiEffect(element) {
        // Get element position
        const rect = element.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        
        // Create confetti particles
        const colors = ['#3b82f6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'];
        
        for (let i = 0; i < 15; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.left = `${centerX + (Math.random() * 60 - 30)}px`;
            confetti.style.top = `${centerY + (Math.random() * 40 - 20)}px`;
            confetti.style.width = `${Math.random() * 8 + 4}px`;
            confetti.style.height = `${Math.random() * 8 + 4}px`;
            confetti.style.opacity = Math.random();
            confetti.style.animationDuration = `${Math.random() * 1 + 0.5}s`;
            
            document.body.appendChild(confetti);
            
            // Remove confetti after animation
            setTimeout(() => {
                if (confetti.parentNode) {
                    confetti.parentNode.removeChild(confetti);
                }
            }, 1500);
        }
    }
    
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' bytes';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }
    
    // Handle checkbox behavior for deleted attachments
    const deleteCheckboxes = document.querySelectorAll('input[name="deleted_attachments[]"]');
    deleteCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const attachmentId = this.value;
            const card = document.getElementById('attachment-' + attachmentId);
            
            if (this.checked) {
                card.classList.add('opacity-50');
                updateDebugInfo(`Marked attachment ${attachmentId} for deletion`);
            } else {
                card.classList.remove('opacity-50');
                updateDebugInfo(`Unmarked attachment ${attachmentId} for deletion`);
            }
        });
    });
    
    // ==== FILE PREVIEW MODAL ====
    const filePreviewModal = document.getElementById('file-preview-modal');
    const filePreviewBackdrop = document.getElementById('file-preview-backdrop');
    const filePreviewContent = document.getElementById('file-preview-content');
    const filePreviewImage = document.getElementById('file-preview-image');
    const filePreviewTitle = document.getElementById('file-preview-title');
    const closeFilePreviewModal = document.getElementById('close-file-preview-modal');
    
    function showFilePreviewModal(imageUrl, title) {
        if (filePreviewImage) filePreviewImage.src = imageUrl;
        if (filePreviewTitle) filePreviewTitle.textContent = title || 'Preview File';
        
        // Show modal with animation
        if (filePreviewModal) {
            filePreviewModal.classList.remove('hidden');
            filePreviewModal.classList.add('flex');
            
            setTimeout(() => {
                if (filePreviewBackdrop) filePreviewBackdrop.style.opacity = '1';
                if (filePreviewContent) {
                    filePreviewContent.style.opacity = '1';
                    filePreviewContent.style.transform = 'translateY(0)';
                }
            }, 10);
            
            updateDebugInfo(`Showing file preview modal for: ${title}`);
        } else {
            updateDebugInfo('ERROR: File preview modal not found');
        }
    }
    
    function hideFilePreviewModal() {
        if (filePreviewBackdrop) filePreviewBackdrop.style.opacity = '0';
        if (filePreviewContent) {
            filePreviewContent.style.opacity = '0';
            filePreviewContent.style.transform = 'translateY(4px)';
        }
        
        setTimeout(() => {
            if (filePreviewModal) {
                filePreviewModal.classList.add('hidden');
                filePreviewModal.classList.remove('flex');
            }
        }, 300);
        
        updateDebugInfo('File preview modal closed');
    }
    
    if (closeFilePreviewModal) {
        closeFilePreviewModal.addEventListener('click', hideFilePreviewModal);
    }
    
    if (filePreviewBackdrop) {
        filePreviewBackdrop.addEventListener('click', hideFilePreviewModal);
    }
    
    // ==== UPLOAD SUCCESS/ERROR MODALS ====
    
    // Upload Success Modal
    const uploadSuccessModal = document.getElementById('upload-success-modal');
    const uploadSuccessBackdrop = document.getElementById('upload-success-backdrop');
    const uploadSuccessContent = document.getElementById('upload-success-content');
    const closeUploadSuccessModal = document.getElementById('close-upload-success-modal');
    const addMoreFiles = document.getElementById('add-more-files');
    const uploadSuccessTitle = document.getElementById('upload-success-title');
    const uploadSuccessMessage = document.getElementById('upload-success-message');
    
    function showUploadSuccessModal(fileCount) {
        if (uploadSuccessTitle && uploadSuccessMessage) {
            if (fileCount === 1) {
                uploadSuccessTitle.textContent = 'File Berhasil Ditambahkan!';
                uploadSuccessMessage.textContent = '1 file telah berhasil ditambahkan ke daftar lampiran baru.';
            } else {
                uploadSuccessTitle.textContent = 'File Berhasil Ditambahkan!';
                uploadSuccessMessage.textContent = `${fileCount} file telah berhasil ditambahkan ke daftar lampiran baru.`;
            }
        }
        
        // Show modal with animation
        if (uploadSuccessModal) {
            uploadSuccessModal.classList.remove('hidden');
            uploadSuccessModal.classList.add('flex');
            
            setTimeout(() => {
                if (uploadSuccessBackdrop) uploadSuccessBackdrop.style.opacity = '1';
                if (uploadSuccessContent) {
                    uploadSuccessContent.style.opacity = '1';
                    uploadSuccessContent.style.transform = 'translateY(0)';
                }
            }, 10);
            
            updateDebugInfo(`Showing success modal for ${fileCount} files`);
        } else {
            updateDebugInfo('ERROR: Success modal not found');
        }
    }
    
    function hideUploadSuccessModal() {
        if (uploadSuccessBackdrop) uploadSuccessBackdrop.style.opacity = '0';
        if (uploadSuccessContent) {
            uploadSuccessContent.style.opacity = '0';
            uploadSuccessContent.style.transform = 'translateY(4px)';
        }
        
        setTimeout(() => {
            if (uploadSuccessModal) {
                uploadSuccessModal.classList.add('hidden');
                uploadSuccessModal.classList.remove('flex');
            }
        }, 300);
        
        updateDebugInfo('Success modal closed');
    }
    
    if (closeUploadSuccessModal) {
        closeUploadSuccessModal.addEventListener('click', hideUploadSuccessModal);
    }
    
    if (uploadSuccessBackdrop) {
        uploadSuccessBackdrop.addEventListener('click', hideUploadSuccessModal);
    }
    
    // "Add More Files" button functionality
    if (addMoreFiles) {
        addMoreFiles.addEventListener('click', function() {
            hideUploadSuccessModal();
            setTimeout(() => {
                if (fileInput) {
                    fileInput.click();
                    updateDebugInfo('Opening file selector again');
                }
            }, 300);
        });
    }
    
    // Upload Error Modal
    const uploadErrorModal = document.getElementById('upload-error-modal');
    const uploadErrorBackdrop = document.getElementById('upload-error-backdrop');
    const uploadErrorContent = document.getElementById('upload-error-content');
    const closeUploadErrorModal = document.getElementById('close-upload-error-modal');
    const uploadErrorMessage = document.getElementById('upload-error-message');
    
    function showUploadErrorModal(message) {
        if (uploadErrorMessage) uploadErrorMessage.innerHTML = message;
        
        // Show modal with animation
        if (uploadErrorModal) {
            uploadErrorModal.classList.remove('hidden');
            uploadErrorModal.classList.add('flex');
            
            setTimeout(() => {
                if (uploadErrorBackdrop) uploadErrorBackdrop.style.opacity = '1';
                if (uploadErrorContent) {
                    uploadErrorContent.style.opacity = '1';
                    uploadErrorContent.style.transform = 'translateY(0)';
                }
            }, 10);
            
            updateDebugInfo(`Showing error modal: ${message}`);
        } else {
            updateDebugInfo('ERROR: Error modal not found');
            alert(`Upload error: ${message}`);
        }
    }
    
    function hideUploadErrorModal() {
        if (uploadErrorBackdrop) uploadErrorBackdrop.style.opacity = '0';
        if (uploadErrorContent) {
            uploadErrorContent.style.opacity = '0';
            uploadErrorContent.style.transform = 'translateY(4px)';
        }
        
        setTimeout(() => {
            if (uploadErrorModal) {
                uploadErrorModal.classList.add('hidden');
                uploadErrorModal.classList.remove('flex');
            }
        }, 300);
        
        updateDebugInfo('Error modal closed');
    }
    
    if (closeUploadErrorModal) {
        closeUploadErrorModal.addEventListener('click', hideUploadErrorModal);
    }
    
    if (uploadErrorBackdrop) {
        uploadErrorBackdrop.addEventListener('click', hideUploadErrorModal);
    }
    
    // Toast notification function
    function showToast(message, type = 'info') {
        const toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            updateDebugInfo('ERROR: Toast container not found');
            console.error('Toast container not found');
            return;
        }
        
        // Create new toast
        const toast = document.createElement('div');
        toast.className = 'toast-notification p-4 mb-3 rounded-lg shadow-lg z-50 toast flex items-center space-x-2 max-w-xs';
        
        let bgColor, iconClass;
        switch (type) {
            case 'success':
                bgColor = 'bg-green-500';
                iconClass = 'fa-check-circle';
                break;
            case 'error':
                bgColor = 'bg-red-500';
                iconClass = 'fa-exclamation-circle';
                break;
            case 'warning':
                bgColor = 'bg-yellow-500';
                iconClass = 'fa-exclamation-triangle';
                break;
            default:
                bgColor = 'bg-blue-500';
                iconClass = 'fa-info-circle';
        }
        
        toast.classList.add(bgColor);
        
        toast.innerHTML = `
            <div class="flex-shrink-0">
                <i class="fas ${iconClass} text-white"></i>
            </div>
            <p class="text-white text-sm flex-grow">${message}</p>
            <button class="text-white hover:text-gray-200 focus:outline-none ml-4">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        toastContainer.appendChild(toast);
        updateDebugInfo(`Toast shown: ${type} - ${message}`);
        
        // Auto dismiss
        const dismissTimeout = setTimeout(() => {
            dismissToast(toast);
        }, 5000);
        
        // Manual dismiss
        toast.querySelector('button').addEventListener('click', () => {
            clearTimeout(dismissTimeout);
            dismissToast(toast);
        });
    }
    
    function dismissToast(toast) {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(10px)';
        
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }
    
    // ==== FORM SUBMISSION ====
    if (form) {
        form.addEventListener('submit', function(e) {
            // Show upload loading animation to indicate form submission
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg> Menyimpan Perubahan...`;
            }

            // Show notification
            showToast('Sedang menyimpan perubahan...', 'info');
            updateDebugInfo('Form submitted');
        });
    } else {
        updateDebugInfo('ERROR: Form not found!');
    }

    // Check for existing session messages
    const successMessage = document.querySelector('meta[name="session-success"]')?.getAttribute('content');
    const errorMessage = document.querySelector('meta[name="session-error"]')?.getAttribute('content');

    if (successMessage && successMessage.trim() !== '') {
        showToast(successMessage, 'success');
    }

    if (errorMessage && errorMessage.trim() !== '') {
        showToast(errorMessage, 'error');
    }

    // Set initial focus to title input
    setTimeout(() => {
        if (document.getElementById('judul')) {
            document.getElementById('judul').focus();
        }
    }, 500);

    // Add image preview capability for existing images
    document.querySelectorAll('.img-preview').forEach(img => {
        img.addEventListener('click', function() {
            showFilePreviewModal(this.getAttribute('data-preview'), this.alt);
            updateDebugInfo(`Opening preview for ${this.alt || 'image'}`);
        });
    });

    // Initial debug message
    updateDebugInfo('All components initialized and ready');
});
</script>
@endpush