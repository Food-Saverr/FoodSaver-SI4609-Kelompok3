@extends('layouts.appdonatur')

@section('title', 'Dashboard - FoodSaver')

@section('content')
<section class="pt-28 pb-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl">
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

        <!-- Header Section -->
        <div class="relative bg-white/80 backdrop-blur-xl rounded-2xl p-10 mb-16 custom-shadow animate-fade-up overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-100/30 to-orange-200/30 opacity-50"></div>
            <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-orange-500 to-orange-600"></div>
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex items-center space-x-6">
                    <div class="relative group">
                        <img src="{{ Auth::user()->Foto_Profil ? asset('storage/' . Auth::user()->Foto_Profil) : asset('images/user-placeholder.jpg') }}" 
                             alt="{{ Auth::user()->Nama_Pengguna }}" 
                             class="w-20 h-20 rounded-full border-4 border-orange-200 object-cover transition-transform group-hover:scale-110"
                             onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=80'">
                        <a href="" 
                           class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-cog text-white text-lg"></i>
                        </a>
                    </div>
                    <div>
                        <h1 class="text-4xl font-extrabold title-font gradient-text">
                            Selamat Datang, {{ Auth::user()->Nama_Pengguna }}!
                        </h1>
                        <p class="text-gray-600 mt-2 max-w-lg leading-relaxed">
                            Kontribusi Anda di <span class="font-semibold text-orange-600">FoodSaver</span> membantu mengurangi limbah makanan dan mendukung komunitas yang membutuhkan.
                        </p>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('donatur.food-listing.create') }}" 
                       class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-3 rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200 animate-pulse-slow">
                        <i class="fas fa-plus mr-2"></i> Tambah Donasi
                    </a>
                </div>
            </div>
            <div class="mt-8 bg-orange-50/70 rounded-xl p-8">
                <h2 class="text-2xl font-extrabold text-gray-800 mb-4">Tentang FoodSaver</h2>
                <p class="text-gray-600 text-base leading-relaxed mb-4">
                    FoodSaver adalah platform yang berdedikasi untuk mengurangi limbah makanan dengan menghubungkan donatur seperti Anda dengan mereka yang membutuhkan. Kami berupaya menciptakan dunia yang lebih berkelanjutan, satu donasi pada satu waktu.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-leaf text-2xl text-green-600 mt-1"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Misi Kami</h3>
                            <p class="text-sm text-gray-500">Menyelamatkan 50% limbah makanan di komunitas kami pada 2030.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-users text-2xl text-blue-600 mt-1"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Komunitas</h3>
                            <p class="text-sm text-gray-500">Menghubungkan ribuan donatur dan penerima.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-globe text-2xl text-orange-600 mt-1"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Dampak Global</h3>
                            <p class="text-sm text-gray-500">Mengurangi emisi karbon melalui donasi makanan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FoodSaver Impact Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-extrabold text-gray-800 text-center mb-8 animate-fade-up">Dampak FoodSaver</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Impact Stats -->
                <div class="bg-white/90 backdrop-blur-xl rounded-2xl p-8 custom-shadow animate-fade-up-delay">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Kontribusi Kami Bersama</h3>
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <div class="bg-orange-100 text-orange-600 p-3 rounded-full">
                                <i class="fas fa-utensils text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-orange-600">{{ number_format($totalMakananDiselamatkan ?? 2500) }} Porsi</p>
                                <p class="text-sm text-gray-500">Makanan diselamatkan</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-green-100 text-green-600 p-3 rounded-full">
                                <i class="fas fa-leaf text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-green-600">{{ number_format($limbahDicegahPlatform ?? 1250, 2) }} Kg</p>
                                <p class="text-sm text-gray-500">Limbah dicegah</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-blue-600">{{ $komunitasTerbantu ?? 500 }}</p>
                                <p class="text-sm text-gray-500">Penerima terbantu</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Testimonial Section -->
                <div class="bg-white/90 backdrop-blur-xl rounded-2xl p-8 custom-shadow animate-fade-up-delay max-w-xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Cerita Komunitas</h3>
                    
                    <div class="relative text-center">
                        <div class="inline-block text-5xl text-gray-300 mb-4">
                            &ldquo;
                        </div>
                        <p class="text-gray-700 text-base md:text-lg leading-relaxed italic mb-6">
                            FoodSaver membantu restoran kami mendonasikan makanan berlebih dengan mudah, dan melihat dampaknya pada komunitas sungguh luar biasa!
                        </p>

                        <div class="flex items-center justify-center gap-4">
                            <img src="https://i.pravatar.cc/150?u=a042581f4e29026704d" alt="Ani" class="w-12 h-12 rounded-full object-cover shadow-sm">
                            <div class="text-left">
                                <p class="text-sm font-semibold text-gray-800">Ani</p>
                                <p class="text-xs text-gray-500">Pemilik Restoran</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- How It Works -->
            <div class="mt-12 bg-orange-50/70 rounded-2xl p-8 animate-fade-up">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">Bagaimana Anda Membantu</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="bg-orange-100 text-orange-600 p-4 rounded-full mx-auto w-16 h-16 flex items-center justify-center mb-4">
                            <i class="fas fa-upload text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800">Unggah Donasi</h4>
                        <p class="text-sm text-gray-500">Tambahkan makanan berlebih Anda ke platform.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-green-100 text-green-600 p-4 rounded-full mx-auto w-16 h-16 flex items-center justify-center mb-4">
                            <i class="fas fa-handshake text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800">Hubungkan</h4>
                        <p class="text-sm text-gray-500">Penerima mengajukan permintaan donasi Anda.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-blue-100 text-blue-600 p-4 rounded-full mx-auto w-16 h-16 flex items-center justify-center mb-4">
                            <i class="fas fa-truck text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800">Distribusi</h4>
                        <p class="text-sm text-gray-500">Makanan sampai ke mereka yang membutuhkan.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistic Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            <div class="bg-white/90 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-xl hover:scale-105 hover:bg-orange-50/50 hover:border-orange-200 border border-transparent transition-all duration-300 ease-in-out animate-fade-up">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-orange-100 text-orange-600 p-3 rounded-full">
                        <i class="fas fa-utensils text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Donasi Anda</h3>
                </div>
                <p class="text-4xl font-bold text-orange-600 animate-count-up" data-target="{{ $totalDonasi ?? 0 }}">{{ $totalDonasi ?? 0 }}</p>
                <p class="text-sm text-gray-500 mt-2">Makanan yang telah Anda donasikan</p>
                <div class="mt-4 h-1 bg-orange-100 rounded-full overflow-hidden">
                    <div class="h-full bg-orange-400 w-3/4"></div>
                </div>
            </div>
            <div class="bg-white/90 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-xl hover:scale-105 hover:bg-green-50/50 hover:border-green-200 border border-transparent transition-all duration-300 ease-in-out animate-fade-up-delay">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-green-100 text-green-600 p-3 rounded-full">
                        <i class="fas fa-leaf text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Limbah Dicegah</h3>
                </div>
                <p class="text-4xl font-bold text-green-600 animate-count-up" data-target="{{ $limbahDicegah ?? 0 }}">{{ number_format($limbahDicegah ?? 0, 2) }} Kg</p>
                <p class="text-sm text-gray-500 mt-2">Kontribusi Anda untuk lingkungan</p>
                <div class="mt-4 h-1 bg-green-100 rounded-full overflow-hidden">
                    <div class="h-full bg-green-400 w-1/2"></div>
                </div>
            </div>
            <div class="bg-white/90 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-xl hover:scale-105 hover:bg-blue-50/50 hover:border-blue-200 border border-transparent transition-all duration-300 ease-in-out animate-fade-up-delay">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Penerima Terbantu</h3>
                </div>
                <p class="text-4xl font-bold text-blue-600 animate-count-up" data-target="{{ $penerimaTerbantu ?? 0 }}">{{ $penerimaTerbantu ?? 0 }}</p>
                <p class="text-sm text-gray-500 mt-2">Komunitas yang telah Anda dukung</p>
                <div class="mt-4 h-1 bg-blue-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-400 w-2/3"></div>
                </div>
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-10 custom-shadow mb-16">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-800">Donasi Terbaru Anda</h2>
                <div class="flex space-x-4 mt-4 sm:mt-0">
                    <a href="{{ route('donatur.food-listing.index') }}" 
                    class="text-orange-500 hover:text-orange-700 text-sm font-medium flex items-center transition-colors group">
                        Lihat Semua <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>
            @if($recentMakanans->isEmpty())
                <div class="text-center py-12">
                    <img src="{{ asset('images/food-empty.png') }}" alt="No Donations" class="w-32 h-32 mx-auto mb-4 opacity-80">
                    <p class="text-xl font-semibold text-gray-600">Belum Ada Donasi</p>
                    <p class="text-sm text-gray-400 mt-2 max-w-md mx-auto">Mulai donasi sekarang atau bergabung di forum untuk berbagi pengalaman!</p>
                    <div class="flex justify-center space-x-4 mt-6">
                        <a href="{{ route('donatur.food-listing.create') }}" 
                        class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200">
                            <i class="fas fa-plus mr-2"></i> Tambah Donasi
                        </a>
                        <a href="{{ route('donatur.forum') }}" 
                        class="bg-blue-100 text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-200 transition animate-scale inline-flex items-center gap-2">
                            <i class="fas fa-comments"></i> Forum
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recentMakanans as $makanan)
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
                                    $progress = $daysLeft <= 0 ? 0 : min(($daysLeft / 7) * 100, 100);
                                } catch (\Exception $e) {
                                    $expDate = null;
                                    $isPast = true;
                                    $daysLeft = 0;
                                    $progress = 0;
                                }
                                
                                $isExpired = isset($isPast) && $isPast;
                                $makananHabis = $displayStatus == 'Habis';
                                $cardBaseClass = "rounded-2xl p-6 custom-shadow hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 animate-fade-up";
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
                                <div class="relative h-52 w-full rounded-xl overflow-hidden mb-4 bg-gray-100">
                                    <img src="{{ $makanan->Foto_Makanan ? asset('storage/' . $makanan->Foto_Makanan) : asset('images/food-placeholder.jpg') }}" 
                                        alt="{{ $makanan->Nama_Makanan }}" 
                                        class="w-full h-full object-cover transition-transform hover:scale-110 {{ $cardImageOpacity }}"
                                        onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=200'">
                                    
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
                                    <h3 class="text-lg font-semibold {{ $makananHabis || $isExpired ? 'text-red-700' : 'text-orange-700' }} leading-tight truncate">
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

                                    <!-- Penerima (if applicable) -->
                                    @if($makanan->penerima)
                                    <div class="flex flex-col {{ $makananHabis || $isExpired ? 'bg-red-50' : 'bg-purple-50' }} rounded-xl px-4 py-3 col-span-2">
                                        <span class="text-[11px] {{ $makananHabis || $isExpired ? 'text-red-600' : 'text-purple-600' }} font-semibold tracking-wide uppercase mb-1 flex items-center">
                                            <i class="fas fa-user mr-1 text-xs"></i> Penerima
                                        </span>
                                        <span class="text-sm text-gray-800 font-medium leading-snug">
                                            {{ $makanan->penerima->Nama_Pengguna ?? 'Menunggu' }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="mt-4 flex gap-3">
                                    <a href="{{ route('donatur.food-listing.show', $makanan->ID_Makanan) }}" 
                                    class="flex-1 {{ $makananHabis || $isExpired ? 'bg-gray-100 text-gray-600 hover:bg-gray-200' : 'bg-blue-100 text-blue-600 hover:bg-blue-200' }} py-2 rounded-lg text-sm text-center transition animate-scale">
                                        <i class="fas fa-eye mr-1"></i> Lihat
                                    </a>
                                    <a href="{{ route('donatur.food-listing.edit', $makanan->ID_Makanan) }}" 
                                    class="flex-1 {{ $makananHabis || $isExpired ? 'bg-gray-100 text-gray-600 hover:bg-gray-200' : 'bg-orange-100 text-orange-600 hover:bg-orange-200' }} py-2 rounded-lg text-sm text-center transition animate-scale">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="bg-red-50 p-4 rounded-2xl">
                                <p class="text-red-600 text-sm">Data makanan tidak valid: ID = {{ $makanan->ID_Makanan ?? 'Missing' }}, Nama = {{ $makanan->Nama_Makanan ?? 'Missing' }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Call to Action -->
        <div class="relative bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-2xl p-10 custom-shadow animate-fade-up overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-orange-400 opacity-20 rounded-full transform translate-x-20 -translate-y-20"></div>
            <div class="absolute bottom-0 left-0 w-full h-24 bg-orange-700/30 clip-wave"></div>

            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <!-- Bagian Kiri -->
                <div class="flex items-center space-x-6 max-w-lg">
                    <div class="bg-white/20 p-5 rounded-full">
                        <i class="fas fa-donate text-4xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-extrabold mb-3">Bersama Cegah Pemborosan Makanan</h2>
                        <p class="text-sm leading-relaxed">
                            Donasikan makanan berlebih dari restoran, katering, atau rumah Anda dan bantu komunitas yang membutuhkan sambil mengurangi limbah pangan.
                            Atau, dukung pengembangan platform FoodSaver lewat donasi dana.
                        </p>
                    </div>
                </div>

                <!-- Bagian Kanan: 4 Tombol -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full sm:w-auto justify-items-center sm:justify-items-end">
                    <!-- Donasi Makanan -->
                    <a href="{{ route('donatur.food-listing.create') }}"
                    class="bg-white text-orange-600 px-5 py-3 rounded-xl font-semibold hover:bg-orange-100 transition animate-scale inline-flex items-center justify-center gap-2 shadow-lg w-52 text-center">
                        <i class="fas fa-donate"></i> Donasi Makanan
                    </a>

                    <!-- Donasi Developer -->
                    <a href="#"
                    class="bg-green-100 text-green-600 px-5 py-3 rounded-xl font-semibold hover:bg-green-200 transition animate-scale inline-flex items-center justify-center gap-2 shadow-lg w-52 text-center animate-pulse-slow">
                        <i class="fas fa-hand-holding-usd"></i> Donasi Developer
                    </a>

                    <!-- Lihat Donasi Makanan -->
                    <a href="{{ route('donatur.food-listing.index') }}"
                    class="border border-white text-white px-5 py-3 rounded-xl font-semibold hover:bg-white hover:text-orange-600 transition animate-scale inline-flex items-center justify-center gap-2 w-52 text-center">
                        <i class="fas fa-list"></i> Daftar Makanan
                    </a>

                    <!-- Lihat Donasi Developer -->
                    <a href="#"
                    class="border border-white text-white px-5 py-3 rounded-xl font-semibold hover:bg-white hover:text-green-600 transition animate-scale inline-flex items-center justify-center gap-2 w-52 text-center">
                        <i class="fas fa-list"></i> Lihat Developer
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.clip-wave {
    clip-path: polygon(0 60%, 100% 20%, 100% 100%, 0% 100%);
}
.animate-pulse-slow {
    animation: pulse-slow 3s ease-in-out infinite;
}
@keyframes pulse-slow {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}
.animate-count-up {
    animation: count-up 2s ease-out forwards;
}
@keyframes count-up {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

@endsection