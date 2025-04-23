@extends('layouts.appdonatur')

@section('title', 'Detail Makanan: ' . $makanan->Nama_Makanan)

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-4xl mx-auto">
        <!-- Navigasi -->
        <a href="{{ route('donatur.food-listing.index') }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-4">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Daftar Makanan
        </a>
        
        <!-- Flash Messages -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg animate-fade-up-delay">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif
        
        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-up-delay">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif
        
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">
                    {{ $makanan->Nama_Makanan }}
                </h1>
                
                <div class="flex space-x-2 mt-4 md:mt-0">
                    <a href="{{ route('donatur.food-listing.edit', $makanan->ID_Makanan) }}" 
                       class="py-2 px-4 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-medium transition animate-scale shadow">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <form action="{{ route('donatur.food-listing.destroy', $makanan->ID_Makanan) }}" 
                          method="POST" 
                          class="inline-block" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus makanan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition animate-scale shadow">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <!-- Gambar Makanan -->
                <div class="lg:col-span-2">
                    <div class="relative rounded-2xl overflow-hidden bg-gray-100 shadow-md h-80">
                        @if($makanan->Foto_Makanan)
                            <img src="{{ asset('storage/' . $makanan->Foto_Makanan) }}" 
                                 alt="{{ $makanan->Nama_Makanan }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="flex items-center justify-center h-full bg-gray-200 text-gray-400">
                                <i class="fas fa-image text-5xl"></i>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-4 right-4">
                            @php
                                $displayStatus = $makanan->Jumlah_Makanan == 0 ? 'Habis' : ($makanan->Jumlah_Makanan < 5 ? 'Segera Habis' : 'Tersedia');
                            @endphp
                            <span class="px-4 py-2 rounded-full text-sm font-medium
                                         {{ $displayStatus == 'Tersedia' ? 'bg-green-100 text-green-800' : 
                                            ($displayStatus == 'Segera Habis' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                <i class="fas {{ $displayStatus == 'Tersedia' ? 'fa-check-circle' : 
                                                 ($displayStatus == 'Segera Habis' ? 'fa-clock' : 'fa-times-circle') }} mr-1"></i>
                                {{ $displayStatus }}
                            </span>
                        </div>
                    </div> 
                    <!-- Lihat Request Button -->
                    <div class="mt-4">
                        <button onclick="document.getElementById('requestModal').classList.remove('hidden')"
                                class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-2.5 px-6 rounded-xl font-semibold transition animate-scale shadow-lg shadow-blue-200">
                            <i class="fas fa-list mr-2"></i>Lihat Request Makanan
                        </button>
                    </div>
                </div>
                
                <!-- Detail Makanan -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kategori -->
                        <div class="p-4 bg-blue-50 rounded-xl">
                            <h3 class="text-sm font-medium text-blue-500 mb-1">Kategori</h3>
                            <p class="font-medium text-gray-800">
                                @if($makanan->Kategori_Makanan)
                                    <span class="inline-flex items-center">
                                        <i class="fas fa-tag mr-2 text-blue-400"></i>
                                        {{ $makanan->Kategori_Makanan }}
                                    </span>
                                @else
                                    <span class="text-gray-400">Tidak ada kategori</span>
                                @endif
                            </p>
                        </div>
                        
                        <!-- Jumlah Makanan -->
                        <div class="p-4 bg-indigo-50 rounded-xl">
                            <h3 class="text-sm font-medium text-indigo-500 mb-1">Jumlah Makanan</h3>
                            <p class="font-medium text-gray-800">
                                @if($makanan->Jumlah_Makanan)
                                    <span class="inline-flex items-center">
                                        <i class="fas fa-boxes mr-2 text-indigo-400"></i>
                                        {{ $makanan->Jumlah_Makanan }} porsi
                                    </span>
                                @else
                                    <span class="text-gray-400">Tidak ditentukan</span>
                                @endif
                            </p>
                        </div>
                        
                        <!-- Kedaluwarsa -->
                        <div class="p-4 bg-red-50 rounded-xl">
                            <h3 class="text-sm font-medium text-red-500 mb-2">Tanggal Kedaluwarsa</h3>
                            @php
                                try {
                                    $expDate = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa);
                                    $now = \Carbon\Carbon::now();
                                    $isPast = $expDate->isPast();
                                    $isToday = $expDate->isToday();
                                    $totalHours = $now->diffInHours($expDate, false);
                                    $daysLeft = floor($totalHours / 24);
                                    $hoursLeft = $totalHours % 24;
                                } catch (\Exception $e) {
                                    $expDate = null;
                                    $daysLeft = null;
                                    $hoursLeft = null;
                                    $isPast = true;
                                    $isToday = false;
                                }
                            @endphp
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    @if(is_null($expDate))
                                        <i class="fas fa-exclamation-triangle text-red-500 text-base"></i>
                                    @elseif($isPast)
                                        <i class="fas fa-exclamation-triangle text-red-500 text-base"></i>
                                    @elseif($isToday && $totalHours <= 0)
                                        <i class="fas fa-exclamation-circle text-yellow-500 text-base"></i>
                                    @else
                                        <i class="fas fa-calendar-alt text-red-400 text-base"></i>
                                    @endif
                                </div>
                                <div>
                                    @if(is_null($expDate))
                                        <p class="text-red-600 font-semibold text-base">Tanggal Tidak Valid</p>
                                    @elseif($isPast)
                                        <p class="text-red-600 font-semibold text-base">{{ $expDate->format('d M Y') }}</p>
                                        <p class="text-red-500 text-sm italic">Kedaluwarsa</p>
                                    @elseif($isToday && $totalHours <= 0)
                                        <p class="text-yellow-600 font-semibold text-base">{{ $expDate->format('d M Y') }}</p>
                                        <p class="text-yellow-500 text-sm italic">Kurang dari 1 jam</p>
                                    @else
                                        <p class="{{ $daysLeft <= 3 ? 'text-yellow-600' : 'text-gray-600' }} font-semibold text-base">{{ $expDate->format('d M Y') }}</p>
                                        <p class="{{ $daysLeft <= 3 ? 'text-yellow-500' : 'text-gray-500' }} text-sm italic">
                                            {{ $daysLeft }} hari, {{ $hoursLeft }} jam lagi
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Lokasi -->
                        <div class="p-4 bg-green-50 rounded-xl">
                            <h3 class="text-sm font-medium text-green-500 mb-1">Lokasi</h3>
                            <p class="font-medium text-gray-800">
                                @if($makanan->Lokasi_Makanan)
                                    <span class="inline-flex items-center">
                                        <i class="fas fa-map-marker-alt mr-2 text-green-400"></i>
                                        {{ $makanan->Lokasi_Makanan }}
                                    </span>
                                @else
                                    <span class="text-gray-400">Lokasi tidak ditentukan</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <!-- Deskripsi -->
                    <div class="p-6 bg-gray-50 rounded-xl">
                        <h3 class="text-lg font-bold mb-3">Deskripsi Makanan</h3>
                        <div class="prose max-w-none">
                            @if($makanan->Deskripsi_Makanan)
                                <p>{{ $makanan->Deskripsi_Makanan }}</p>
                            @else
                                <p class="text-gray-400 italic">Tidak ada deskripsi makanan</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Timeline Status -->
                    <div class="p-6 bg-gray-50 rounded-xl">
                        <h3 class="text-lg font-bold mb-4">Status Timeline</h3>
                        <div class="relative">
                            <div class="absolute h-full w-0.5 bg-gray-200 left-6 top-0"></div>
                            <div class="relative flex items-start mb-4 pl-16">
                                <div class="absolute left-0 rounded-full w-12 h-12 flex items-center justify-center {{ $makanan->created_at ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                                    <i class="fas fa-plus-circle text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Ditambahkan</h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $makanan->created_at ? $makanan->created_at->format('d M Y, H:i') : 'Tidak tercatat' }}
                                    </p>
                                </div>
                            </div>
                            <div class="relative flex items-start mb-4 pl-16">
                                <div class="absolute left-0 rounded-full w-12 h-12 flex items-center justify-center {{ $makanan->updated_at && $makanan->updated_at->gt($makanan->created_at) ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-400' }}">
                                    <i class="fas fa-edit text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Terakhir Diperbarui</h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $makanan->updated_at && $makanan->updated_at->gt($makanan->created_at) ? $makanan->updated_at->format('d M Y, H:i') : 'Belum diperbarui' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Request History -->
<div id="requestModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-2xl max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold gradient-text">Riwayat Permintaan Makanan</h2>
            <button onclick="document.getElementById('requestModal').classList.add('hidden')"
                    class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        @if($makanan->requests->isEmpty())
            <div class="text-center py-8">
                <i class="fas fa-info-circle text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">Belum ada permintaan untuk makanan ini.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($makanan->requests as $requestModel)
                    <div class="p-4 bg-gray-50 rounded-xl flex items-start justify-between">
                        <div>
                            <p class="font-medium text-gray-800">
                                <i class="fas fa-user mr-2 text-gray-500"></i>
                                {{ $requestModel->pengguna->Nama_Pengguna ?? 'Pengguna #' . $requestModel->ID_Pengguna }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                <i class="fas fa-comment mr-2 text-gray-400"></i>
                                {{ $requestModel->Pesan ?: 'Tidak ada pesan.' }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-clock mr-2 text-gray-400"></i>
                                {{ $requestModel->created_at->format('d M Y, H:i') }}
                            </p>
                            <p class="text-sm mt-1">
                                <i class="fas fa-info-circle mr-2 text-gray-400"></i>
                                Status: 
                                <span class="{{ $requestModel->Status_Request == 'Approved' ? 'text-green-600' : ($requestModel->Status_Request == 'Rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                    {{ $requestModel->Status_Request }}
                                </span>
                            </p>
                        </div>
                        @if($requestModel->Status_Request == 'Pending')
                            <div class="flex space-x-2">
                                <form action="{{ route('donatur.food-listing.approve-request', [$makanan->ID_Makanan, $requestModel->ID_Request]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                        <i class="fas fa-check mr-1"></i>Terima
                                    </button>
                                </form>
                                <form action="{{ route('donatur.food-listing.reject-request', [$makanan->ID_Makanan, $requestModel->ID_Request]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                        <i class="fas fa-times mr-1"></i>Tolak
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@section('scripts')
    <script>
        // Close modal when clicking outside
        document.getElementById('requestModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
@endsection