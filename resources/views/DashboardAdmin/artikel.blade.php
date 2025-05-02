@extends('layouts.app')

@section('title', 'Total Artikel Terpublikasi')

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
                Statistik Artikel Terpublikasi
            </h1>
            <p class="text-gray-600 mt-2 animate-fade-up-delay">
                Pantau perkembangan artikel di platform <span class="font-semibold text-orange-600">FoodSaver</span>.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Artikel Terpublikasi</h2>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalArtikel }}</p>
                </div>
            </div>
            <div class="w-full h-64">
                <canvas id="artikelStatChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Daftar Artikel Terpublikasi</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Judul</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Tanggal Publikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($artikelList as $artikel)
                            <tr>
                                <td class="px-4 py-2">{{ $artikel->judul }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($artikel->created_at)->translatedFormat('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctxArtikel = document.getElementById('artikelStatChart').getContext('2d');
    var artikelStatChart = new Chart(ctxArtikel, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Jumlah Artikel per Minggu',
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
                },
                title: {
                    display: true,
                    text: 'Artikel Masuk per Minggu',
                    font: {
                        size: 14
                    }
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
});
</script>
@endpush
