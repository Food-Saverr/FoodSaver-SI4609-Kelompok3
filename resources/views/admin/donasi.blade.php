@extends('layouts.app')

@section('title', 'Statistik Donasi')

@section('content')
<div class="container px-6 mx-auto grid">
    <div class="mb-6 mt-6">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-xl shadow hover:bg-orange-700 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
    </div>

    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Statistik Donasi
    </h2>

    <div class="grid gap-6 mb-8 md:grid-cols-1">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
            <h4 class="mb-4 font-semibold text-gray-800">
                Total Donasi Keseluruhan
            </h4>
            <p class="text-gray-700 text-4xl font-bold">
                {{ $totalDonasi }} Porsi
            </p>
        </div>
    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
            <h4 class="mb-4 font-semibold text-gray-800">
                Donasi Per Bulan
            </h4>
            <div class="relative">
                <canvas id="sparkline" height="60"></canvas>
                <div class="absolute bottom-0 left-0 right-0 h-px bg-gray-200"></div>
            </div>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-600">Donasi Tertinggi</p>
                    <p class="text-lg font-semibold text-green-600" id="maxDonasi">0 Porsi</p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-600">Rata-rata</p>
                    <p class="text-lg font-semibold text-blue-600" id="avgDonasi">0 Porsi</p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-600">Donasi Terendah</p>
                    <p class="text-lg font-semibold text-red-600" id="minDonasi">0 Porsi</p>
                </div>
            </div>
        </div>

        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs">
            <h4 class="mb-4 font-semibold text-gray-800">
                Top 5 Donatur
            </h4>
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                <th class="px-4 py-3">Nama Donatur</th>
                                <th class="px-4 py-3">Nama Makanan</th>
                                <th class="px-4 py-3">Total Donasi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            @foreach($topDonatur as $donatur)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ $donatur->Nama_Pengguna }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $donatur->Nama_Makanan }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $donatur->total_donasi }} Porsi
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const donasiData = @json($donasiPerBulan);

    const namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    const groupedData = donasiData.reduce((acc, curr) => {
        if (!acc[curr.bulan]) {
            acc[curr.bulan] = 0;
        }
        acc[curr.bulan] += curr.total_donasi;
        return acc;
    }, {});

    const labels = Object.keys(groupedData).map(bulan => namaBulan[bulan - 1]);
    const values = Object.values(groupedData);

    const maxDonasi = Math.max(...values);
    const minDonasi = Math.min(...values);
    const avgDonasi = values.reduce((a, b) => a + b, 0) / values.length;

    document.getElementById('maxDonasi').textContent = maxDonasi + ' Porsi';
    document.getElementById('minDonasi').textContent = minDonasi + ' Porsi';
    document.getElementById('avgDonasi').textContent = Math.round(avgDonasi) + ' Porsi';

    new Chart(document.getElementById('sparkline'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                borderColor: '#7e3af2',
                borderWidth: 2,
                fill: {
                    target: 'origin',
                    above: 'rgba(126, 58, 242, 0.1)',
                },
                pointRadius: 0,
                pointHitRadius: 10,
                tension: 0.4
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
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' Porsi';
                        }
                    }
                }
            },
            scales: {
                x: {
                    display: false
                },
                y: {
                    display: false,
                    beginAtZero: true
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
</script>
@endpush
@endsection 