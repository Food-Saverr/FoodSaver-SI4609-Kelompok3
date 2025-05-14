@extends('layouts.app')

@section('title', 'Edit Postingan')

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
                <a href="{{ route('pengguna.forum.show', $post->ID_ForumPost) }}" class="text-gray-500 hover:text-green-600">{{ Str::limit($post->judul, 40) }}</a>
            </li>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </li>
            <li>
                <span class="text-gray-700 font-medium">Edit Postingan</span>
            </li>
        </ol>
    </nav>

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-green-600 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Postingan
        </h1>
        <p class="text-gray-600 mt-2">Perbarui konten postingan forum kamu.</p>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <form action="{{ route('pengguna.forum.update', $post->ID_ForumPost) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">
                            Judul Postingan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('judul') border-red-500 @enderror" 
                            id="judul" name="judul" value="{{ old('judul', $post->judul) }}" 
                            required autofocus>
                        @error('judul')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Buat judul yang menarik dan menggambarkan isi postingan kamu.</p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="konten" class="block text-sm font-medium text-gray-700 mb-1">
                            Konten <span class="text-red-500">*</span>
                        </label>
                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('konten') border-red-500 @enderror" 
                            id="konten" name="konten" rows="10" required>{{ old('konten', $post->konten) }}</textarea>
                        @error('konten')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    @if($post->attachments->isNotEmpty())
                    <div class="mb-6">
                        <div class="mb-2 flex items-center">
                            <span class="block text-sm font-medium text-gray-700">Lampiran Saat Ini</span>
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $post->attachments->count() }} file
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($post->attachments as $attachment)
                                <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50 group transition-all duration-200 hover:shadow-md">
                                    <div class="relative">
                                        @if($attachment->isImage())
                                            <div class="h-36 overflow-hidden">
                                                <img src="{{ asset('storage/' . $attachment->path) }}" class="w-full h-full object-cover" alt="{{ $attachment->nama_file }}">
                                            </div>
                                        @else
                                            <div class="h-36 flex items-center justify-center">
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
                                                
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-3 border-t border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <span class="text-xs font-medium text-gray-700 truncate max-w-[80%]" title="{{ $attachment->nama_file }}">
                                                {{ $attachment->nama_file }}
                                            </span>
                                            <div class="flex items-center">
                                                <label class="cursor-pointer flex items-center justify-center w-6 h-6 rounded-full hover:bg-gray-200 transition-colors" title="Hapus lampiran">
                                                    <input type="checkbox" class="sr-only delete-attachment" name="deleted_attachments[]" value="{{ $attachment->ID_Attachment }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Centang ikon tempat sampah untuk menghapus lampiran.</p>
                    </div>
                    @endif
                    
                    <div class="mb-8">
                        <label for="attachments" class="block text-sm font-medium text-gray-700 mb-1">
                            Tambah Lampiran Baru (Opsional)
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="attachments" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mb-3 w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="mb-1 text-sm text-gray-600">
                                        <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        JPG, PNG, GIF, PDF (Maks. 10MB)
                                    </p>
                                </div>
                                <input id="attachments" name="attachments[]" type="file" class="hidden" multiple />
                            </label>
                        </div>
                        @error('attachments.*')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <div id="attachment-preview" class="mt-4 flex flex-wrap gap-3"></div>
                    </div>
                    
                    <div class="flex justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('pengguna.forum.show', $post->ID_ForumPost) }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
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
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/trix@1.3.1/dist/trix.css" rel="stylesheet">
<style>
    trix-editor {
        min-height: 20rem;
        max-height: 40rem;
        overflow-y: auto;
        @apply border border-gray-300 rounded-lg px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500;
    }
    
    trix-toolbar [data-trix-button-group] {
        @apply border-gray-300 rounded-md overflow-hidden;
    }
    
    trix-toolbar [data-trix-button] {
        @apply bg-white border-r border-gray-300;
    }
    
    trix-toolbar [data-trix-button].trix-active {
        @apply bg-gray-200 text-gray-700;
    }
    
    trix-toolbar [data-trix-button]:hover {
        @apply bg-gray-100;
    }
    
    .attachment-preview-item {
        @apply relative w-24 h-24 rounded-lg overflow-hidden shadow-sm;
    }
    
    .attachment-preview-item img {
        @apply w-full h-full object-cover;
    }
    
    .attachment-preview-item .file-icon {
        @apply flex items-center justify-center w-full h-full bg-gray-100;
    }
    
    .attachment-preview-item .file-ext {
        @apply absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white text-xs text-center py-1 px-2;
    }
    
    /* For checked attachment delete boxes */
    .delete-attachment:checked + svg {
        @apply text-red-500;
    }
    
    .delete-attachment:checked + svg + .attachment-img {
        @apply opacity-50;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/trix@1.3.1/dist/trix.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize trix editor with custom behavior
        const editor = document.querySelector('trix-editor');
        if (editor) {
            const content = document.getElementById('konten').value;
            editor.editor.loadHTML(content);
            
            editor.addEventListener('trix-change', function() {
                document.getElementById('konten').value = editor.editor.getHTML();
            });
            
            // Prevent file attachments in trix (we'll handle it separately)
            editor.addEventListener('trix-file-accept', function(e) {
                e.preventDefault();
            });
        }
        
        // Preview new attachments
        const attachmentsInput = document.getElementById('attachments');
        const previewContainer = document.getElementById('attachment-preview');
        
        if (attachmentsInput) {
            attachmentsInput.addEventListener('change', function() {
                previewContainer.innerHTML = '';
                
                Array.from(this.files).forEach(file => {
                    const reader = new FileReader();
                    const fileExt = file.name.split('.').pop().toLowerCase();
                    
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'attachment-preview-item';
                        
                        if (file.type.startsWith('image/')) {
                            previewItem.innerHTML = `
                                <img src="${e.target.result}" alt="${file.name}">
                                <div class="file-ext">${fileExt}</div>
                            `;
                        } else {
                            let iconClass = 'document';
                            let iconColor = 'text-blue-500';
                            
                            if (fileExt === 'pdf') {
                                iconClass = 'document-text';
                                iconColor = 'text-red-500';
                            }
                            else if (['doc', 'docx'].includes(fileExt)) {
                                iconClass = 'document-text';
                                iconColor = 'text-blue-600';
                            }
                            else if (['xls', 'xlsx'].includes(fileExt)) {
                                iconClass = 'table';
                                iconColor = 'text-green-600';
                            }
                            
                            previewItem.innerHTML = `
                                <div class="file-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 ${iconColor}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="file-ext">${fileExt}</div>
                            `;
                        }
                        
                        previewContainer.appendChild(previewItem);
                    };
                    
                    reader.readAsDataURL(file);
                });
            });
        }
        
        // Visual effect for deleted attachments
        const deleteAttachments = document.querySelectorAll('.delete-attachment');
        deleteAttachments.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const label = this.closest('label');
                const card = this.closest('.border');
                if (this.checked) {
                    card.classList.add('opacity-50');
                    label.querySelector('svg').classList.add('text-red-500');
                } else {
                    card.classList.remove('opacity-50');
                    label.querySelector('svg').classList.remove('text-red-500');
                }
            });
        });
    });
</script>
@endpush