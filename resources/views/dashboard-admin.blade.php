<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.appadmin')

@section('title', 'Dashboard Admin - FoodSaver')

@section('content')
<section class="pt-20 pb-16 bg-gradient-to-br from-orange-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold title-font gradient-text animate-fade-up">
                Dashboard Admin
            </h1>
            <p class="text-gray-600 mt-2 animate-fade-up-delay">
                Pantau perkembangan pengguna dan aktivitas donasi makanan di platform <span class="font-semibold text-orange-600">FoodSaver</span>.
            </p>
        </div>
        
        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 animate-fade-up-delay">
            <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all">
                <div class="flex items-center space-x-4 mb-3">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pengguna</p>
                        <h3 class="text-2xl font-bold">{{ $jumlahDonatur + $jumlahPenerima }}</h3>
                    </div>
                </div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Donatur: <strong class="text-gray-700">{{ $jumlahDonatur }}</strong></span>
                    <span>Penerima: <strong class="text-gray-700">{{ $jumlahPenerima }}</strong></span>
                </div>
            </div>
            
            <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all">
                <div class="flex items-center space-x-4 mb-3">
                    <div class="bg-green-100 text-green-600 p-3 rounded-full">
                        <i class="fas fa-utensils text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Makanan Tersedia</p>
                        <h3 class="text-2xl font-bold">{{ $jumlahMakananTersedia }}</h3>
                    </div>
                </div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Minggu ini: <strong class="text-gray-700">+12</strong></span>
                    <span><a href="{{ route('admin.food-listing.index') }}" class="text-orange-500 hover:underline">Lihat semua</a></span>
                </div>
            </div>
            
            <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all">
                <div class="flex items-center space-x-4 mb-3">
                    <div class="bg-orange-100 text-orange-600 p-3 rounded-full">
                        <i class="fas fa-handshake text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Donasi Selesai</p>
                        <h3 class="text-2xl font-bold">{{ $jumlahMakananDidonasikan }}</h3>
                    </div>
                </div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Hari ini: <strong class="text-gray-700">+3</strong></span>
                    <span>Minggu ini: <strong class="text-gray-700">+21</strong></span>
                </div>
            </div>
            
            <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all">
                <div class="flex items-center space-x-4 mb-3">
                    <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                        <i class="fas fa-comments text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Diskusi Forum</p>
                        <h3 class="text-2xl font-bold">24</h3>
                    </div>
                </div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Minggu ini: <strong class="text-gray-700">+5</strong></span>
                    <span><a href="#" class="text-orange-500 hover:underline">Lihat semua</a></span>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 title-font">Tindakan Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.food-listing.index') }}" class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all flex items-center animate-scale">
                    <div class="bg-orange-100 text-orange-600 p-3 rounded-full mr-4">
                        <i class="fas fa-plus text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Pantau Makanan</h3>
                        <p class="text-sm text-gray-500">Monitoring donasi makanan baru</p>
                    </div>
                </a>
                
                <a href="#" class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all flex items-center animate-scale">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full mr-4">
                        <i class="fas fa-user-plus text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Tambah Pengguna</h3>
                        <p class="text-sm text-gray-500">Daftarkan pengguna baru</p>
                    </div>
                </a>
                
                <a href="#" class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all flex items-center animate-scale">
                    <div class="bg-green-100 text-green-600 p-3 rounded-full mr-4">
                        <i class="fas fa-newspaper text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Tambah Artikel</h3>
                        <p class="text-sm text-gray-500">Buat artikel edukasi baru</p>
                    </div>
                </a>

                <a href="{{ route('admin.donation.index') }}" class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all flex items-center animate-scale">
                    <div class="bg-orange-100 text-orange-600 p-3 rounded-full mr-4">
                        <i class="fas fa-donate"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Donasi Keuangan</h3>
                        <p class="text-sm text-gray-500">Monitoring donasi keuangan untuk FoodSaver</p>
                    </div>
                </a>
                
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div>
            <h2 class="text-2xl font-bold mb-6 title-font">Aktivitas Terbaru</h2>
            <div class="bg-white/70 backdrop-blur-xl rounded-2xl custom-shadow overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="bg-orange-100 text-orange-600 p-2 rounded-full mr-4">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Donasi Baru: Sayur Segar</h4>
                            <p class="text-sm text-gray-500">Donatur: Ahmad | 15 menit yang lalu</p>
                        </div>
                        <a href="#" class="ml-auto text-sm text-orange-500 hover:underline">Detail</a>
                    </div>
                </div>
                
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="bg-green-100 text-green-600 p-2 rounded-full mr-4">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Donasi Terambil: Makanan Pokok</h4>
                            <p class="text-sm text-gray-500">Penerima: Budi | 1 jam yang lalu</p>
                        </div>
                        <a href="#" class="ml-auto text-sm text-orange-500 hover:underline">Detail</a>
                    </div>
                </div>
                
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="bg-blue-100 text-blue-600 p-2 rounded-full mr-4">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Pengguna Baru: Citra</h4>
                            <p class="text-sm text-gray-500">Role: Donatur | 3 jam yang lalu</p>
                        </div>
                        <a href="#" class="ml-auto text-sm text-orange-500 hover:underline">Detail</a>
                    </div>
                </div>
                
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="bg-purple-100 text-purple-600 p-2 rounded-full mr-4">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Forum Baru: Tips Menyimpan Makanan</h4>
                            <p class="text-sm text-gray-500">Oleh: Dina | 5 jam yang lalu</p>
                        </div>
                        <a href="#" class="ml-auto text-sm text-orange-500 hover:underline">Detail</a>
                    </div>
                </div>
                
                <div class="p-4 text-center">
                    <a href="#" class="text-sm text-orange-500 hover:underline">Lihat semua aktivitas</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection