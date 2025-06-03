@extends('layouts.appadmin')

@section('title', 'Statistik Artikel')

@section('content')
<section class="pt-28 md:pt-32 pb-16 bg-gradient-to-br from-orange-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="mb-6">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-xl shadow hover:bg-orange-700 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold title-font gradient-text animate-fade-up">
                Statistik Artikel
            </h1>
            <p class="text-gray-600 mt-2 animate-fade-up-delay">
                Pantau perkembangan artikel di platform <span class="font-semibold text-orange-600">FoodSaver</span>
            </p>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Artikel -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                        <i class="fas fa-newspaper text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Total Artikel</h3>
                </div>
                <p class="text-4xl font-bold text-blue-600 mb-2">{{ $totalArtikel }}</p>
                <p class="text-sm text-gray-500">Total artikel yang dipublikasikan</p>
            </div>

            <!-- Artikel Minggu Ini -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-green-100 text-green-600 p-3 rounded-full">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Artikel Minggu Ini</h3>
                </div>
                <p class="text-4xl font-bold text-green-600 mb-2">{{ $artikelMingguIni }}</p>
                <p class="text-sm text-gray-500">Artikel yang dipublikasikan minggu ini</p>
            </div>

            <!-- Artikel Terbaru -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Artikel Terbaru</h3>
                </div>
                <p class="text-4xl font-bold text-purple-600 mb-2">{{ $artikelList->count() }}</p>
                <p class="text-sm text-gray-500">Artikel terbaru yang ditampilkan</p>
            </div>
        </div>

        <!-- Grafik Statistik -->
        <div class="mb-8">
            <!-- Grafik Artikel per Minggu -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Artikel per Minggu</h2>
                <div class="w-full h-64">
                    @if(count($data) > 0)
                        <canvas id="artikelStatChart"></canvas>
                    @else
                        <div class="h-full flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <i class="fas fa-chart-bar text-4xl mb-2"></i>
                                <p>Belum ada data artikel untuk ditampilkan</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Daftar Artikel Terbaru -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-700">Artikel Terbaru</h2>
                <a href="{{ route('admin.artikel.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-plus mr-2"></i> Tambah Artikel
                </a>
            </div>
            <div class="overflow-x-auto">
                @if(count($artikelList) > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Judul</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Penulis</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                                <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($artikelList as $artikel)
                                <tr>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('artikels.show', $artikel->slug) }}" 
                                           class="text-blue-600 hover:underline">
                                            {{ Str::limit($artikel->judul, 50) }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2">{{ optional($artikel->user)->Nama_Pengguna ?? 'Admin' }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($artikel->created_at)->translatedFormat('d M Y') }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('admin.artikel.edit', $artikel->id) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-medium rounded-lg hover:bg-blue-600 transition">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-500 mb-4">
                            <i class="fas fa-newspaper text-4xl"></i>
                        </div>
                        <p class="text-gray-600">Belum ada artikel yang dipublikasikan</p>
                        <a href="{{ route('admin.artikel.create') }}" 
                           class="inline-flex items-center px-4 py-2 mt-4 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-plus mr-2"></i> Buat Artikel Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Artikel per Minggu
    @if(count($data) > 0)
    var ctxArtikel = document.getElementById('artikelStatChart').getContext('2d');
    var artikelStatChart = new Chart(ctxArtikel, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Jumlah Artikel',
                data: {!! json_encode($data) !!},
                backgroundColor: 'rgba(63, 81, 181, 0.2)',
                borderColor: '#3f51b5',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
    @endif
});
</script>
@endpush
