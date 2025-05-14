@extends('layouts.app')

@section('title', 'Total Artikel Terpublikasi')

@section('content')
<section class="pt-28 md:pt-32 pb-16 bg-gradient-to-br from-orange-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-xl shadow hover:bg-orange-700 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('admin.artikel.create') }}" 
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-xl shadow hover:bg-green-700 transition duration-300">
                <i class="fas fa-plus mr-2"></i> Tambah Artikel Baru
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
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($artikelList as $artikel)
                            <tr>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="hover:underline text-orange-600">
                                        {{ \Str::limit($artikel->judul, 50) }}
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($artikel->created_at)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('admin.artikel.edit', $artikel->id) }}" 
                                        class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-medium rounded-lg hover:bg-blue-600 transition">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs font-medium rounded-lg hover:bg-red-600 transition">
                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $artikelList->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('artikelStatChart').getContext('2d');
    new Chart(ctx, {
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
                legend: { display: false },
                title: { display: true, text: 'Artikel Masuk per Minggu', font: { size: 14 } }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false }, ticks: { maxRotation: 45, minRotation: 45 } }
            }
        }
    });
});
</script>
@endpush
