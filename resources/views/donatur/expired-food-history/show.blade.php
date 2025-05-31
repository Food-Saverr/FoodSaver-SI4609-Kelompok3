@extends('layouts.appdonatur')

@section('title', 'Detail Makanan Kedaluwarsa: ' . $expiredFood->Nama_Makanan)

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-4xl mx-auto">
        <!-- Navigasi -->
        <a href="{{ route('donatur.expired-food-history.index') }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-4">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Riwayat Kedaluwarsa
        </a>
        
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">
                    {{ $expiredFood->Nama_Makanan }}
                </h1>
                
                <!-- Status Badge -->
                <div class="mt-4 md:mt-0">
                    <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                        <i class="fas fa-exclamation-triangle mr-1"></i>Kedaluwarsa
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <!-- Gambar Makanan -->
                <div class="lg:col-span-2">
                    <div class="relative rounded-2xl overflow-hidden bg-gray-100 shadow-md h-80">
                        @if($expiredFood->Foto_Makanan)
                            <img src="{{ asset('storage/' . $expiredFood->Foto_Makanan) }}" 
                                 alt="{{ $expiredFood->Nama_Makanan }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                 onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=400'">
                        @else
                            <div class="flex items-center justify-center h-full bg-gray-200 text-gray-400">
                                <i class="fas fa-image text-5xl"></i>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Detail Makanan -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kategori -->
                        <div class="p-4 bg-blue-50 rounded-xl">
                            <h3 class="text-sm font-medium text-blue-500 mb-1">Kategori</h3>
                            <p class="font-medium text-gray-800">
                                @if($expiredFood->Kategori_Makanan)
                                    <span class="inline-flex items-center">
                                        <i class="fas fa-tag mr-2 text-blue-400"></i>
                                        {{ $expiredFood->Kategori_Makanan }}
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
                                @if($expiredFood->Jumlah_Makanan)
                                    <span class="inline-flex items-center">
                                        <i class="fas fa-boxes mr-2 text-indigo-400"></i>
                                        {{ $expiredFood->Jumlah_Makanan }} porsi
                                    </span>
                                @else
                                    <span class="text-gray-400">Tidak ditentukan</span>
                                @endif
                            </p>
                        </div>
                        
                        <!-- Tanggal Kedaluwarsa -->
                        <div class="p-4 bg-red-50 rounded-xl">
                            <h3 class="text-sm font-medium text-red-500 mb-2">Tanggal Kedaluwarsa</h3>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 mt-1">
                                    <i class="fas fa-calendar-alt text-red-400 text-base"></i>
                                </div>
                                <div>
                                    <p class="text-red-600 font-semibold text-base">{{ $expiredFood->Tanggal_Kedaluwarsa->format('d M Y') }}</p>
                                    <p class="text-red-500 text-sm italic">Kedaluwarsa pada {{ $expiredFood->expired_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Jumlah Didonasikan -->
                        <div class="p-4 bg-green-50 rounded-xl">
                            <h3 class="text-sm font-medium text-green-500 mb-1">Jumlah Didonasikan</h3>
                            <p class="font-medium text-gray-800">
                                <span class="inline-flex items-center">
                                    <i class="fas fa-hand-holding-heart mr-2 text-green-400"></i>
                                    {{ $expiredFood->Jumlah_Didonasi }} porsi
                                </span>
                            </p>
                            @php
                                $percentage = $expiredFood->Jumlah_Makanan > 0 
                                    ? round(($expiredFood->Jumlah_Didonasi / $expiredFood->Jumlah_Makanan) * 100, 1)
                                    : 0;
                            @endphp
                            <div class="mt-2">
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Persentase Donasi</span>
                                    <span>{{ $percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Deskripsi -->
                    <div class="p-6 bg-gray-50 rounded-xl">
                        <h3 class="text-lg font-bold mb-3">Deskripsi Makanan</h3>
                        <div class="prose max-w-none">
                            @if($expiredFood->Deskripsi_Makanan)
                                <p>{{ $expiredFood->Deskripsi_Makanan }}</p>
                            @else
                                <p class="text-gray-400 italic">Tidak ada deskripsi makanan</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Timeline Status -->
                    <div class="p-6 bg-gray-50 rounded-xl">
                        <h3 class="text-lg font-bold mb-4">Status Timeline</h3>
                        <div class="relative">
                            <!-- Garis Timeline -->
                            <div class="absolute h-full w-0.5 bg-gray-200 left-6 top-0"></div>
                            
                            <!-- Status Item -->
                            <div class="relative flex items-start mb-4 pl-16">
                                <div class="absolute left-0 rounded-full w-12 h-12 flex items-center justify-center bg-green-100 text-green-600">
                                    <i class="fas fa-plus-circle text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Ditambahkan</h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $expiredFood->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Status Item -->
                            <div class="relative flex items-start mb-4 pl-16">
                                <div class="absolute left-0 rounded-full w-12 h-12 flex items-center justify-center bg-red-100 text-red-600">
                                    <i class="fas fa-exclamation-triangle text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Kedaluwarsa</h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $expiredFood->expired_at->format('d M Y, H:i') }}
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
@endsection 