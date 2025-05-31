@extends('layouts.app')

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

        <!-- Hero Section: About FoodSaver -->
        <div class="relative bg-white/80 backdrop-blur-xl rounded-2xl p-10 mb-16 custom-shadow animate-fade-up overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-100/30 to-orange-200/30 opacity-50 pointer-events-none"></div>
            <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-orange-500 to-orange-600"></div>
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex items-center space-x-6">
                    <div class="relative group">
                        <img src="{{ Auth::user()->Foto_Profil ? asset('storage/' . Auth::user()->Foto_Profil) : asset('images/user-placeholder.jpg') }}" 
                             alt="{{ Auth::user()->Nama_Pengguna }}" 
                             class="w-20 h-20 rounded-full border-4 border-orange-200 object-cover transition-transform group-hover:scale-110"
                             onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=80'">
                        <a href="{{ route('profile.show') }}" 
                           class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-cog text-white text-lg"></i>
                        </a>
                    </div>
                    <div>
                        <h1 class="text-4xl font-extrabold title-font gradient-text">
                            Selamat Datang, {{ Auth::user()->Nama_Pengguna }}!
                        </h1>
                        <p class="text-gray-600 mt-2 max-w-lg leading-relaxed">
                            Anda adalah bagian dari gerakan <span class="font-semibold text-orange-600">FoodSaver</span> untuk mengurangi limbah makanan, mendukung komunitas, dan menciptakan dunia yang lebih berkelanjutan.
                        </p>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('pengguna.forum.index') }}" 
                       class="bg-blue-100 text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-200 transition animate-scale inline-flex items-center gap-2 shadow-md">
                        <i class="fas fa-comments"></i> Forum Komunitas
                    </a>
                    <a href="{{ route ('artikel.pengguna') }}" 
                       class="bg-purple-100 text-purple-600 px-6 py-3 rounded-xl font-semibold hover:bg-purple-200 transition animate-scale inline-flex items-center gap-2 shadow-md">
                        <i class="fas fa-newspaper"></i> Artikel & Tips
                    </a>
                </div>
            </div>
            <div class="mt-8 bg-orange-50/70 rounded-xl p-8">
                <h2 class="text-2xl font-extrabold text-gray-800 mb-4">Mengenal FoodSaver</h2>
                <p class="text-gray-600 text-base leading-relaxed mb-4">
                    FoodSaver adalah platform inovatif yang menghubungkan donatur makanan dengan mereka yang membutuhkan, mengurangi limbah makanan, dan memupuk solidaritas komunitas. Didirikan dengan visi untuk mengatasi krisis limbah makanan global, kami telah menyelamatkan ribuan kilogram makanan dan membantu ratusan keluarga.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-leaf text-2xl text-green-600 mt-1"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Misi Kami</h3>
                            <p class="text-sm text-gray-500">Mengurangi limbah makanan hingga 50% di komunitas kami pada tahun 2030.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-users text-2xl text-blue-600 mt-1"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Komunitas</h3>
                            <p class="text-sm text-gray-500">Menghubungkan lebih dari 1.000 donatur dan penerima di seluruh wilayah.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-globe text-2xl text-orange-600 mt-1"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Dampak Global</h3>
                            <p class="text-sm text-gray-500">Mengurangi emisi karbon dengan menyelamatkan makanan dari TPA.</p>
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
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Perubahan yang Kami Ciptakan</h3>
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <div class="bg-orange-100 text-orange-600 p-3 rounded-full">
                                <i class="fas fa-utensils text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-orange-600">{{ number_format($totalMakananDiselamatkan ?? 2500) }} Porsi</p>
                                <p class="text-sm text-gray-500">Makanan diselamatkan dari limbah</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-green-100 text-green-600 p-3 rounded-full">
                                <i class="fas fa-leaf text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-green-600">{{ number_format($limbahDicegah ?? 1250, 2) }} Kg</p>
                                <p class="text-sm text-gray-500">Limbah makanan dicegah</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-blue-600">{{ $komunitasTerbantu ?? 500 }}</p>
                                <p class="text-sm text-gray-500">Individu dan keluarga terbantu</p>
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
                <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">Bagaimana FoodSaver Bekerja</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="bg-orange-100 text-orange-600 p-4 rounded-full mx-auto w-16 h-16 flex items-center justify-center mb-4">
                            <i class="fas fa-upload text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800">Donasi Makanan</h4>
                        <p class="text-sm text-gray-500">Donatur mengunggah makanan berlebih ke platform.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-green-100 text-green-600 p-4 rounded-full mx-auto w-16 h-16 flex items-center justify-center mb-4">
                            <i class="fas fa-handshake text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800">Permintaan</h4>
                        <p class="text-sm text-gray-500">Penerima mengajukan permintaan untuk makanan.</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-blue-100 text-blue-600 p-4 rounded-full mx-auto w-16 h-16 flex items-center justify-center mb-4">
                            <i class="fas fa-truck text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800">Distribusi</h4>
                        <p class="text-sm text-gray-500">Makanan diambil atau dikirim ke penerima.</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Available Food Listings -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-10 custom-shadow mb-16">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-800">Makanan Tersedia</h2>
                <div class="flex space-x-4 mt-4 sm:mt-0">
                    <select class="border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-600 focus:ring-orange-500 focus:border-orange-500">
                        <option value="expiry">Urutkan: Kedaluwarsa Terdekat</option>
                        <option value="newest">Terbaru</option>
                        <option value="quantity">Jumlah Terbanyak</option>
                    </select>
                    <a href="{{ route('pengguna.food-listing.index') }}" 
                       class="text-orange-500 hover:text-orange-700 text-sm font-medium flex items-center transition-colors group">
                        Lihat Semua <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>
            @if(empty($availableMakanans) || $availableMakanans->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-cookie-bite text-6xl text-gray-300 mb-4"></i>
                    <p class="text-xl font-semibold text-gray-600">Belum Ada Makanan Tersedia</p>
                    <p class="text-sm text-gray-500 mt-2 max-w-md mx-auto">Jelajahi artikel kami untuk tips mengurangi limbah makanan atau bergabung di forum komunitas!</p>
                    <div class="flex justify-center space-x-4 mt-6">
                        <a href="{{ route ('artikel.pengguna') }}" 
                           class="bg-purple-100 text-purple-600 px-6 py-3 rounded-xl font-semibold hover:bg-purple-200 transition animate-scale inline-flex items-center gap-2">
                            <i class="fas fa-newspaper"></i> Lihat Artikel
                        </a>
                        <a href="{{ route('pengguna.forum.index') }}" 
                           class="bg-blue-100 text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-200 transition animate-scale inline-flex items-center gap-2">
                            <i class="fas fa-comments"></i> Forum
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($availableMakanans as $makanan)
                        <div class="bg-white rounded-2xl p-6 custom-shadow hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 animate-fade-up">
                            <div class="relative h-52 w-full rounded-xl overflow-hidden mb-4 bg-gray-100">
                                <img src="{{ $makanan->Foto_Makanan ? asset('storage/' . $makanan->Foto_Makanan) : asset('images/food-placeholder.jpg') }}" 
                                     alt="{{ $makanan->Nama_Makanan }}" 
                                     class="w-full h-full object-cover transition-transform hover:scale-110"
                                     onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=200'">
                                <span class="absolute top-3 right-3 px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium shadow-sm">
                                    Tersedia
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $makanan->Nama_Makanan }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Jumlah: {{ $makanan->Jumlah_Makanan }} porsi</p>
                            <p class="text-sm text-gray-500 mt-1">Donatur: {{ $makanan->donatur->Nama_Pengguna ?? 'Anonim' }}</p>
                            <div class="text-sm text-gray-500 mt-1 flex items-center">
                                <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                Kedaluwarsa: 
                                @php
                                    try {
                                        $expDate = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa);
                                        $now = \Carbon\Carbon::now();
                                        $daysLeft = $now->diffInDays($expDate, false);
                                        $progress = $daysLeft <= 0 ? 0 : min(($daysLeft / 7) * 100, 100);
                                        echo $expDate->format('d M Y');
                                    } catch (\Exception $e) {
                                        $daysLeft = 0;
                                        $progress = 0;
                                        echo 'Tidak Valid';
                                    }
                                @endphp
                            </div>
                            <div class="mt-4 flex gap-3">
                                <a href="{{ route('pengguna.food-listing.show', $makanan->ID_Makanan) }}" 
                                   class="flex-1 bg-blue-100 text-blue-600 py-2 rounded-lg text-sm text-center hover:bg-blue-200 transition animate-scale">
                                    <i class="fas fa-eye mr-1"></i> Lihat
                                </a>
                                <a href="" 
                                   class="flex-1 bg-orange-100 text-orange-600 py-2 rounded-lg text-sm text-center hover:bg-orange-200 transition animate-scale">
                                    <i class="fas fa-hand-holding-heart mr-1"></i> Minta
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Call to Action: Monetary Donation -->
        <div class="relative bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-2xl p-10 custom-shadow animate-fade-up overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-orange-400 opacity-20 rounded-full transform translate-x-20 -translate-y-20"></div>
            <div class="absolute bottom-0 left-0 w-full h-24 bg-orange-700/30 clip-wave"></div>
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex items-center space-x-6 max-w-lg">
                    <div class="bg-white/20 p-5 rounded-full">
                        <i class="fas fa-hand-holding-usd text-4xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-extrabold mb-3">Dukung Masa Depan FoodSaver</h2>
                        <p class="text-sm leading-relaxed">
                            Donasi Anda memungkinkan kami untuk terus mengembangkan platform, menjangkau lebih banyak komunitas, dan memperkuat misi melawan limbah makanan.
                        </p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('pengguna.donation.create') }}" 
                       class="bg-green-100 text-green-600 px-8 py-3 rounded-xl font-semibold hover:bg-green-200 transition animate-scale inline-flex items-center gap-2 shadow-lg animate-pulse-slow">
                        <i class="fas fa-hand-holding-usd"></i> Donasi untuk Developer
                    </a>
                    <a href="{{ route('pengguna.donation.index') }}"
                      class="border border-white-100 text-white px-5 py-3 rounded-xl font-semibold hover:bg-white hover:text-green-600 transition animate-scale inline-flex items-center justify-center gap-2 w-52 text-center">
                        <i class="fas fa-list"></i> Lihat Donasi Untuk Developer
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