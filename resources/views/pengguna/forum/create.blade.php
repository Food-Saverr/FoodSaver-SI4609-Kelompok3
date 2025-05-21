@extends('layouts.app')

@section('title', 'Buat Postingan Baru')

@section('content')
<!-- Animated Background Elements -->
<div class="fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-[10%] -right-[10%] w-[35%] h-[40%] bg-gradient-to-br from-green-100/30 to-green-200/20 blur-3xl rounded-full animate-blob"></div>
    <div class="absolute top-[30%] -left-[5%] w-[25%] h-[30%] bg-gradient-to-br from-blue-100/20 to-green-100/20 blur-3xl rounded-full animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-[10%] right-[20%] w-[30%] h-[40%] bg-gradient-to-br from-green-100/20 to-blue-100/20 blur-3xl rounded-full animate-blob animation-delay-4000"></div>
</div>

<div class="container mx-auto px-4 py-8 pt-24 relative z-10">
    <div class="max-w-4xl mx-auto">
        <!-- Floating Action Button -->
        <div class="fixed bottom-10 right-10 z-50">
            <button type="submit" form="createPostForm" class="flex items-center justify-center w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 shadow-xl rounded-full hover:shadow-green-200/50 hover:-translate-y-1 transition-all overflow-hidden group">
                <span class="absolute inset-0 w-full h-full bg-gradient-to-tr from-green-400 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <i class="fas fa-paper-plane text-lg text-white"></i>
                </span>
                <i class="fas fa-paper-plane text-lg text-white group-hover:scale-110 transition-transform"></i>
            </button>
        </div>
        
        <!-- Breadcrumb -->
        <a href="{{ route('pengguna.forum.index') }}" class="text-sm text-green-600 flex items-center hover:text-green-700 transition-colors group mb-6 w-max">
            <span class="inline-block mr-2 transition-transform group-hover:-translate-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </span>
            Kembali ke Forum
        </a>

        <!-- Main Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-6 lg:p-8 shadow-xl shadow-gray-100/80 border border-gray-100">
            <!-- Card Header with Animation -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-8 pb-8 border-b border-gray-100">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white shadow-lg transform rotate-3 hover:rotate-6 transition-transform overflow-hidden">
                        <i class="fas fa-feather-alt text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-1">
                        <span class="bg-gradient-to-r from-green-500 to-emerald-600 bg-clip-text text-transparent">
                            Tulis Postingan Baru
                        </span>
                    </h1>
                    <p class="text-gray-600">
                        Bagikan pengalaman & tips sustain makanan dengan komunitas Food Saver
                    </p>
                </div>
            </div>

            <form action="{{ route('pengguna.forum.store') }}" method="POST" enctype="multipart/form-data" id="createPostForm" class="space-y-8">
                @csrf
                
                <!-- Title Input with Animation -->
                <div class="space-y-2">
                    <label for="judul" class="text-sm font-semibold text-gray-700 flex items-center">
                        <span class="bg-green-100 p-1 rounded-md text-green-600 mr-2">
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
                            value="{{ old('judul') }}" 
                            placeholder="Judul Postingan..."
                            required
                            autocomplete="off">
                        <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-green-400 to-green-600 w-0 group-focus:w-full transition-all duration-300"></div>
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
                        <span class="bg-blue-100 p-1 rounded-md text-blue-600 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </span>
                        Bagikan pengalaman atau cerita kamu
                    </label>
                    
                    <!-- Modern Text Editor -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 transition-all hover:shadow-md">
                        <div id="content-editor" class="min-h-[250px] p-6 focus:outline-none" contenteditable="true" data-placeholder="Tulis cerita dan pengalaman kamu di sini..."></div>
                        
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
                        
                        <input type="hidden" name="konten" id="konten-hidden">
                        
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
                
                <!-- File Upload with Enhanced Visual -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 flex items-center">
                        <span class="bg-amber-100 p-1 rounded-md text-amber-600 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                        </span>
                        Lampirkan gambar atau file
                    </label>
                    
                    <!-- Beautiful Upload Area -->
                    <div id="dropzone" class="group cursor-pointer">
                        <div class="border-2 border-dashed border-gray-200 rounded-xl transition-all duration-300 bg-gray-50/50 group-hover:border-green-300 group-hover:bg-green-50/50 overflow-hidden">
                            <div class="p-8 text-center">
                                <div class="upload-animation mx-auto mb-4 w-16 h-16 rounded-full flex items-center justify-center bg-green-50 group-hover:scale-110 transition-transform duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500 transform group-hover:scale-110 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <p class="text-gray-700 font-medium mb-2">
                                    <span class="text-green-600">Seret & lepas file</span> atau klik untuk pilih
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
                                    <circle class="upload-progress-ring-circle" cx="34" cy="34" r="30" fill="none" stroke="#10b981" stroke-width="4" stroke-dasharray="188.5" stroke-dashoffset="188.5"></circle>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center text-green-600 font-semibold text-lg upload-progress-text">0%</div>
                            </div>
                            <p class="text-green-600">Mengunggah file...</p>
                        </div>
                    </div>
                    
                    <!-- Improved File Preview Container -->
                    <div class="bg-gradient-to-r from-green-50/50 to-blue-50/50 rounded-2xl p-5 border border-green-100/80 mt-5 relative overflow-hidden" id="attachment-container" style="display: none;">
                        <!-- Decoration dots -->
                        <div class="absolute top-0 right-0 opacity-20">
                            <div class="grid grid-cols-5 gap-1.5">
                                @for ($i = 0; $i < 20; $i++)
                                    <div class="w-1.5 h-1.5 rounded-full bg-green-400"></div>
                                @endfor
                            </div>
                        </div>
                        
                        <!-- Label -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-sm font-semibold text-gray-700 flex items-center">
                                <span class="bg-green-100 p-1 rounded-md text-green-600 mr-2">
                                    <i class="fas fa-paperclip"></i>
                                </span>
                                File yang akan diunggah
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800" id="attachment-count">
                                    0 file
                                </span>
                            </div>
                        </div>
                        
                        <!-- Attachment preview grid -->
                        <div id="attachment-preview" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                        
                        <!-- Help text -->
                        <div class="flex items-center space-x-2 text-sm text-gray-600 mt-4">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-info text-green-500 text-xs"></i>
                            </div>
                            <p>Klik ikon sampah untuk menghapus lampiran. File akan diunggah setelah postingan dipublikasikan.</p>
                        </div>
                    </div>
                    
                    @error('attachments.*')
                        <div class="text-red-500 text-sm flex items-center mt-1 animate-pulse">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Submit Button Area -->
                <div class="pt-6 flex flex-col-reverse sm:flex-row gap-4 justify-between">
                    <a href="{{ route('pengguna.forum.index') }}" class="flex items-center justify-center px-6 py-3.5 bg-white border border-gray-300 rounded-xl text-gray-700 font-medium shadow-sm hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>
                    
                    <button type="submit" id="submit-btn" class="flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-green-500 to-green-600 text-white font-medium rounded-xl shadow-lg shadow-green-100 hover:shadow-green-200/50 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Publikasikan Postingan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Inspirasi Tips with Gorgeous Design -->
<div class="container mx-auto px-4 pb-16 relative z-10">
    <div class="max-w-4xl mx-auto mt-8">
        <div class="bg-gradient-to-br from-blue-50 to-green-50 rounded-3xl shadow-lg overflow-hidden border border-blue-100/50">
            <div class="p-0.5 bg-gradient-to-r from-green-400/20 to-blue-500/20">
                <div class="grid grid-cols-1 md:grid-cols-3">
                    <!-- Heading -->
                    <div class="p-6 md:col-span-1 flex md:flex-col md:items-start items-center gap-4 border-b md:border-b-0 md:border-r border-blue-100/50">
                        <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white shadow-lg transform md:rotate-3 hover:rotate-6 transition-transform">
                            <i class="fas fa-lightbulb text-xl md:text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl text-blue-800">Tips Menulis</h3>
                            <p class="text-blue-600 text-sm">Untuk postingan berkualitas</p>
                        </div>
                    </div>
                    
                    <!-- Tips Content -->
                    <div class="p-6 md:col-span-2">
                        <ul class="space-y-5">
                            <li class="flex items-start transform transition-all hover:translate-x-1">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 text-green-600">
                                    <i class="fas fa-check text-sm"></i>
                                </span>
                                <div>
                                    <h4 class="font-medium text-gray-900">Buat judul yang menggugah rasa ingin tahu</h4>
                                    <p class="text-gray-600 text-sm">Judul yang menarik meningkatkan kemungkinan postingan kamu dibaca dan mendapat respons.</p>
                                </div>
                            </li>
                            <li class="flex items-start transform transition-all hover:translate-x-1">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 text-green-600">
                                    <i class="fas fa-check text-sm"></i>
                                </span>
                                <div>
                                    <h4 class="font-medium text-gray-900">Sertakan gambar yang relevan</h4>
                                    <p class="text-gray-600 text-sm">Visual dapat menyampaikan ide dengan lebih efektif dan membuat postingan kamu lebih menarik.</p>
                                </div>
                            </li>
                            <li class="flex items-start transform transition-all hover:translate-x-1">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 text-green-600">
                                    <i class="fas fa-check text-sm"></i>
                                </span>
                                <div>
                                    <h4 class="font-medium text-gray-900">Akhiri dengan ajakan diskusi</h4>
                                    <p class="text-gray-600 text-sm">Tanyakan pendapat pembaca di akhir untuk mendorong interaksi dan engagement.</p>
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

<!-- Image Preview Modal -->
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
        border-left: 4px solid #10b981;
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
    
    .attachment-card > div {
        height: 100%;
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
        justify-content: center; /* Perbaikan dari justify-center menjadi justify-content */
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
        stroke: #10b981;
        stroke-linecap: round;
        transform-origin: center;
        transform: rotate(-90deg);
        transition: stroke-dashoffset 0.3s;
    }
    
    /* Enhanced attachment display */
    .attachment-preview {
        width: 24px;
        min-width: 24px;
        position: relative;
        overflow: hidden;
    }
    
    .attachment-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .attachment-action {
        cursor: pointer;
    }
    
    .delete-status-text {
        display: none;
    }
    
    /* Masonry grid effect for attachments */
    @media (min-width: 768px) {
        #attachment-preview {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            grid-auto-rows: minmax(100px, auto);
            grid-gap: 16px;
        }
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
    const form = document.getElementById('createPostForm');
    const attachmentContainer = document.getElementById('attachment-container');
    const attachmentCount = document.getElementById('attachment-count');
    
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
    
    // Helper to place caret at end of content
    function placeCaretAtEnd() {
        const range = document.createRange();
        const sel = window.getSelection();
        range.selectNodeContents(contentEditor);
        range.collapse(false);
        sel.removeAllRanges();
        sel.addRange(range);
    }
    
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
            
            // Update hidden input
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
    if (closeImageModal) {
        closeImageModal.addEventListener('click', hideImagePreview);
        imageModalBackdrop.addEventListener('click', hideImagePreview);
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
            dropzone.querySelector('div').classList.add('border-green-500');
            dropzone.querySelector('div').classList.add('bg-green-50/80');
        });
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, function() {
            dropzone.querySelector('div').classList.remove('border-green-500');
            dropzone.querySelector('div').classList.remove('bg-green-50/80');
        });
    });
    
    // Handle dropped files
    dropzone.addEventListener('drop', function(e) {
        const files = e.dataTransfer.files;
        handleFiles(files);
    });
    
    function handleFiles(files) {
        if (!files || files.length === 0) return;
        
        const currentFiles = document.querySelectorAll('.attachment-card').length;
        
        if (currentFiles + files.length > MAX_FILES) {
            showNotification(`Maksimal ${MAX_FILES} file yang dapat diunggah.`, 'warning');
            return;
        }
        
        // Show upload progress
        uploadProgress.classList.remove('hidden');
        
        // Process files
        simulateUploadProgress(() => {
            // Hide progress and show previews
            uploadProgress.classList.add('hidden');
            
            // Show attachment container if it's not already visible
            attachmentContainer.style.display = 'block';
            
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
                    // Create preview element for the new improved horizontal card style
                    const attachmentCard = document.createElement('div');
                    attachmentCard.className = 'attachment-card group';
                    attachmentCard.dataset.fileId = fileId;
                    
                    if (file.type.startsWith('image/')) {
                        const fileExt = file.name.split('.').pop().toLowerCase();
                        attachmentCard.innerHTML = `
                            <div class="flex bg-white rounded-xl overflow-hidden shadow-sm border border-green-100/60 transition-all duration-300 hover:shadow-md hover:border-green-200">
                                <!-- Left: Preview thumbnail -->
                                <div class="attachment-preview w-24 min-w-24 relative overflow-hidden">
                                    <img src="${e.target.result}" alt="${file.name}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-tr from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <!-- File extension badge -->
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent flex justify-center py-1">
                                        <span class="text-xs text-white font-medium">
                                            ${fileExt.toUpperCase()}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Right: Info & actions -->
                                <div class="flex-grow p-3 flex flex-col justify-between relative overflow-hidden">
                                    <!-- File name & size -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-800 truncate max-w-full" title="${file.name}">
                                            ${file.name}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-0.5 flex items-center">
                                            <i class="fas fa-weight text-gray-400 mr-1"></i>
                                            ${formatFileSize(file.size)}
                                        </p>
                                    </div>
                                    
                                    <!-- Action buttons -->
                                    <div class="flex items-center justify-between mt-1">
                                        <a href="#" class="text-xs text-green-600 hover:text-green-800 transition-colors flex items-center preview-image-btn">
                                            <i class="fas fa-eye mr-1"></i>
                                            Lihat
                                        </a>
                                        
                                        <div class="flex items-center gap-3">
                                            <span class="delete-status-text text-xs hidden"></span>
                                            <div class="attachment-action cursor-pointer remove-attachment">
                                                <span class="delete-action-icon w-7 h-7 flex items-center justify-center rounded-full text-red-500 hover:bg-red-50 transition-colors">
                                                    <i class="fas fa-trash-alt text-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        // For non-image files
                        let iconClass = 'fa-file';
                        let iconColor = 'text-blue-500';
                        let bgColor = 'bg-blue-50';
                        
                        const ext = file.name.split('.').pop().toLowerCase();
                        if (ext === 'pdf') {
                            iconClass = 'fa-file-pdf';
                            iconColor = 'text-red-500';
                            bgColor = 'bg-red-50';
                        } else if (['doc', 'docx'].includes(ext)) {
                            iconClass = 'fa-file-word';
                            iconColor = 'text-blue-600';
                            bgColor = 'bg-blue-50';
                        } else if (['xls', 'xlsx'].includes(ext)) {
                            iconClass = 'fa-file-excel';
                            iconColor = 'text-green-600';
                            bgColor = 'bg-green-50';
                        }
                        
                        attachmentCard.innerHTML = `
                            <div class="flex bg-white rounded-xl overflow-hidden shadow-sm border border-green-100/60 transition-all duration-300 hover:shadow-md hover:border-green-200">
                                <!-- Left: Icon preview -->
                                <div class="attachment-preview w-24 min-w-24 relative overflow-hidden">
                                    <div class="w-full h-full flex items-center justify-center ${bgColor}">
                                        <i class="fas ${iconClass} text-2xl ${iconColor}"></i>
                                    </div>
                                    
                                    <!-- File extension badge -->
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent flex justify-center py-1">
                                        <span class="text-xs text-white font-medium">
                                            ${ext.toUpperCase()}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Right: Info & actions -->
                                <div class="flex-grow p-3 flex flex-col justify-between relative overflow-hidden">
                                    <!-- File name & size -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-800 truncate max-w-full" title="${file.name}">
                                            ${file.name}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-0.5 flex items-center">
                                            <i class="fas fa-weight text-gray-400 mr-1"></i>
                                            ${formatFileSize(file.size)}
                                        </p>
                                    </div>
                                    
                                    <!-- Action buttons -->
                                    <div class="flex items-center justify-end mt-1">
                                        <div class="flex items-center gap-3">
                                            <span class="delete-status-text text-xs hidden"></span>
                                            <div class="attachment-action cursor-pointer remove-attachment">
                                                <span class="delete-action-icon w-7 h-7 flex items-center justify-center rounded-full text-red-500 hover:bg-red-50 transition-colors">
                                                    <i class="fas fa-trash-alt text-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    
                    // Add to preview container
                    previewContainer.appendChild(attachmentCard);
                    
                    // Update attachment count
                    updateAttachmentCount();
                    
                    // Add remove event
                    const removeBtn = attachmentCard.querySelector('.remove-attachment');
                    removeBtn.addEventListener('click', function() {
                        attachmentCard.classList.add('to-be-deleted');
                        attachmentCard.classList.add('animate-shake');
                        
                        // Add animation delay before removing
                        setTimeout(() => {
                            attachmentCard.style.opacity = '0';
                            attachmentCard.style.transform = 'scale(0.9) translateY(10px)';
                            
                            setTimeout(() => {
                                attachmentCard.remove();
                                updateAttachmentCount();
                                
                                // Hide container if no attachments left
                                if (document.querySelectorAll('.attachment-card').length === 0) {
                                    attachmentContainer.style.display = 'none';
                                }
                            }, 300);
                        }, 500);
                    });
                    
                    // Add preview event for images
                    const previewBtn = attachmentCard.querySelector('.preview-image-btn');
                    if (previewBtn && file.type.startsWith('image/')) {
                        previewBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            showImagePreview(e.target.result, file.name);
                        });
                        
                        // Also make the image clickable for preview
                        const imgElement = attachmentCard.querySelector('img');
                        if (imgElement) {
                            imgElement.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                showImagePreview(this.src, file.name);
                            });
                        }
                    }
                };
                
                reader.readAsDataURL(file);
            });
        });
    }
    
    // Update attachment count
    function updateAttachmentCount() {
        const count = document.querySelectorAll('.attachment-card').length;
        attachmentCount.textContent = `${count} file`;
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
            Mempublikasikan...
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
                bgColor = 'bg-green-500';
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
    
    // Initialize
    updateWordCount();
});
</script>
@endpush
@endsection