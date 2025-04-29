@extends('layouts.appadmin')

@section('title', 'Total Artikel Terpublikasi')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Statistik Artikel Terpublikasi</h1>

    <div class="mb-6">
        <a href="{{ url('/admin/dashboard') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
            ← Kembali ke Dashboard
        </a>
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
@endsection

@section('scripts')
<script>
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
</script>
@endsection
