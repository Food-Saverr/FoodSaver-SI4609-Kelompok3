@extends('layouts.appdonatur')

@section('title', 'Tambah Makanan Donasi')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-4xl mx-auto bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
        <div class="mb-8">
            <a href="{{ route('donatur.food-listing.index') }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-3">
                <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                Kembali ke Daftar Makanan
            </a>
            <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Tambah Makanan Donasi</h1>
            <p class="text-gray-500">Lengkapi informasi makanan yang akan didonasikan</p>
        </div>

        <!-- General Error Messages -->
        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-up-delay">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">Mohon periksa kembali form Anda</p>
                    <ul class="mt-1 text-sm list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('donatur.food-listing.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="food-form">
            @csrf
            
            <!-- Two-Column Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-6">
                    <!-- Nama Makanan -->
                    <div>
                        <label for="Nama_Makanan" class="block text-gray-700 font-medium mb-1">Nama Makanan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fas fa-utensils"></i>
                            </span>
                            <input
                                type="text"
                                name="Nama_Makanan"
                                id="Nama_Makanan"
                                placeholder="Masukkan nama makanan"
                                value="{{ old('Nama_Makanan') }}"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border {{ $errors->has('Nama_Makanan') ? 'border-red-500' : 'border-gray-200' }} bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                                required
                            />
                            @if($errors->has('Nama_Makanan'))
                            <span class="text-red-600 text-sm mt-2 block">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $errors->first('Nama_Makanan') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Kategori Makanan -->
                    <div>
                        <label for="Kategori_Makanan" class="block text-gray-700 font-medium mb-1">Kategori Makanan</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fas fa-tags"></i>
                            </span>
                            <select
                                name="Kategori_Makanan"
                                id="Kategori_Makanan"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border {{ $errors->has('Kategori_Makanan') ? 'border-red-500' : 'border-gray-200' }} bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                            >
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Makanan Berat" {{ old('Kategori_Makanan') == 'Makanan Berat' ? 'selected' : '' }}>Makanan Berat</option>
                                <option value="Makanan Ringan" {{ old('Kategori_Makanan') == 'Makanan Ringan' ? 'selected' : '' }}>Makanan Ringan</option>
                                <option value="Makanan Penutup" {{ old('Kategori_Makanan') == 'Makanan Penutup' ? 'selected' : '' }}>Makanan Penutup</option>
                                <option value="Minuman" {{ old('Kategori_Makanan') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                                <option value="Sayuran" {{ old('Kategori_Makanan') == 'Sayuran' ? 'selected' : '' }}>Sayuran</option>
                                <option value="Buah-buahan" {{ old('Kategori_Makanan') == 'Buah-buahan' ? 'selected' : '' }}>Buah-buahan</option>
                            </select>
                            @if($errors->has('Kategori_Makanan'))
                            <span class="text-red-600 text-sm mt-2 block">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $errors->first('Kategori_Makanan') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Status Makanan -->
                    <div>
                        <label for="Status_Makanan" class="block text-gray-700 font-medium mb-1">Status Makanan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            <select
                                name="Status_Makanan"
                                id="Status_Makanan"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border {{ $errors->has('Status_Makanan') ? 'border-red-500' : 'border-gray-200' }} bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                                required
                            >
                                <option value="Tersedia" {{ old('Status_Makanan') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Segera Habis" {{ old('Status_Makanan') == 'Segera Habis' ? 'selected' : '' }}>Segera Habis</option>
                                <option value="Habis" {{ old('Status_Makanan') == 'Habis' ? 'selected' : '' }}>Habis</option>
                            </select>
                            @if($errors->has('Status_Makanan'))
                            <span class="text-red-600 text-sm mt-2 block">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $errors->first('Status_Makanan') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Tanggal Kedaluwarsa -->
                    <div>
                        <label for="Tanggal_Kedaluwarsa" class="block text-gray-700 font-medium mb-1">Tanggal Kedaluwarsa <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input
                                type="date"
                                name="Tanggal_Kedaluwarsa"
                                id="Tanggal_Kedaluwarsa"
                                value="{{ old('Tanggal_Kedaluwarsa') }}"
                                min="{{ date('Y-m-d') }}"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border {{ $errors->has('Tanggal_Kedaluwarsa') ? 'border-red-500' : 'border-gray-200' }} bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                                required
                            />
                            @if($errors->has('Tanggal_Kedaluwarsa'))
                            <span class="text-red-600 text-sm mt-2 block">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $errors->first('Tanggal_Kedaluwarsa') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="space-y-6">
                    <!-- Foto Makanan -->
                    <div>
                        <label for="Foto_Makanan" class="block text-gray-700 font-medium mb-1">Foto Makanan <span class="text-red-500">*</span></label>
                        <div class="mt-2">
                            <div class="flex items-center justify-center w-full">
                                <label for="Foto_Makanan" class="flex flex-col items-center justify-center w-full h-64 border-2 {{ $errors->has('Foto_Makanan') ? 'border-red-500' : 'border-gray-300' }} border-dashed rounded-xl cursor-pointer bg-white/60 hover:bg-gray-50 transition-all relative overflow-hidden group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 z-10">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3 group-hover:text-orange-500 transition-colors"></i>
                                        <p class="mb-2 text-sm text-gray-500 text-center">
                                            <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500">
 IU                                           JPG, PNG, atau GIF (Maks. 2MB)
                                        </p>
                                    </div>
                                    <div id="image-preview" class="absolute inset-0 hidden items-center justify-center">
                                        <img id="preview-image" class="h-full object-contain" alt="Preview">
                                    </div>
                                    <input id="Foto_Makanan" name="Foto_Makanan" type="file" class="hidden" accept="image/jpeg,image/png,image/gif" />
                                </label>
                            </div>
                        </div>
                        @if($errors->has('Foto_Makanan'))
                        <span class="text-red-600 text-sm mt-2 block font-medium">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $errors->first('Foto_Makanan') }}
                        </span>
                        @endif
                    </div>
                    
                    <!-- Lokasi Makanan -->
                    <div>
                        <label for="Lokasi_Makanan" class="block text-gray-700 font-medium mb-1">Lokasi Makanan</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <input
                                type="text"
                                name="Lokasi_Makanan"
                                id="Lokasi_Makanan"
                                placeholder="Masukkan alamat atau lokasi makanan"
                                value="{{ old('Lokasi_Makanan') }}"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border {{ $errors->has('Lokasi_Makanan') ? 'border-red-500' : 'border-gray-200' }} bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                            />
                            @if($errors->has('Lokasi_Makanan'))
                            <span class="text-red-600 text-sm mt-2 block">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $errors->first('Lokasi_Makanan') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Jumlah Makanan -->
            <div class="space-y-6">
                <div>
                    <label for="Jumlah_Makanan" class="block text-gray-700 font-medium mb-1">Jumlah Makanan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fas fa-boxes"></i>
                        </span>
                        <input
                            type="number"
                            name="Jumlah_Makanan"
                            id="Jumlah_Makanan"
                            placeholder="Masukkan jumlah (misal: 10)"
                            value="{{ old('Jumlah_Makanan') }}"
                            class="w-full pl-12 pr-4 py-3 rounded-xl border {{ $errors->has('Jumlah_Makanan') ? 'border-red-500' : 'border-gray-200' }} bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                            min="0"
                            required
                        />
                        @if($errors->has('Jumlah_Makanan'))
                        <span class="text-red-600 text-sm mt-2 block">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $errors->first('Jumlah_Makanan') }}
                        </span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Masukkan jumlah dalam porsi atau unit (contoh: 10).
                    </p>
                </div>
            </div>
            
            <!-- Deskripsi Makanan (Full Width) -->
            <div class="space-y-6">
                <div>
                    <label for="Deskripsi_Makanan" class="block text-gray-700 font-medium mb-1">Deskripsi Makanan</label>
                    <div class="relative">
                        <span class="absolute top-3 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fas fa-align-left"></i>
                        </span>
                        <textarea
                            name="Deskripsi_Makanan"
                            id="Deskripsi_Makanan"
                            rows="5"
                            placeholder="Jelaskan tentang makanan yang didonasikan..."
                            class="w-full pl-12 pr-4 py-3 rounded-xl border {{ $errors->has('Deskripsi_Makanan') ? 'border-red-500' : 'border-gray-200' }} bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                        >{{ old('Deskripsi_Makanan') }}</textarea>
                        @if($errors->has('Deskripsi_Makanan'))
                        <span class="text-red-600 text-sm mt-2 block">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $errors->first('Deskripsi_Makanan') }}
                        </span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Jelaskan detail tentang makanan, seperti jumlah, kondisi, bahan, cara penyimpanan, dsb.
                    </p>
                </div>
            </div>
            
            <div class="pt-6 border-t border-gray-200 mt-8">
                <div class="flex flex-col sm:flex-row justify-end gap-3">
                    <a href="{{ route('donatur.food-listing.index') }}" class="py-2.5 px-6 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition animate-scale text-center">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="py-2.5 px-6 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200">
                        <i class="fas fa-save mr-2"></i>Simpan Makanan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Image Preview Handling
    const fileInput = document.getElementById('Foto_Makanan');
    const imagePreview = document.getElementById('image-preview');
    const previewImage = document.getElementById('preview-image');

    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imagePreview.classList.remove('hidden');
                imagePreview.classList.add('flex');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.classList.add('hidden');
            imagePreview.classList.remove('flex');
            previewImage.src = '';
        }
    });

    // Form Submission Debugging
    const form = document.getElementById('food-form');
    form.addEventListener('submit', function(e) {
        console.log('Form submitting...');
        console.log('Foto_Makanan selected:', fileInput.files.length > 0 ? fileInput.files[0].name : 'No file selected');
    });

    // Reset image preview on form reset
    form.addEventListener('reset', function() {
        imagePreview.classList.add('hidden');
        imagePreview.classList.remove('flex');
        previewImage.src = '';
        fileInput.value = '';
    });
</script>
@endsection