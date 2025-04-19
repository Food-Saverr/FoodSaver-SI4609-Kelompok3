@extends('layouts.app')

@section('title', 'Detail Makanan - ' . $makanan->Nama_Makanan)

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <a href="{{ route('pengguna.food-listing.index') }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-6">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Daftar Makanan
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Main Content - Takes 9/12 of the space -->
            <div class="lg:col-span-9">
                <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow">
                    <h1 class="text-3xl font-extrabold title-font gradient-text mb-6">{{ $makanan->Nama_Makanan }}</h1>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <!-- Food Image & Quick Info - 5 columns on md screens -->
                        <div class="md:col-span-5">
                            <!-- Food Image -->
                            <div class="relative rounded-2xl overflow-hidden bg-gray-100 shadow-md h-72 mb-5">
                                <img src="{{ $makanan->Foto_Makanan ? asset('storage/' . $makanan->Foto_Makanan) : asset('images/food-placeholder.jpg') }}" alt="{{ $makanan->Nama_Makanan }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4">
                                    @php
                                        $displayStatus = $makanan->Status_Makanan;
                                        if ($makanan->Jumlah_Makanan == 0) {
                                            $displayStatus = 'Habis';
                                        } elseif ($makanan->Jumlah_Makanan < 5) {
                                            $displayStatus = 'Segera Habis';
                                        }
                                    @endphp
                                    @if($displayStatus == 'Tersedia')
                                        <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium shadow-md">
                                            <i class="fas fa-check-circle mr-1"></i>{{ $displayStatus }}
                                        </span>
                                    @elseif($displayStatus == 'Segera Habis')
                                        <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium shadow-md">
                                            <i class="fas fa-clock mr-1"></i>{{ $displayStatus }}
                                        </span>
                                    @elseif($displayStatus == 'Habis')
                                        <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-medium shadow-md">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $displayStatus }}
                                        </span>
                                    @else
                                        <span class="px-4 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-medium shadow-md">
                                            <i class="fas fa-info-circle mr-1"></i>{{ $displayStatus }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Quick Info Cards Grid -->
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div class="p-4 bg-blue-50 rounded-xl shadow-sm text-center">
                                    <div class="text-blue-500 mb-2">
                                        <i class="fas fa-boxes text-xl"></i>
                                    </div>
                                    <p class="text-xs text-blue-800 font-semibold mb-1">JUMLAH</p>
                                    <p class="text-base font-bold text-gray-800">{{ $makanan->Jumlah_Makanan }} porsi</p>
                                </div>
                                <div class="p-4 bg-purple-50 rounded-xl shadow-sm text-center">
                                    <div class="text-purple-500 mb-2">
                                        <i class="fas fa-clock text-xl"></i>
                                    </div>
                                    <p class="text-xs text-purple-800 font-semibold mb-1">DITAMBAHKAN</p>
                                    <p class="text-base font-bold text-gray-800">{{ $makanan->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <!-- Donatur -->
                            <div class="p-5 bg-orange-50 rounded-xl shadow-sm">
                                <h3 class="text-lg font-semibold text-orange-800 mb-4">
                                    <i class="fas fa-user-circle mr-2"></i>Informasi Donatur
                                </h3>
                                <div class="flex items-center">
                                    <img src="{{ optional($makanan->donatur)->Foto_Profil ? asset('storage/' . optional($makanan->donatur)->Foto_Profil) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(optional($makanan->donatur)->Email_Pengguna ?? 'default@example.com'))) . '?d=mp&s=48' }}" class="w-16 h-16 rounded-full border-2 border-orange-200" alt="{{ optional($makanan->donatur)->Nama_Pengguna ?? 'Donatur' }}" onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=48'">
                                    <div class="ml-4">
                                        <p class="font-medium text-gray-800 text-lg">{{ optional($makanan->donatur)->Nama_Pengguna ?: 'Pengguna #' . $makanan->ID_Pengguna }}</p>
                                        <p class="text-gray-500">{{ optional($makanan->donatur)->Role_Pengguna ?: 'Donatur' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Food Details - 7 columns on md screens -->
                        <div class="md:col-span-7 h-full flex flex-col">
                            <!-- Detail Cards Grid -->
                            <div class="grid grid-cols-1 gap-5 h-full flex-grow">
                                <!-- Kategori -->
                                <div class="p-5 bg-blue-50 rounded-xl shadow-sm">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center p-3 bg-blue-100 rounded-lg mr-4 w-12 h-12">
                                            <i class="fas fa-tag text-blue-500 text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-blue-500 mb-1">Kategori Makanan</h3>
                                            <p class="font-semibold text-gray-800 text-lg">{{ $makanan->Kategori_Makanan ?: 'Tidak ada kategori' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Kedaluwarsa -->
                                <div class="p-5 bg-red-50 rounded-xl shadow-sm">
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
                                            $isPast = true;
                                        }
                                    @endphp
                                    
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center p-3 bg-red-100 rounded-lg mr-4 w-12 h-12">
                                            @if(is_null($expDate))
                                                <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                                            @elseif($isPast)
                                                <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                                            @elseif($isToday && $totalHours <= 0)
                                                <i class="fas fa-exclamation-circle text-yellow-500 text-lg"></i>
                                            @else
                                                <i class="fas fa-calendar-alt text-red-500 text-lg"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-red-500 mb-1">Tanggal Kedaluwarsa</h3>
                                            <div>
                                                @if(is_null($expDate))
                                                    <p class="text-red-600 font-semibold text-lg">Tanggal Tidak Valid</p>
                                                @elseif($isPast)
                                                    <p class="text-red-600 font-semibold text-lg">{{ $expDate->format('d M Y') }}</p>
                                                    <p class="text-red-500 text-sm italic">Kedaluwarsa</p>
                                                @elseif($isToday && $totalHours <= 0)
                                                    <p class="text-yellow-600 font-semibold text-lg">{{ $expDate->format('d M Y') }}</p>
                                                    <p class="text-yellow-500 text-sm italic">Kurang dari 1 jam</p>
                                                @else
                                                    <p class="{{ $daysLeft <= 3 ? 'text-yellow-600' : 'text-gray-800' }} font-semibold text-lg">{{ $expDate->format('d M Y') }}</p>
                                                    <p class="{{ $daysLeft <= 3 ? 'text-yellow-500' : 'text-gray-500' }} text-sm italic">
                                                        {{ $daysLeft }} hari, {{ $hoursLeft }} jam lagi
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Lokasi (Full Width) -->
                                <div class="p-5 bg-green-50 rounded-xl shadow-sm">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center p-3 bg-green-100 rounded-lg mr-4 w-12 h-12">
                                            <i class="fas fa-map-marker-alt text-green-500 text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-green-500 mb-1">Lokasi Pengambilan</h3>
                                            <p class="font-semibold text-gray-800 text-lg">{{ $makanan->Lokasi_Makanan ?: 'Tidak ditentukan' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Deskripsi -->
                                <div class="p-5 bg-gray-50 rounded-xl shadow-sm h-full flex flex-col">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-info-circle mr-3 text-gray-500"></i>Deskripsi Makanan
                                    </h3>
                                    <p class="text-gray-700 leading-relaxed flex-grow">{{ $makanan->Deskripsi_Makanan ?: 'Tidak ada deskripsi.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Request Card - Takes 3/12 of the space -->
            <div class="lg:col-span-3">
                <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow sticky top-28">
                    <div class="text-center mb-6">
                        <div class="inline-block p-3 bg-orange-100 rounded-full mb-3">
                            <i class="fas fa-hand-holding-heart text-orange-500 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold gradient-text">Ambil Makanan Ini</h3>
                    </div>
                    
                    @php
                        $makananHabis = $makanan->Jumlah_Makanan <= 0 || $makanan->Status_Makanan === 'Habis';
                        $isExpired = isset($isPast) && $isPast;
                    @endphp

                    @if($makananHabis || $isExpired)
                        <!-- Tampilan ketika makanan habis atau kedaluwarsa -->
                        <div class="text-center bg-red-50 rounded-xl p-6 shadow-sm mb-6">
                            <div class="mb-4 text-red-500">
                                <i class="fas fa-exclamation-circle text-3xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Makanan Tidak Tersedia</h4>
                            <p class="text-gray-600 mb-4">
                                @if($makananHabis)
                                    Makanan ini sudah habis dan tidak dapat di-request.
                                @elseif($isExpired)
                                    Makanan ini sudah kedaluwarsa dan tidak dapat di-request.
                                @endif
                            </p>
                            <a href="{{ route('pengguna.food-listing.index') }}" class="inline-block bg-gradient-to-r from-gray-500 to-gray-600 text-white py-2.5 px-6 rounded-xl font-semibold hover:from-gray-600 hover:to-gray-700 transition animate-scale">
                                Lihat Makanan Lain
                            </a>
                        </div>
                    @elseif(auth()->check() && auth()->user()->Role_Pengguna === 'Pengguna')
                        <!-- Form untuk request makanan -->
                        <form action="#" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="pesan" class="block text-gray-700 font-medium mb-2">Pesan (Opsional)</label>
                                <textarea name="pesan" id="pesan" rows="4" placeholder="Tambahkan pesan untuk donatur..." class="w-full rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all p-3 text-gray-700"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3 rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200">
                                <i class="fas fa-paper-plane mr-2"></i>Request Makanan
                            </button>
                        </form>
                        
                        <!-- Visual Enhancement Elements -->
                        <div class="mt-6 pt-5 border-t border-gray-100">
                            <div class="bg-yellow-50 rounded-xl p-4 shadow-sm">
                                <div class="flex items-start">
                                    <div class="p-2 bg-yellow-100 rounded-lg mr-3 flex-shrink-0">
                                        <i class="fas fa-lightbulb text-yellow-500"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-800 mb-1">Info Penting</h4>
                                        <p class="text-xs text-gray-600">Pastikan untuk mengambil makanan sebelum tanggal kedaluwarsa. Setelah request disetujui, silakan hubungi donatur untuk detailnya.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Tampilan untuk pengguna yang tidak login atau bukan tipe Pengguna -->
                        <div class="text-center bg-gray-50 rounded-xl p-6 shadow-sm mb-6">
                            <div class="mb-4 text-orange-500">
                                <i class="fas fa-info-circle text-3xl"></i>
                            </div>
                            <p class="text-gray-600 mb-4">Hanya Penerima Makanan yang dapat mengambil makanan ini.</p>
                            @guest
                                <a href="{{ route('login.form') }}" class="inline-block bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2.5 px-6 rounded-xl font-semibold hover:from-orange-600 hover:to-orange-700 transition animate-scale">
                                    Login sebagai Penerima
                                </a>
                            @else
                                <p class="text-sm text-gray-500 mt-3">Anda login sebagai {{ auth()->user()->Role_Pengguna }}.</p>
                            @endguest
                        </div>
                        
                        <!-- FAQ for not eligible users -->
                        <div class="mt-5">
                            <h4 class="text-sm font-semibold text-gray-800 mb-3">Pertanyaan Umum</h4>
                            <div class="space-y-3">
                                <div class="bg-white rounded-lg p-4 shadow-sm">
                                    <p class="text-xs font-medium text-gray-700 mb-1">Bagaimana cara menjadi penerima?</p>
                                    <p class="text-xs text-gray-500">Daftar sebagai penerima di halaman registrasi dan lengkapi profil Anda.</p>
                                </div>
                                <div class="bg-white rounded-lg p-4 shadow-sm">
                                    <p class="text-xs font-medium text-gray-700 mb-1">Apakah makanan ini aman?</p>
                                    <p class="text-xs text-gray-500">Semua makanan diverifikasi dan memiliki informasi kedaluwarsa yang jelas.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection