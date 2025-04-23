@extends('layouts.appdonatur')

@section('title', 'Dashboard - FoodSaver')

@section('content')
<section class="pt-28 pb-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
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

        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold title-font gradient-text animate-fade-up">
                Selamat Datang, {{ Auth::user()->Nama_Pengguna }}
            </h1>
            <p class="text-gray-500 max-w-2xl mx-auto mt-3 animate-fade-up-delay">
                Bersama <span class="font-semibold text-orange-600">FoodSaver</span>, Anda membantu mengurangi limbah makanan dan mendukung komunitas. Lihat dampak Anda!
            </p>
        </div>

        <!-- Statistik Ringkas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all animate-fade-up">
                <div class="flex items-center space-x-4 mb-3">
                    <div class="bg-orange-100 text-orange-600 p-3 rounded-full">
                        <i class="fas fa-utensils text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Donasi</h3>
                </div>
                <p class="text-3xl font-bold text-orange-600">{{ $totalDonasi ?? 0 }}</p>
                <p class="text-sm text-gray-500 mt-1">Makanan yang telah Anda donasikan</p>
            </div>
            <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all animate-fade-up-delay">
                <div class="flex items-center space-x-4 mb-3">
                    <div class="bg-green-100 text-green-600 p-3 rounded-full">
                        <i class="fas fa-leaf text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Limbah Dicegah</h3>
                </div>
                <p class="text-3xl font-bold text-green-600">{{ number_format($limbahDicegah ?? 0, 2) }} Kg</p>
                <p class="text-sm text-gray-500 mt-1">Kontribusi Anda untuk lingkungan</p>
            </div>
            <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all animate-fade-up-delay">
                <div class="flex items-center space-x-4 mb-3">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Penerima Terbantu</h3>
                </div>
                <p class="text-3xl font-bold text-blue-600">{{ $penerimaTerbantu ?? 0 }}</p>
                <p class="text-sm text-gray-500 mt-1">Komunitas yang telah Anda dukung</p>
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Donasi Terbaru</h2>
                <a href="{{ route('donatur.food-listing.index') }}" class="text-orange-500 hover:text-orange-700 text-sm font-medium flex items-center transition-colors group">
                    Lihat Semua <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
            @if($recentMakanans->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-cookie-bite text-5xl text-gray-300 mb-3"></i>
                    <p class="text-lg font-medium text-gray-600">Belum ada donasi makanan</p>
                    <p class="text-sm text-gray-500">Mulai donasi sekarang untuk membuat perubahan!</p>
                    <a href="{{ route('donatur.food-listing.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200">
                        <i class="fas fa-plus mr-2"></i>Tambah Donasi
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recentMakanans as $makanan)
                        <div class="bg-white rounded-xl p-4 custom-shadow hover:shadow-lg transition-all">
                            <div class="relative h-40 w-full rounded-lg overflow-hidden mb-3 bg-gray-100">
                                <img src="{{ $makanan->Foto_Makanan ? asset('storage/' . $makanan->Foto_Makanan) : 'https://via.placeholder.com/400x320' }}" 
                                     alt="{{ $makanan->Nama_Makanan }}" 
                                     class="w-full h-full object-cover transition-transform hover:scale-105"
                                     onerror="this.src='https://via.placeholder.com/400x320'">
                                <span class="absolute top-2 right-2 px-3 py-1 bg-{{ $makanan->Status_Makanan == 'Tersedia' ? 'green' : ($makanan->Status_Makanan == 'Segera Habis' ? 'yellow' : 'red') }}-100 text-{{ $makanan->Status_Makanan == 'Tersedia' ? 'green' : ($makanan->Status_Makanan == 'Segera Habis' ? 'yellow' : 'red') }}-800 rounded-full text-xs font-medium">
                                    {{ $makanan->Status_Makanan }}
                                </span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 truncate">{{ $makanan->Nama_Makanan }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Jumlah: {{ $makanan->Jumlah_Makanan }} porsi</p>
                            <p class="text-sm text-gray-500 mt-1">Kedaluwarsa: 
                                @php
                                    try {
                                        $expDate = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa);
                                        echo $expDate->format('d M Y');
                                    } catch (\Exception $e) {
                                        echo 'Tidak Valid';
                                    }
                                @endphp
                            </p>
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('donatur.food-listing.show', $makanan->ID_Makanan) }}" 
                                   class="flex-1 bg-blue-100 text-blue-600 py-1.5 rounded-lg text-sm text-center hover:bg-blue-200 transition animate-scale">
                                    <i class="fas fa-eye mr-1"></i> Lihat
                                </a>
                                <a href="{{ route('donatur.food-listing.edit', $makanan->ID_Makanan) }}" 
                                   class="flex-1 bg-orange-100 text-orange-600 py-1.5 rounded-lg text-sm text-center hover:bg-orange-200 transition animate-scale">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Call to Action -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-2xl p-8 text-center custom-shadow animate-fade-up">
            <h2 class="text-2xl font-bold mb-3">Punya Makanan untuk Didonasikan?</h2>
            <p class="text-sm mb-4 max-w-xl mx-auto">Setiap porsi yang Anda donasikan membantu mengurangi limbah makanan dan mendukung mereka yang membutuhkan. Ayo buat perubahan sekarang!</p>
            <a href="{{ route('donatur.food-listing.create') }}" 
               class="bg-white text-orange-600 px-6 py-3 rounded-xl font-semibold hover:bg-orange-100 transition animate-scale inline-flex items-center gap-2 shadow-lg">
                <i class="fas fa-donate"></i> Donasi Sekarang
            </a>
        </div>
    </div>
</section>
@endsection