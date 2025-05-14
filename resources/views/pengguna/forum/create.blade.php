@extends('layouts.app')

@section('title', 'Buat Postingan Baru')

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
                <span class="text-gray-700 font-medium">Buat Postingan Baru</span>
            </li>
        </ol>
    </nav>
    
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-green-600 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
            Buat Postingan Baru
        </h1>
        <p class="text-gray-600 mt-2">Bagikan pengalaman, pertanyaan, atau ide kamu dengan komunitas Food Saver.</p>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6">
                <form action="{{ route('pengguna.forum.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">
                            Judul Postingan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('judul') border-red-500 @enderror" 
                            id="judul" name="judul" value="{{ old('judul') }}" 
                            placeholder="Tulis judul menarik untuk postingan kamu"
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
                        <input id="konten" name="konten" type="hidden" value="{{ old('konten') }}">
                        <trix-editor input="konten" placeholder="Tulis konten postingan di sini..." class="trix-content"></trix-editor>
                        @error('konten')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-8">
                        <label for="attachments" class="block text-sm font-medium text-gray-700 mb-1">
                            Lampiran (Opsional)
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
                        <div id="attachment-preview" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3"></div>
                    </div>
                    
                    <div class="flex justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('pengguna.forum.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Kirim Postingan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Tips untuk membuat postingan yang bagus -->
        <div class="mt-8 bg-blue-50 rounded-xl p-6 shadow-sm border border-blue-100">
            <h3 class="text-lg font-semibold text-blue-800 flex items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                Tips Membuat Postingan Yang Menarik
            </h3>
            <ul class="text-sm text-blue-800 space-y-2">
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Gunakan judul yang jelas dan menarik untuk menarik perhatian pembaca.</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Struktur konten dengan baik: pendahuluan, isi, dan kesimpulan.</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Tambahkan gambar atau lampiran yang relevan untuk memperjelas postingan kamu.</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Berikan informasi yang akurat dan bermanfaat bagi komunitas.</span>
                </li>
                <li class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Pastikan untuk merespon komentar dari anggota komunitas lainnya.</span>
                </li>
            </ul>
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
        @apply relative w-full h-24 rounded-lg overflow-hidden shadow-sm;
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
    
    .attachment-preview-item .remove-attachment {
        @apply absolute top-1 right-1 w-6 h-6 rounded-full bg-red-500 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/trix@1.3.1/dist/trix.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prevent file attachments in trix (we'll handle it separately)
        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        });
        
        // Preview attachments
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
                        previewItem.className = 'attachment-preview-item group';
                        
                        if (file.type.startsWith('image/')) {
                            previewItem.innerHTML = `
                                <img src="${e.target.result}" alt="${file.name}">
                                <div class="file-ext">${fileExt}</div>
                                <button type="button" class="remove-attachment" onclick="removeAttachmentPreview(this)">×</button>
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
                                <button type="button" class="remove-attachment" onclick="removeAttachmentPreview(this)">×</button>
                            `;
                        }
                        
                        previewContainer.appendChild(previewItem);
                    };
                    
                    reader.readAsDataURL(file);
                });
            });
        }
    });
    
    // Function to remove attachment preview
    function removeAttachmentPreview(button) {
        const previewItem = button.closest('.attachment-preview-item');
        previewItem.remove();
        
        // Since we can't directly manipulate the FileList, 
        // we'd need to recreate the file input to clear the selection
        // or implement a tracking mechanism to exclude this file when submitting
        // This is a limitation of HTML file inputs
    }
</script>
@endpush