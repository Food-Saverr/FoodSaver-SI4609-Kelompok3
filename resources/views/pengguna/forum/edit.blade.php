@extends('layouts.app')

@section('title', 'Edit Postingan')

@section('content')
<!-- Animated Background Elements -->
<div class="fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-[10%] -right-[10%] w-[35%] h-[40%] bg-gradient-to-br from-blue-100/30 to-blue-200/20 blur-3xl rounded-full animate-blob"></div>
    <div class="absolute top-[30%] -left-[5%] w-[25%] h-[30%] bg-gradient-to-br from-green-100/20 to-blue-100/20 blur-3xl rounded-full animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-[10%] right-[20%] w-[30%] h-[40%] bg-gradient-to-br from-blue-100/20 to-green-100/20 blur-3xl rounded-full animate-blob animation-delay-4000"></div>
</div>

<div class="container mx-auto px-4 py-8 pt-24 relative z-10">
    <div class="max-w-4xl mx-auto">
        <!-- Floating Action Button -->
        <div class="fixed bottom-10 right-10 z-50">
            <button type="submit" form="editPostForm" class="flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 shadow-xl rounded-full hover:shadow-blue-200/50 group relative overflow-hidden transition-all">
                <span class="absolute inset-0 w-full h-full bg-gradient-to-tr from-blue-400 to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <i class="fas fa-save text-lg text-white"></i>
                </span>
                <i class="fas fa-save text-lg text-white group-hover:scale-110 transition-transform"></i>
            </button>
        </div>
        
        <!-- Breadcrumb -->
        <a href="{{ route('pengguna.forum.show', $post->ID_ForumPost) }}" class="text-sm text-blue-600 flex items-center hover:text-blue-700 transition-colors group mb-6 w-max">
            <span class="inline-block mr-2 transition-transform group-hover:-translate-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </span>
            Kembali ke Postingan
        </a>

        <!-- Main Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-6 lg:p-8 shadow-xl shadow-gray-100/80 border border-gray-100">
            <!-- Card Header with Animation -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-8 pb-8 border-b border-gray-100">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white shadow-lg transform rotate-3 hover:rotate-6 transition-transform duration-300">
                        <i class="fas fa-edit text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-1">
                        <span class="bg-gradient-to-r from-blue-500 to-indigo-600 bg-clip-text text-transparent">
                            Edit Postingan
                        </span>
                    </h1>
                    <p class="text-gray-600">
                        Perbarui pengalaman & tips sustain makanan untuk komunitas Food Saver
                    </p>
                </div>
            </div>

            <form action="{{ route('pengguna.forum.update', $post->ID_ForumPost) }}" method="POST" enctype="multipart/form-data" id="editPostForm" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Title Input with Animation -->
                <div class="space-y-2">
                    <label for="judul" class="text-sm font-semibold text-gray-700 flex items-center">
                        <span class="bg-blue-100 p-1 rounded-md text-blue-600 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </span>
                        Berikan judul yang menarik
                    </label>
                    
                    <div class="relative rounded-xl overflow-hidden transform transition-all focus-within:scale-[1.01]">
                        <input type="text" 
                            class="block w-full px-5 py-4 text-xl bg-gray-50/50 border-0 rounded-xl focus:ring-0 focus:outline-none placeholder-gray-400 transition-all duration-300"
                            id="judul" 
                            name="judul" 
                            value="{{ old('judul', $post->judul) }}" 
                            placeholder="Judul Postingan..."
                            required
                            autocomplete="off">
                        <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-blue-400 to-blue-600 w-0 group-focus:w-full transition-all duration-300"></div>
                    </div>
                    
                    @error('judul')
                        <div class="text-red-500 text-sm flex items-center mt-1 animate-pulse">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Content Editor - Simple and Elegant Design -->
                <div class="space-y-2">
                    <label for="content-editor" class="text-sm font-semibold text-gray-700 flex items-center">
                        <span class="bg-indigo-100 p-1 rounded-md text-indigo-600 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </span>
                        Bagikan pengalaman atau cerita kamu
                    </label>
                    
                    <!-- Modern Text Editor -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 transition-all hover:shadow-md">
                        <div id="content-editor" class="min-h-[250px] p-6 focus:outline-none" contenteditable="true" data-placeholder="Tulis cerita dan pengalaman kamu di sini...">{{ old('konten', $post->konten) }}</div>
                        
                        <!-- Hidden Controls - Show on Selection -->
                        <div id="format-controls" class="absolute bg-white rounded-lg shadow-lg border border-gray-200 p-1 z-10 animate-fadeIn hidden">
                            <button type="button" data-format="bold" class="format-btn p-2 hover:bg-gray-100 rounded" title="Bold">
                                <i class="fas fa-bold text-gray-700"></i>
                            </button>
                            <button type="button" data-format="italic" class="format-btn p-2 hover:bg-gray-100 rounded" title="Italic">
                                <i class="fas fa-italic text-gray-700"></i>
                            </button>
                            <button type="button" data-format="formatBlock" data-value="h3" class="format-btn p-2 hover:bg-gray-100 rounded" title="Heading">
                                <i class="fas fa-heading text-gray-700"></i>
                            </button>
                            <button type="button" data-format="insertUnorderedList" class="format-btn p-2 hover:bg-gray-100 rounded" title="Bullet List">
                                <i class="fas fa-list-ul text-gray-700"></i>
                            </button>
                            <button type="button" data-format="createLink" class="format-btn p-2 hover:bg-gray-100 rounded" title="Insert Link">
                                <i class="fas fa-link text-gray-700"></i>
                            </button>
                        </div>
                        
                        <input type="hidden" name="konten" id="konten-hidden" value="{{ old('konten', $post->konten) }}">
                        
                        <!-- Editor Footer -->
                        <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex items-center justify-end">
                            <!-- Word Count -->
                            <div id="word-count" class="text-xs text-gray-500">0 kata</div>
                        </div>
                    </div>
                    
                    @error('konten')
                        <div class="text-red-500 text-sm flex items-center mt-1 animate-pulse">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Current Attachments with Enhanced Visual -->
                @if($post->attachments->isNotEmpty())
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-semibold text-gray-700 flex items-center">
                            <span class="bg-purple-100 p-1 rounded-md text-purple-600 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </span>
                            Lampiran Saat Ini
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $post->attachments->count() }} file
                            </span>
                        </label>
                        
                        <button type="button" id="toggle-select-all" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                            <i class="far fa-square mr-1.5 text-blue-500" id="select-icon"></i>
                            <span id="select-text">Pilih Semua</span>
                        </button>
                    </div>
                    
                    <!-- Redesigned attachments gallery -->
                    <div class="bg-gradient-to-r from-indigo-50/50 to-blue-50/50 rounded-2xl p-5 border border-blue-100/80 relative overflow-hidden">
                        <!-- Decoration dots -->
                        <div class="absolute top-0 right-0 opacity-20">
                            <div class="grid grid-cols-5 gap-1.5">
                                @for ($i = 0; $i < 20; $i++)
                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                                @endfor
                            </div>
                        </div>
                        
                        <div id="current-attachments" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($post->attachments as $attachment)
                                <div class="attachment-card group" data-id="{{ $attachment->ID_Attachment }}">
                                    <div class="flex bg-white rounded-xl overflow-hidden shadow-sm border border-blue-100/60 transition-all duration-300 hover:shadow-md hover:border-blue-200 relative h-24">
                                        <!-- Left: Preview thumbnail -->
                                        <div class="attachment-preview w-24 min-w-24 relative overflow-hidden">
                                            @if($attachment->isImage())
                                                <img src="{{ asset('storage/' . $attachment->path) }}" alt="{{ $attachment->nama_file }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                                <div class="absolute inset-0 bg-gradient-to-tr from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            @else
                                                @php
                                                    $fileExt = pathinfo($attachment->nama_file, PATHINFO_EXTENSION);
                                                    $iconClass = 'fa-file';
                                                    $iconColor = 'text-blue-500';
                                                    $bgColor = 'bg-blue-50';
                                                    
                                                    if (in_array($fileExt, ['pdf'])) {
                                                        $iconClass = 'fa-file-pdf';
                                                        $iconColor = 'text-red-500';
                                                        $bgColor = 'bg-red-50';
                                                    }
                                                    elseif (in_array($fileExt, ['doc', 'docx'])) {
                                                        $iconClass = 'fa-file-word';
                                                        $iconColor = 'text-blue-600';
                                                        $bgColor = 'bg-blue-50';
                                                    }
                                                    elseif (in_array($fileExt, ['xls', 'xlsx'])) {
                                                        $iconClass = 'fa-file-excel';
                                                        $iconColor = 'text-green-600';
                                                        $bgColor = 'bg-green-50';
                                                    }
                                                @endphp
                                                <div class="w-full h-full flex items-center justify-center {{ $bgColor }}">
                                                    <i class="fas {{ $iconClass }} text-2xl {{ $iconColor }}"></i>
                                                </div>
                                            @endif
                                            
                                            <!-- File extension badge -->
                                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent flex justify-center py-1">
                                                <span class="text-xs text-white font-medium">
                                                    {{ strtoupper(pathinfo($attachment->nama_file, PATHINFO_EXTENSION)) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Right: Info & actions -->
                                        <div class="flex-grow p-3 flex flex-col justify-between relative overflow-hidden">
                                            <!-- File name & size -->
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-800 truncate max-w-full" title="{{ $attachment->nama_file }}">
                                                    {{ $attachment->nama_file }}
                                                </h4>
                                                <p class="text-xs text-gray-500 mt-0.5 flex items-center">
                                                    <i class="fas fa-weight text-gray-400 mr-1"></i>
                                                    {{ number_format($attachment->ukuran / 1024, 1) }} KB
                                                </p>
                                            </div>
                                            
                                            <!-- Action buttons -->
                                            <div class="flex items-center justify-between mt-1">
                                                <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800 transition-colors flex items-center">
                                                    <i class="fas fa-external-link-alt mr-1"></i>
                                                    Lihat
                                                </a>
                                                
                                                <div class="flex items-center gap-3">
                                                    <span class="delete-status-text text-xs hidden"></span>
                                                    <div class="attachment-action cursor-pointer delete-current-file" data-id="{{ $attachment->ID_Attachment }}">
                                                        <span class="delete-action-icon w-7 h-7 flex items-center justify-center rounded-full text-red-500 hover:bg-red-50 transition-colors">
                                                            <i class="fas fa-trash-alt text-sm"></i>
                                                        </span>
                                                        <span class="undo-action-icon hidden w-7 h-7 items-center justify-center rounded-full text-green-500 hover:bg-green-50 transition-colors">
                                                            <i class="fas fa-undo text-sm"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Hidden checkbox -->
                                            <input type="checkbox" name="deleted_attachments[]" value="{{ $attachment->ID_Attachment }}" class="hidden attachment-checkbox">
                                            
                                            <!-- Selection checkmark for multi-select -->
                                            <div class="absolute top-2 right-2 select-checkmark opacity-0 w-5 h-5 rounded-full border-2 border-blue-200 transition-opacity"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Action bar for multi-select -->
                        <div id="multi-action-bar" class="mt-4 pt-4 border-t border-blue-200/50 grid grid-cols-5 gap-3" style="display: none;">
                            <p class="text-sm text-gray-700 col-span-3">
                                <span id="selected-count">0</span> file terpilih
                            </p>
                            <button type="button" id="delete-selected" class="col-span-1 flex items-center justify-center px-3 py-2 bg-red-500 hover:bg-red-600 transition-colors rounded-lg text-white text-sm">
                                <i class="fas fa-trash-alt mr-2"></i>
                                Hapus
                            </button>
                            <button type="button" id="cancel-selection" class="col-span-1 flex items-center justify-center px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors rounded-lg text-gray-700 text-sm">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </button>
                        </div>
                    </div>
                    
                    <!-- Help text -->
                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-info text-blue-500 text-xs"></i>
                        </div>
                        <p>Klik ikon sampah untuk menghapus lampiran. Perubahan hanya akan berlaku setelah menyimpan formulir.</p>
                    </div>
                </div>
                @endif
                
                <!-- File Upload with Enhanced Visual -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 flex items-center">
                        <span class="bg-amber-100 p-1 rounded-md text-amber-600 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                        </span>
                        Tambah lampiran baru
                    </label>
                    
                    <!-- Beautiful Upload Area -->
                    <div id="dropzone" class="group cursor-pointer">
                        <div class="border-2 border-dashed border-gray-200 rounded-xl transition-all duration-300 bg-gray-50/50 group-hover:border-blue-300 group-hover:bg-blue-50/50 overflow-hidden">
                            <div class="p-8 text-center">
                                <div class="upload-animation mx-auto mb-4 w-16 h-16 rounded-full flex items-center justify-center bg-blue-50 group-hover:scale-110 transition-transform duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 transform group-hover:scale-110 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <p class="text-gray-700 font-medium mb-2">
                                    <span class="text-blue-600">Seret & lepas file</span> atau klik untuk pilih
                                </p>
                                <p class="text-gray-500 text-sm">
                                    Mendukung gambar (JPG, PNG) dan dokumen (PDF)
                                </p>
                            </div>
                            <input type="file" id="attachments" name="attachments[]" class="hidden" multiple>
                        </div>
                    </div>
                    
                    <!-- Upload Progress Overlay -->
                    <div id="upload-progress" class="hidden relative">
                        <div class="absolute inset-0 bg-white/80 backdrop-blur-sm rounded-xl flex flex-col items-center justify-center z-10">
                            <div class="w-20 h-20 mb-4 relative">
                                <svg class="upload-progress-ring w-20 h-20" viewBox="0 0 68 68">
                                    <circle class="upload-progress-ring-bg" cx="34" cy="34" r="30" fill="none" stroke="#e5e7eb" stroke-width="4"></circle>
                                    <circle class="upload-progress-ring-circle" cx="34" cy="34" r="30" fill="none" stroke="#3b82f6" stroke-width="4" stroke-dasharray="188.5" stroke-dashoffset="188.5"></circle>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center text-blue-600 font-semibold text-lg upload-progress-text">0%</div>
                            </div>
                            <p class="text-blue-600">Mengunggah file...</p>
                        </div>
                    </div>
                    
                    <!-- File Preview with Better Animation -->
                    <div id="attachment-preview" class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4"></div>
                    
                    @error('attachments.*')
                        <div class="text-red-500 text-sm flex items-center mt-1 animate-pulse">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Submit Button Area -->
                <div class="pt-6 flex flex-col-reverse sm:flex-row gap-4 justify-between">
                    <a href="{{ route('pengguna.forum.show', $post->ID_ForumPost) }}" class="flex items-center justify-center px-6 py-3.5 bg-white border border-gray-300 rounded-xl text-gray-700 font-medium shadow-sm hover:bg-gray-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>
                    
                    <button type="submit" id="submit-btn" class="flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:from-blue-600 hover:to-blue-700 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tips Card -->
<div class="container mx-auto px-4 pb-16 relative z-10">
    <div class="max-w-4xl mx-auto mt-8">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl shadow-lg overflow-hidden border border-indigo-100/50">
            <div class="p-0.5 bg-gradient-to-r from-blue-400/20 to-indigo-500/20">
                <div class="grid grid-cols-1 md:grid-cols-3">
                    <!-- Heading -->
                    <div class="p-6 md:col-span-1 flex md:flex-col md:items-start items-center gap-4 border-b md:border-b-0 md:border-r border-indigo-100/50">
                        <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white shadow-lg transform md:rotate-3 hover:rotate-6 transition-transform">
                            <i class="fas fa-star text-xl md:text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl text-indigo-800">Tips Editing</h3>
                            <p class="text-indigo-600 text-sm">Untuk hasil maksimal</p>
                        </div>
                    </div>
                    
                    <!-- Tips Content -->
                    <div class="p-6 md:col-span-2">
                        <ul class="space-y-5">
                            <li class="flex items-start transform transition-all hover:translate-x-1">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 text-blue-600">
                                    <i class="fas fa-check text-sm"></i>
                                </span>
                                <div>
                                    <h4 class="font-medium text-gray-900">Perbarui konten dengan informasi terkini</h4>
                                    <p class="text-gray-600 text-sm">Pastikan postingan tetap relevan dan memiliki informasi yang akurat.</p>
                                </div>
                            </li>
                            <li class="flex items-start transform transition-all hover:translate-x-1">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 text-blue-600">
                                    <i class="fas fa-check text-sm"></i>
                                </span>
                                <div>
                                    <h4 class="font-medium text-gray-900">Tambahkan gambar berkualitas</h4>
                                    <p class="text-gray-600 text-sm">Visual yang menarik dapat meningkatkan engagement pembaca.</p>
                                </div>
                            </li>
                            <li class="flex items-start transform transition-all hover:translate-x-1">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 text-blue-600">
                                    <i class="fas fa-check text-sm"></i>
                                </span>
                                <div>
                                    <h4 class="font-medium text-gray-900">Periksa ulang formatasi</h4>
                                    <p class="text-gray-600 text-sm">Pastikan teks mudah dibaca dengan format yang tepat dan konsisten.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Link Editor Modal -->
<div id="link-modal" class="fixed inset-0 z-50 items-center justify-center hidden" aria-modal="true">
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm opacity-0 transition-opacity duration-300" id="link-modal-backdrop"></div>
    <div class="bg-white rounded-2xl max-w-lg w-full mx-auto p-0 shadow-2xl relative top-[10%] opacity-0 transform translate-y-4 transition-all duration-300" id="link-modal-content">
        <!-- Modal Header with Animation -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-link"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Tambahkan Link</h3>
            </div>
            <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" id="close-link-modal">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 space-y-4">
            <div class="space-y-2">
                <label for="link-text" class="block text-sm font-medium text-gray-700">Teks yang ditampilkan</label>
                <input type="text" id="link-text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Teks link">
                <p class="text-xs text-gray-500">Teks yang akan muncul sebagai link</p>
            </div>
            
            <div class="space-y-2">
                <label for="link-url" class="block text-sm font-medium text-gray-700">URL</label>
                <div class="flex rounded-lg overflow-hidden border border-gray-300 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500 transition-all">
                    <span class="flex items-center justify-center bg-gray-50 border-r border-gray-300 px-3">
                        <i class="fas fa-globe text-gray-500"></i>
                    </span>
                    <input type="url" id="link-url" class="flex-grow px-4 py-3 focus:outline-none" placeholder="https://">
                </div>
            </div>
            
            <div class="flex items-center">
                <input type="checkbox" id="link-new-tab" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 transition-colors">
                <label for="link-new-tab" class="ml-2 text-sm text-gray-700">Buka link di tab baru</label>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-gray-100 flex justify-end space-x-3">
            <button type="button" id="cancel-link" class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                Batal
            </button>
            <button type="button" id="insert-link" class="px-4 py-2 bg-blue-600 border border-transparent rounded-lg shadow-sm text-white hover:bg-blue-700 focus:outline-none transition-colors">
                Tambahkan Link
            </button>
        </div>
    </div>
</div>

<!-- Image preview modal -->
<div id="image-preview-modal" class="fixed inset-0 z-50 items-center justify-center hidden" aria-modal="true">
    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm opacity-0 transition-opacity duration-300" id="image-modal-backdrop"></div>
    <div class="relative z-10 max-w-4xl mx-auto opacity-0 transform scale-95 transition-all duration-300" id="image-modal-content">
        <!-- Close button -->
        <button type="button" id="close-image-modal" class="absolute -top-12 right-0 text-white hover:text-gray-300 focus:outline-none z-20">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <!-- Image container -->
        <div class="relative overflow-hidden rounded-xl">
            <img id="preview-image" src="" alt="Preview" class="max-w-full max-h-[80vh] object-contain bg-white/10 backdrop-blur-xl p-1">
            
            <!-- Image caption -->
            <div class="absolute bottom-0 left-0 right-0 bg-black/60 backdrop-blur-sm text-white p-3 text-center">
                <p id="image-caption" class="text-sm font-medium"></p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Animation Classes */
    @keyframes blob {
        0% {transform: scale(1) translate(0px, 0px);}
        33% {transform: scale(1.1) translate(20px, -20px);}
        66% {transform: scale(0.9) translate(-20px, 20px);}
        100% {transform: scale(1) translate(0px, 0px);}
    }
    
    @keyframes fadeIn {
        from {opacity: 0;}
        to {opacity: 1;}
    }
    
    @keyframes slideUp {
        from {transform: translateY(10px); opacity: 0;}
        to {transform: translateY(0); opacity: 1;}
    }
    
    @keyframes pulse {
        0%, 100% {opacity: 1;}
        50% {opacity: 0.5;}
    }
    
    @keyframes shake {
        0%, 100% {transform: translateX(0);}
        20% {transform: translateX(-5px);}
        40% {transform: translateX(5px);}
        60% {transform: translateX(-3px);}
        80% {transform: translateX(3px);}
    }
    
    .animate-shake {
        animation: shake 0.5s ease-in-out;
    }
    
    .animate-blob {
        animation: blob 10s infinite alternate;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    .animate-slideUp {
        animation: slideUp 0.4s ease-out;
    }
    
    .animate-pulse {
        animation: pulse 2s infinite;
    }
    
    /* Content Editor Styles */
    #content-editor {
        min-height: 250px;
        font-size: 1.05rem;
        line-height: 1.6;
    }
    
    #content-editor:focus {
        outline: none;
    }
    
    #content-editor:empty:before {
        content: attr(data-placeholder);
        color: #9ca3af;
        pointer-events: none;
        display: block;
    }
    
    #content-editor h3 {
        font-size: 1.25rem;
        font-weight: bold;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        color: #111827;
    }
    
    #content-editor ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin: 0.75rem 0;
    }
    
    #content-editor ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin: 0.75rem 0;
    }
    
    #content-editor a {
        color: #2563eb;
        text-decoration: underline;
    }
    
    #content-editor blockquote {
        border-left: 4px solid #3b82f6;
        padding-left: 1rem;
        margin: 1rem 0;
        font-style: italic;
        color: #4b5563;
    }
    
    #content-editor img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin: 0.5rem 0;
    }
    
    /* Enhanced attachment card styles */
    .attachment-card {
        transition: all 0.3s ease;
    }
    
    .attachment-card.to-be-deleted > div {
        border-color: #fee2e2 !important;
        background-color: #fef2f2 !important;
        border-style: dashed !important;
    }
    
    .attachment-card.to-be-deleted .attachment-preview {
        opacity: 0.5;
    }
    
    .attachment-card.to-be-deleted .attachment-preview img,
    .attachment-card.to-be-deleted .attachment-preview i {
        filter: grayscale(1);
    }
    
    .attachment-card.to-be-deleted .delete-status-text {
        display: block;
        color: #ef4444;
    }
    
    .attachment-card.in-selection-mode > div {
        border-color: #dbeafe;
        background-color: #f0f7ff;
    }
    
    .attachment-card.in-selection-mode .select-checkmark {
        opacity: 1;
        border-color: #60a5fa;
        background-color: #fff;
    }
    
    .attachment-card.selected > div {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    
    .attachment-card.selected .select-checkmark {
        opacity: 1;
        border-color: #3b82f6;
        background-color: #3b82f6;
    }
    
    .attachment-card.selected .select-checkmark::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 6px;
        height: 10px;
        border-right: 2px solid white;
        border-bottom: 2px solid white;
        transform: translate(-50%, -65%) rotate(45deg);
    }
    
    /* File Preview Styles */
    .file-preview-item {
        position: relative;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        background-color: white;
        border: 1px solid #f3f4f6;
        transition: all 0.3s;
        animation: slideUp 0.3s ease-out;
        height: 100%;
    }
    
    .file-preview-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    .preview-img-container {
        position: relative;
        padding-top: 75%; /* 4:3 Aspect Ratio */
        overflow: hidden;
    }
    
    .preview-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .file-preview-item:hover .preview-img {
        transform: scale(1.05);
    }
    
    .preview-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.2);
        opacity: 0;
        transition: opacity 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .file-preview-item:hover .preview-overlay {
        opacity: 1;
    }
    
    .preview-file {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100px;
    }
    
    .preview-info {
        padding: 0.75rem;
        border-top: 1px solid #f3f4f6;
    }
    
    .remove-file {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 24px;
        height: 24px;
        background-color: rgba(239, 68, 68, 0.9);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.2s;
        cursor: pointer;
        z-index: 5;
    }
    
    .file-preview-item:hover .remove-file {
        opacity: 1;
        transform: scale(1);
    }
    
    /* Upload Progress Animation */
    .upload-progress-ring-bg {
        stroke-width: 4;
        stroke: #e5e7eb;
    }
    
    .upload-progress-ring-circle {
        stroke-width: 4;
        stroke: #3b82f6;
        stroke-linecap: round;
        transform-origin: center;
        transform: rotate(-90deg);
        transition: stroke-dashoffset 0.3s;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Content Editor
    const contentEditor = document.getElementById('content-editor');
    const hiddenInput = document.getElementById('konten-hidden');
    const formatControls = document.getElementById('format-controls');
    const wordCount = document.getElementById('word-count');
    const form = document.getElementById('editPostForm');
    
    // Set focus to editor
    contentEditor.focus();
    
    // Update word count
    function updateWordCount() {
        const text = contentEditor.innerText;
        const count = text.trim() === '' ? 0 : text.trim().split(/\s+/).length;
        wordCount.textContent = `${count} kata`;
    }
    
    // Show format controls on selection
    document.addEventListener('selectionchange', function() {
        const selection = window.getSelection();
        
        if (selection.toString().trim() !== '' && 
            selection.anchorNode && 
            (contentEditor.contains(selection.anchorNode) || contentEditor === selection.anchorNode)) {
            
            const range = selection.getRangeAt(0);
            const rect = range.getBoundingClientRect();
            
            formatControls.style.top = `${window.scrollY + rect.top - formatControls.offsetHeight - 10}px`;
            formatControls.style.left = `${window.scrollX + rect.left + (rect.width / 2) - (formatControls.offsetWidth / 2)}px`;
            formatControls.classList.remove('hidden');
            formatControls.classList.add('flex');
            
        } else {
            formatControls.classList.add('hidden');
            formatControls.classList.remove('flex');
        }
    });
    
    // Format buttons functionality
    document.querySelectorAll('.format-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const format = this.dataset.format;
            const value = this.dataset.value || '';
            
            if (format === 'createLink') {
                showLinkModal();
            } else {
                document.execCommand(format, false, value);
                updateWordCount();
                contentEditor.focus();
            }
        });
    });
    
    // Update hidden input whenever content changes
    contentEditor.addEventListener('input', function() {
        hiddenInput.value = contentEditor.innerHTML;
        updateWordCount();
    });
    
    // Update word count initially
    updateWordCount();
    
    // Link Modal Functionality
    const linkModal = document.getElementById('link-modal');
    const linkModalBackdrop = document.getElementById('link-modal-backdrop');
    const linkModalContent = document.getElementById('link-modal-content');
    const closeLinkModal = document.getElementById('close-link-modal');
    const cancelLink = document.getElementById('cancel-link');
    const insertLink = document.getElementById('insert-link');
    const linkText = document.getElementById('link-text');
    const linkUrl = document.getElementById('link-url');
    const linkNewTab = document.getElementById('link-new-tab');
    
    function showLinkModal() {
        // Get selected text
        const selection = window.getSelection();
        
        if (selection.toString()) {
            linkText.value = selection.toString();
        } else {
            linkText.value = '';
        }
        
        linkUrl.value = 'https://';
        
        // Show modal with animation
        linkModal.classList.remove('hidden');
        linkModal.classList.add('flex');
        
        setTimeout(() => {
            linkModalBackdrop.style.opacity = '1';
            linkModalContent.style.opacity = '1';
            linkModalContent.style.transform = 'translateY(0)';
        }, 10);
        
        // Focus URL input
        setTimeout(() => {
            linkUrl.focus();
        }, 300);
    }
    
    function hideLinkModal() {
        linkModalBackdrop.style.opacity = '0';
        linkModalContent.style.opacity = '0';
        linkModalContent.style.transform = 'translateY(4px)';
        
        setTimeout(() => {
            linkModal.classList.add('hidden');
            linkModal.classList.remove('flex');
        }, 300);
        
        // Restore focus to editor
        contentEditor.focus();
    }
    
    // Link modal event handlers
    closeLinkModal.addEventListener('click', hideLinkModal);
    cancelLink.addEventListener('click', hideLinkModal);
    linkModalBackdrop.addEventListener('click', hideLinkModal);
    
    insertLink.addEventListener('click', function() {
        const url = linkUrl.value;
        const text = linkText.value;
        const newTab = linkNewTab.checked;
        
        if (url) {
            const target = newTab ? ' target="_blank" rel="noopener noreferrer"' : '';
            
            if (text) {
                // Insert with specified text
                document.execCommand('insertHTML', false, `<a href="${url}"${target}>${text}</a>`);
            } else {
                // Use selection or URL as text
                document.execCommand('createLink', false, url);
                
                // Set target for all matching URLs
                const links = contentEditor.querySelectorAll(`a[href="${url}"]`);
                links.forEach(link => {
                    if (newTab) {
                        link.setAttribute('target', '_blank');
                        link.setAttribute('rel', 'noopener noreferrer');
                    }
                });
            }
            
            // Update hidden input after inserting link
            hiddenInput.value = contentEditor.innerHTML;
        }
        
        hideLinkModal();
    });
    
    // Image Preview Modal Functionality
    const imageModal = document.getElementById('image-preview-modal');
    const imageModalBackdrop = document.getElementById('image-modal-backdrop');
    const imageModalContent = document.getElementById('image-modal-content');
    const closeImageModal = document.getElementById('close-image-modal');
    const previewImage = document.getElementById('preview-image');
    const imageCaption = document.getElementById('image-caption');
    
    // Attach event listener to all image thumbnails
    document.querySelectorAll('.attachment-preview img').forEach(img => {
        img.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const fullSizeUrl = this.src;
            const attachmentCard = this.closest('.attachment-card');
            const fileName = attachmentCard.querySelector('.text-gray-800').textContent.trim();
            
            showImagePreview(fullSizeUrl, fileName);
        });
    });
    
    function showImagePreview(imageUrl, caption) {
        previewImage.src = imageUrl;
        imageCaption.textContent = caption || '';
        
        // Show modal with animation
        imageModal.classList.remove('hidden');
        imageModal.classList.add('flex');
        
        setTimeout(() => {
            imageModalBackdrop.style.opacity = '1';
            imageModalContent.style.opacity = '1';
            imageModalContent.style.transform = 'scale(1)';
        }, 10);
    }
    
    function hideImagePreview() {
        imageModalBackdrop.style.opacity = '0';
        imageModalContent.style.opacity = '0';
        imageModalContent.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            imageModal.classList.add('hidden');
            imageModal.classList.remove('flex');
            previewImage.src = '';
        }, 300);
    }
    
    // Image modal event handlers
    closeImageModal.addEventListener('click', hideImagePreview);
    imageModalBackdrop.addEventListener('click', hideImagePreview);
    
    // Enhanced Attachment Management
    const attachmentCards = document.querySelectorAll('.attachment-card');
    const toggleSelectAllBtn = document.getElementById('toggle-select-all');
    const selectIcon = document.getElementById('select-icon');
    const selectText = document.getElementById('select-text');
    const multiActionBar = document.getElementById('multi-action-bar');
    const selectedCount = document.getElementById('selected-count');
    const deleteSelectedBtn = document.getElementById('delete-selected');
    const cancelSelectionBtn = document.getElementById('cancel-selection');
    let inSelectionMode = false;
    let allSelected = false;
    
    // Initialize delete action for individual attachments
    document.querySelectorAll('.delete-current-file').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (inSelectionMode) return; // Ignore if in selection mode
            
            const id = this.dataset.id;
            const card = this.closest('.attachment-card');
            const checkbox = card.querySelector('input[type="checkbox"]');
            const deleteIcon = card.querySelector('.delete-action-icon');
            const undoIcon = card.querySelector('.undo-action-icon');
            const statusText = card.querySelector('.delete-status-text');
            
            // Toggle checkbox
            checkbox.checked = !checkbox.checked;
            
            // Add visual cue
            if (checkbox.checked) {
                card.classList.add('to-be-deleted');
                card.classList.add('animate-shake');
                deleteIcon.classList.add('hidden');
                undoIcon.classList.remove('hidden');
                undoIcon.classList.add('flex');
                statusText.textContent = 'Akan dihapus';
                statusText.classList.remove('hidden');
                
                showNotification(`File "${card.querySelector('.text-gray-800').textContent.trim()}" ditandai untuk dihapus`, 'info');
                
                // Remove shake animation after it completes
                setTimeout(() => {
                    card.classList.remove('animate-shake');
                }, 500);
            } else {
                card.classList.remove('to-be-deleted');
                deleteIcon.classList.remove('hidden');
                undoIcon.classList.add('hidden');
                undoIcon.classList.remove('flex');
                statusText.classList.add('hidden');
                statusText.textContent = '';
                
                showNotification('Penghapusan dibatalkan', 'info');
            }
        });
    });
    
    // Setup multi-select mode
    if (toggleSelectAllBtn) {
        toggleSelectAllBtn.addEventListener('click', function() {
            inSelectionMode = !inSelectionMode;
            
            if (inSelectionMode) {
                // Enter selection mode
                attachmentCards.forEach(card => {
                    card.classList.add('in-selection-mode');
                    
                    // Make card clickable for selection
                    card.addEventListener('click', cardSelectionHandler);
                });
                
                selectIcon.classList.remove('fa-square');
                selectIcon.classList.add('fa-check-square');
                selectText.textContent = 'Batal Pilih';
                multiActionBar.classList.remove('hidden');
                selectedCount.textContent = '0';
                
                showNotification('Mode pilih lampiran aktif', 'info');
            } else {
                // Exit selection mode
                endSelectionMode();
            }
        });
    }
    
    // Card selection handler
    function cardSelectionHandler() {
        if (!inSelectionMode) return;
        
        this.classList.toggle('selected');
        updateSelectedCount();
    }
    
    // Update selected count
    function updateSelectedCount() {
        if (!selectedCount) return;
        
        const count = document.querySelectorAll('.attachment-card.selected').length;
        selectedCount.textContent = count;
        
        // Update select all button state
        if (count === attachmentCards.length && count > 0) {
            selectIcon.classList.remove('fa-square');
            selectIcon.classList.add('fa-check-square');
            allSelected = true;
        } else {
            if (allSelected) {
                selectIcon.classList.add('fa-square');
                selectIcon.classList.remove('fa-check-square');
                allSelected = false;
            }
        }
    }
    
    // End selection mode
    function endSelectionMode() {
        inSelectionMode = false;
        allSelected = false;
        
        attachmentCards.forEach(card => {
            card.classList.remove('in-selection-mode');
            card.classList.remove('selected');
            
            // Remove click handler
            card.removeEventListener('click', cardSelectionHandler);
        });
        
        selectIcon.classList.add('fa-square');
        selectIcon.classList.remove('fa-check-square');
        selectText.textContent = 'Pilih Semua';
        multiActionBar.classList.add('hidden');
    }
    
    // Delete selected attachments
    if (deleteSelectedBtn) {
        deleteSelectedBtn.addEventListener('click', function() {
            const selectedCards = document.querySelectorAll('.attachment-card.selected');
            
            if (selectedCards.length === 0) {
                showNotification('Pilih lampiran yang ingin dihapus terlebih dahulu', 'warning');
                return;
            }
            
            selectedCards.forEach(card => {
                const checkbox = card.querySelector('input[type="checkbox"]');
                checkbox.checked = true;
                card.classList.add('to-be-deleted');
                
                // Set icon states
                const deleteIcon = card.querySelector('.delete-action-icon');
                const undoIcon = card.querySelector('.undo-action-icon');
                const statusText = card.querySelector('.delete-status-text');
                
                deleteIcon.classList.add('hidden');
                undoIcon.classList.remove('hidden');
                undoIcon.classList.add('flex');
                statusText.textContent = 'Akan dihapus';
                statusText.classList.remove('hidden');
            });
            
            showNotification(`${selectedCards.length} lampiran ditandai untuk dihapus`, 'success');
            endSelectionMode();
        });
    }
    
    // Cancel selection
    if (cancelSelectionBtn) {
        cancelSelectionBtn.addEventListener('click', function() {
            endSelectionMode();
        });
    }
    
    // File Upload Handling
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('attachments');
    const previewContainer = document.getElementById('attachment-preview');
    const uploadProgress = document.getElementById('upload-progress');
    const progressRing = document.querySelector('.upload-progress-ring-circle');
    const progressText = document.querySelector('.upload-progress-text');
    const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB
    const MAX_FILES = 5;
    
    // Skip if dropzone doesn't exist
    if (!dropzone) return;
    
    // Simulate progress animation
    function simulateUploadProgress(callback) {
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.floor(Math.random() * 10) + 5;
            if (progress > 100) progress = 100;
            
            // Update progress ring
            const circumference = 2 * Math.PI * 30; // r = 30
            const offset = circumference - (progress / 100 * circumference);
            progressRing.style.strokeDasharray = `${circumference} ${circumference}`;
            progressRing.style.strokeDashoffset = offset;
            
            // Update text
            progressText.textContent = `${progress}%`;
            
            if (progress === 100) {
                clearInterval(interval);
                setTimeout(() => {
                    callback();
                }, 500);
            }
        }, 200);
    }
    
    // Open file dialog when dropzone is clicked
    dropzone.addEventListener('click', function() {
        fileInput.click();
    });
    
    // Handle file selection
    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });
    
    // Prevent default behavior for drag events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, function(e) {
            e.preventDefault();
            e.stopPropagation();
        });
    });
    
    // Add visual cue for drag events
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, function() {
            dropzone.querySelector('div').classList.add('border-blue-500');
            dropzone.querySelector('div').classList.add('bg-blue-50/80');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, function() {
            dropzone.querySelector('div').classList.remove('border-blue-500');
            dropzone.querySelector('div').classList.remove('bg-blue-50/80');
        });
    });
    
    // Handle dropped files
    dropzone.addEventListener('drop', function(e) {
        const files = e.dataTransfer.files;
        handleFiles(files);
    });
    
    function handleFiles(files) {
        if (!files || files.length === 0) return;
        
        // Count current attachments
        const currentAttachmentCount = document.querySelectorAll('.attachment-card').length;
        const currentNewAttachmentCount = document.querySelectorAll('.file-preview-item:not(.current-attachment)').length;
        const totalFilesAfterUpload = currentAttachmentCount + currentNewAttachmentCount + files.length;
        
        // Check if exceeding max files limit
        if (totalFilesAfterUpload > MAX_FILES) {
            showNotification(`Maksimal ${MAX_FILES} file yang dapat diunggah.`, 'warning');
            return;
        }
        
        // Show upload progress
        uploadProgress.classList.remove('hidden');
        
        // Process files
        simulateUploadProgress(() => {
            // Hide progress and show previews
            uploadProgress.classList.add('hidden');
            
            // Convert FileList to array for iteration
            Array.from(files).forEach((file, index) => {
                if (file.size > MAX_FILE_SIZE) {
                    showNotification(`File ${file.name} terlalu besar (maks. 10MB)`, 'error');
                    return;
                }
                
                // Create unique ID
                const fileId = `file-${Date.now()}-${index}`;
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Create preview element
                    const previewItem = document.createElement('div');
                    previewItem.className = 'file-preview-item';
                    previewItem.dataset.fileId = fileId;
                    
                    if (file.type.startsWith('image/')) {
                        previewItem.innerHTML = `
                            <div class="preview-img-container">
                                <img src="${e.target.result}" alt="${file.name}" class="preview-img">
                                <div class="preview-overlay">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>
                            <div class="preview-info">
                                <div class="truncate text-sm font-medium text-gray-700">${file.name}</div>
                                <div class="text-xs text-gray-500">${formatFileSize(file.size)}</div>
                            </div>
                            <button type="button" class="remove-file" title="Hapus">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                    } else {
                        // For non-image files
                        let iconClass = 'fa-file';
                        let iconColor = 'text-blue-500';
                        
                        const ext = file.name.split('.').pop().toLowerCase();
                        if (ext === 'pdf') {
                            iconClass = 'fa-file-pdf';
                            iconColor = 'text-red-500';
                        } else if (['doc', 'docx'].includes(ext)) {
                            iconClass = 'fa-file-word';
                            iconColor = 'text-blue-600';
                        } else if (['xls', 'xlsx'].includes(ext)) {
                            iconClass = 'fa-file-excel';
                            iconColor = 'text-green-600';
                        }
                        
                        previewItem.innerHTML = `
                            <div class="preview-file bg-gray-50">
                                <i class="fas ${iconClass} text-3xl ${iconColor}"></i>
                            </div>
                            <div class="preview-info">
                                <div class="truncate text-sm font-medium text-gray-700">${file.name}</div>
                                <div class="text-xs text-gray-500">${formatFileSize(file.size)}</div>
                            </div>
                            <button type="button" class="remove-file" title="Hapus">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                    }
                    
                    // Add to preview container
                    previewContainer.appendChild(previewItem);
                    
                    // Add remove event
                    const removeBtn = previewItem.querySelector('.remove-file');
                    removeBtn.addEventListener('click', function() {
                        previewItem.style.opacity = '0';
                        previewItem.style.transform = 'scale(0.9) translateY(10px)';
                        
                        setTimeout(() => {
                            previewItem.remove();
                        }, 300);
                    });
                };
                
                reader.readAsDataURL(file);
            });
        });
    }
    
    // Format file size
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' bytes';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }
    
    // Form submit handling
    form.addEventListener('submit', function(e) {
        // Validate content and copy to hidden input
        const content = contentEditor.innerHTML;
        hiddenInput.value = content;
        
        if (!contentEditor.textContent.trim() && !content.includes('img')) {
            e.preventDefault();
            showNotification('Konten postingan tidak boleh kosong', 'error');
            contentEditor.focus();
            return;
        }
        
        // Animate submit button
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menyimpan...
        `;
    });
    
    // Show notification
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed bottom-5 right-5 p-4 rounded-lg shadow-lg z-50 flex items-center space-x-3 animate-slideUp transition-all max-w-xs`;
        
        let bgColor, iconClass;
        switch (type) {
            case 'error':
                bgColor = 'bg-red-500';
                iconClass = 'fa-exclamation-circle';
                break;
            case 'warning':
                bgColor = 'bg-amber-500';
                iconClass = 'fa-exclamation-triangle';
                break;
            case 'success':
                bgColor = 'bg-blue-500';
                iconClass = 'fa-check-circle';
                break;
            default:
                bgColor = 'bg-blue-500';
                iconClass = 'fa-info-circle';
        }
        
        notification.classList.add(bgColor);
        
        notification.innerHTML = `
            <div class="flex-shrink-0">
                <i class="fas ${iconClass} text-white"></i>
            </div>
            <p class="text-white text-sm">${message}</p>
            <button class="ml-auto text-white hover:text-gray-200 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto dismiss after 5 seconds
        const dismissTimeout = setTimeout(() => {
            dismissNotification();
        }, 5000);
        
        // Manual dismiss
        notification.querySelector('button').addEventListener('click', () => {
            clearTimeout(dismissTimeout);
            dismissNotification();
        });
        
        function dismissNotification() {
            notification.classList.add('opacity-0', 'translate-y-2');
            
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
    }
    
    // Set last updated timestamp
    const lastUpdatedTimestamp = document.querySelector('.last-updated-timestamp');
    if (lastUpdatedTimestamp) {
        lastUpdatedTimestamp.textContent = '2025-05-21 12:31:37';
    }
    
    // Set last editor info
    const lastEditor = document.querySelector('.last-editor');
    if (lastEditor) {
        lastEditor.textContent = 'ahmfzui';
    }
});
</script>
@endpush
@endsection