@extends('layouts.app')

@section('title', 'Food Listing - FoodSaver')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
        <!-- Button Riwayat Permintaan -->
        <div class="flex justify-start mb-4">
            <button dusk="riwayat-permintaan" onclick="window.location.href='{{ route('pengguna.request.index') }}';" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-3 py-1 rounded-lg font-medium transition animate-scale shadow-md flex items-center text-sm">
                <i class="fas fa-history mr-2"></i>Riwayat Permintaan
            </button>
        </div>
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="flex items-center justify-center gap-4 flex-wrap">
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2 animate-fade-up">
                    Daftar Makanan Donasi
                </h1>
            </div>
            <p class="text-gray-500 max-w-2xl mx-auto animate-fade-up-delay">
                Temukan berbagai makanan untuk diambil oleh Penerima Makanan. Bantu kurangi pemborosan makanan bersama <span class="font-semibold text-orange-600">FoodSaver</span>.
            </p>
        </div>

        <!-- Search and Filters -->
        <div class="mb-8 flex flex-col md:flex-row gap-4">
            <!-- Search Bar -->
            <div class="flex-1">
                <form action="{{ route('pengguna.food-listing.index') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari makanan..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </form>
            </div>
            <!-- Filters -->
            <div class="flex gap-4">
                <select name="status" onchange="this.form.submit()" form="filter-form" class="rounded-xl border border-gray-200 bg-white/90 px-4 py-2 focus:outline-none focus:border-orange-400 input-focus-effect transition-all">
                    <option value="" {{ !request('status') ? 'selected' : '' }}>Semua Status</option>
                    <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Segera Habis" {{ request('status') == 'Segera Habis' ? 'selected' : '' }}>Segera Habis</option>
                    <option value="Habis" {{ request('status') == 'Habis' ? 'selected' : '' }}>Habis</option>
                </select>
                <select name="kategori" onchange="this.form.submit()" form="filter-form" class="rounded-xl border border-gray-200 bg-white/90 px-4 py-2 focus:outline-none focus:border-orange-400 input-focus-effect transition-all">
                    <option value="" {{ !request('kategori') ? 'selected' : '' }}>Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                    @endforeach
                </select>
                <form id="filter-form" action="{{ route('pengguna.food-listing.index') }}" method="GET" class="hidden">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                </form>
            </div>
        </div>

        <!-- Food Listing Grid -->
        @if($makanans->isEmpty())
            <div class="text-center py-12">
                <div class="flex flex-col items-center justify-center">
                    <i class="fas fa-cookie-bite text-5xl text-gray-300 mb-3"></i>
                    <p class="text-lg font-medium text-gray-600">Belum ada makanan tersedia</p>
                    <p class="text-sm text-gray-400">Cek kembali nanti untuk donasi baru!</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($makanans as $makanan)
                    @if($makanan && $makanan->ID_Makanan)
                        @php
                            $displayStatus = $makanan->Status_Makanan;
                            if ($makanan->Jumlah_Makanan == 0) {
                                $displayStatus = 'Habis';
                            } elseif ($makanan->Jumlah_Makanan < 5) {
                                $displayStatus = 'Segera Habis';
                            }
                            
                            try {
                                $expDate = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa);
                                $now = \Carbon\Carbon::now();
                                $isPast = $expDate->isPast();
                                $isToday = $expDate->isToday();
                                $totalHours = $now->diffInHours($expDate, false);
                                $daysLeft = floor($totalHours / 24);
                            } catch (\Exception $e) {
                                $expDate = null;
                                $isPast = true;
                            }
                            
                            // Determining card style based on status
                            $isExpired = isset($isPast) && $isPast;
                            $makananHabis = $displayStatus == 'Habis';
                            $cardBaseClass = "rounded-xl p-6 shadow-md hover:shadow-lg transition-all animate-fade-up-delay";
                            $cardImageOpacity = "";
                            
                            if ($makananHabis || $isExpired) {
                                $cardBaseClass .= " bg-red-50 border border-red-200";
                                $cardImageOpacity = "opacity-60";
                            } else {
                                $cardBaseClass .= " bg-white";
                            }
                        @endphp
                        
                        <div class="{{ $cardBaseClass }}">
                            <!-- Food Image -->
                            <div class="relative h-48 w-full rounded-xl overflow-hidden mb-4 bg-gray-100">
                                <img src="{{ $makanan->Foto_Makanan ? asset('storage/' . $makanan->Foto_Makanan) : asset("images/food-placeholder.jpg") }}" alt="{{ $makanan->Nama_Makanan }}" class="w-full h-full object-cover transition-transform hover:scale-105 {{ $cardImageOpacity }}">
                                
                                <!-- Status Badge -->
                                <div class="absolute top-3 right-3">
                                    @if($displayStatus == 'Tersedia')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium shadow-sm">
                                            <i class="fas fa-check-circle mr-1"></i>{{ $displayStatus }}
                                        </span>
                                    @elseif($displayStatus == 'Segera Habis')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium shadow-sm">
                                            <i class="fas fa-clock mr-1"></i>{{ $displayStatus }}
                                        </span>
                                    @elseif($displayStatus == 'Habis')
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium shadow-sm">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $displayStatus }}
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium shadow-sm">
                                            <i class="fas fa-info-circle mr-1"></i>{{ $displayStatus }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Overlay for unavailable items -->
                                @if($makananHabis || $isExpired)
                                    <div class="absolute inset-0 bg-black/10 backdrop-blur-[1px] flex items-center justify-center">
                                        <div class="bg-red-500 text-white px-4 py-2 rounded-full font-bold transform -rotate-12 shadow-xl">
                                            {{ $isExpired ? 'KEDALUWARSA' : 'HABIS' }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Food Details -->
                            <div class="w-full {{ $makananHabis || $isExpired ? 'bg-red-100' : 'bg-orange-50' }} rounded-lg px-4 py-3 mb-4 text-center">
                                <h3 class="text-base sm:text-lg font-semibold {{ $makananHabis || $isExpired ? 'text-red-700' : 'text-orange-700' }} leading-tight truncate">
                                    {{ $makanan->Nama_Makanan }}
                                </h3>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                                <!-- Kategori -->
                                <div class="flex flex-col {{ $makananHabis || $isExpired ? 'bg-red-50' : 'bg-blue-50' }} rounded-xl px-4 py-3">
                                    <span class="text-[11px] {{ $makananHabis || $isExpired ? 'text-red-600' : 'text-blue-600' }} font-semibold tracking-wide uppercase mb-1 flex items-center">
                                        <i class="fas fa-tag mr-1 text-xs"></i> Kategori
                                    </span>
                                    <span class="text-sm text-gray-800 font-medium leading-snug">
                                        {{ $makanan->Kategori_Makanan ?: 'Tidak dikategorikan' }}
                                    </span>
                                </div>

                                <!-- Jumlah Makanan -->
                                <div class="flex flex-col {{ $makananHabis || $isExpired ? 'bg-red-50' : 'bg-indigo-50' }} rounded-xl px-4 py-3">
                                    <span class="text-[11px] {{ $makananHabis || $isExpired ? 'text-red-600' : 'text-indigo-600' }} font-semibold tracking-wide uppercase mb-1 flex items-center">
                                        <i class="fas fa-box mr-1 text-xs"></i> Jumlah Tersedia
                                    </span>
                                    <span class="text-sm {{ $makananHabis ? 'text-red-800 font-bold' : 'text-gray-800 font-medium' }} leading-snug">
                                        {{ $makanan->Jumlah_Makanan }} Porsi
                                    </span>
                                </div>

                                <!-- Tanggal Kedaluwarsa -->
                                <div class="flex flex-col bg-red-50 rounded-xl px-4 py-3">
                                    <span class="text-[11px] text-red-600 font-semibold tracking-wide uppercase mb-1 flex items-center">
                                        <i class="fas fa-calendar-alt mr-1 text-xs"></i> Kedaluwarsa
                                    </span>
                                    <span class="text-sm {{ $isExpired ? 'text-red-800 font-bold' : 'text-gray-800 font-medium' }} leading-snug">
                                        @if(is_null($expDate))
                                            Tidak valid
                                        @elseif($isPast)
                                            Sudah kedaluwarsa
                                        @elseif($isToday && $totalHours <= 0)
                                            Kurang dari 1 jam
                                        @else
                                            {{ $daysLeft }} Hari lagi
                                        @endif
                                    </span>
                                </div>

                                <!-- Lokasi -->
                                <div class="flex flex-col {{ $makananHabis || $isExpired ? 'bg-red-50' : 'bg-green-50' }} rounded-xl px-4 py-3">
                                    <span class="text-[11px] {{ $makananHabis || $isExpired ? 'text-red-600' : 'text-green-600' }} font-semibold tracking-wide uppercase mb-1 flex items-center">
                                        <i class="fas fa-map-marker-alt mr-1 text-xs"></i> Lokasi
                                    </span>
                                    <span class="text-sm text-gray-800 font-medium leading-snug">
                                        {{ Str::limit($makanan->Lokasi_Makanan ?: 'Tidak ditentukan', 30) }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Action Button -->
                            <div class="mt-4">
                                <a href="{{ route('pengguna.food-listing.show', $makanan->ID_Makanan) }}" 
                                   class="inline-block w-full {{ $makananHabis || $isExpired ? 'bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700' : 'bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700' }} text-white py-2 rounded-xl font-semibold text-center transition animate-scale shadow-md">
                                    <i class="fas fa-eye mr-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="bg-red-50 p-4 rounded-xl">
                            <p class="text-red-600 text-sm">Data makanan tidak valid: ID = {{ $makanan->ID_Makanan ?? 'Missing' }}, Nama = {{ $makanan->Nama_Makanan ?? 'Missing' }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
            <!-- Pagination -->   
            <div class="mt-6">
                {{ $makanans->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection