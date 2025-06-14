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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

            <a href="{{ route('DashboardAdmin.pengguna') }}" class="bg-white p-8 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="bg-blue-100 text-blue-600 p-4 rounded-full">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold">Statistik Pengguna</h3>
                </div>
                <div class="flex justify-between items-start">
                    <div class="space-y-3">
                        <p class="text-gray-700 text-lg">Donatur: <strong class="text-blue-600">{{ $jumlahDonatur }}</strong></p>
                        <p class="text-gray-700 text-lg">Penerima: <strong class="text-blue-600">{{ $jumlahPenerima }}</strong></p>
                    </div>
                    <div class="w-40 h-40">
                        <canvas id="penggunaChart"></canvas>
                    </div>
                </div>
            </a>

            <a href="{{ route('DashboardAdmin.makanan') }}" class="bg-white p-8 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="bg-green-100 text-green-600 p-4 rounded-full">
                        <i class="fas fa-box-open text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold">Statistik Makanan</h3>
                </div>
                <div class="flex justify-between items-start">
                    <div class="space-y-3">
                        <p class="text-gray-700 text-lg">Tersedia: <strong class="text-green-600">{{ $jumlahMakananTersedia }}</strong> item</p>
                        <p class="text-gray-700 text-lg">Didonasikan: <strong class="text-green-600">{{ $jumlahMakananDidonasikan }}</strong> item</p>
                    </div>
                    <div class="w-40 h-40">
                        <canvas id="makananChart"></canvas>
                    </div>
                </div>
            </a>

            <a href="{{ route('DashboardAdmin.donasi') }}" class="bg-white p-8 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="bg-purple-100 text-purple-600 p-4 rounded-full">
                        <i class="fas fa-donate text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold">Statistik Donasi</h3>
                </div>
                <div class="flex justify-between items-start">
                    <div class="space-y-3">
                        <p class="text-gray-700 text-lg">Total: <strong class="text-purple-600">{{ $totalDonasi }}</strong> Porsi</p>
                    </div>
                    <div class="w-40 h-40">
                        <canvas id="donasiChart"></canvas>
                    </div>
                </div>
            </a>

            <a href="{{ route('DashboardAdmin.artikel') }}" class="bg-white p-8 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="bg-blue-100 text-blue-600 p-4 rounded-full">
                        <i class="fas fa-newspaper text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold">Total Artikel Terpublikasi</h3>
                </div>
                <div class="flex justify-between items-start">
                    <div class="space-y-3">
                        <p class="text-gray-700 text-lg">Jumlah Artikel: <strong class="text-blue-600">{{ $totalArtikel }}</strong></p>
                        <p class="text-sm text-gray-500">Statistik 4 minggu terakhir</p>
                    </div>
                    <div class="w-40 h-40">
                        <canvas id="totalArtikelChart"></canvas>
                    </div>
                </div>
            </a>

            <a href="{{ route('DashboardAdmin.statistikForum') }}" class="bg-white p-8 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="bg-purple-100 text-purple-600 p-4 rounded-full">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8a9 9 0 110-18 9 9 0 010 18zm3-7h2a2 2 0 002-2V7a2 2 0 00-2-2h-5a2 2 0 00-2 2v2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold">Statistik Forum</h3>
                </div>
                <div class="flex justify-between items-start">
                    <div class="space-y-3">
                        <p class="text-gray-700 text-lg">Total Forum Dibuat: <strong class="text-purple-600">{{ $totalForum }}</strong></p>
                        <p class="text-gray-700 text-lg">Diskusi Aktif: <strong class="text-purple-600">{{ $diskusiAktif }}</strong></p>
                    </div>
                    <div class="w-40 h-40">
                        <canvas id="forumPieChart"></canvas>
                    </div>
                </div>
            </a>

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
                <a href="{{ route('admin.notifications.send-form') }}" class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all flex items-center animate-scale">
                    <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full mr-4">
                        <i class="fas fa-bell text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Kirim Notifikasi</h3>
                        <p class="text-sm text-gray-500">Broadcast info ke donatur & pengguna</p>
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
                
                <a href="{{ route('artikels.index') }}" class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow hover:shadow-lg transition-all flex items-center animate-scale">
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Total Artikel
    var ctxArtikel = document.getElementById('totalArtikelChart').getContext('2d');
    var artikelChart = new Chart(ctxArtikel, {
        type: 'line',
        data: {
            labels: {!! json_encode($artikelLabels) !!},
            datasets: [{
                label: 'Artikel per Minggu',
                data: {!! json_encode($artikelData) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 10,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    },
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 10
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 10
                        },
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
});
</script>
@endsection