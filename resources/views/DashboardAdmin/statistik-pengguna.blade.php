@extends('layouts.app')

@section('title', 'Statistik Pengguna - FoodSaver')

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
        Statistik Pengguna
      </h1>
      <p class="text-gray-600 mt-2 animate-fade-up-delay">
        Lihat perkembangan jumlah <span class="font-semibold text-orange-600">Donatur</span> dan <span class="font-semibold text-orange-600">Penerima</span> di platform <span class="font-semibold text-orange-600">FoodSaver</span>.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
      <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="flex items-center space-x-4 mb-4">
          <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
            <i class="fas fa-hand-holding-heart text-xl"></i>
          </div>
          <h3 class="text-xl font-semibold text-gray-800">Total Donatur</h3>
        </div>
        <p class="text-4xl font-bold text-blue-600 mb-2">{{ $jumlahDonatur }}</p>
        <p class="text-sm text-gray-500">Pengguna yang telah bergabung sebagai donatur makanan</p>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="flex items-center space-x-4 mb-4">
          <div class="bg-green-100 text-green-600 p-3 rounded-full">
            <i class="fas fa-users text-xl"></i>
          </div>
          <h3 class="text-xl font-semibold text-gray-800">Total Penerima</h3>
        </div>
        <p class="text-4xl font-bold text-green-600 mb-2">{{ $jumlahPenerima }}</p>
        <p class="text-sm text-gray-500">Pengguna yang terdaftar sebagai penerima donasi</p>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
      <div class="bg-white rounded-2xl shadow-md p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Pertumbuhan Donatur per Bulan</h4>
        <canvas id="donaturChart" height="300"></canvas>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Pertumbuhan Penerima per Bulan</h4>
        <canvas id="penerimaChart" height="300"></canvas>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
      <h4 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Pengguna</h4>
      <div class="flex justify-center">
        <div style="width: 250px; height: 250px;">
          <canvas id="distributionChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const donaturData = {!! json_encode($donaturPerBulan) !!};
    const penerimaData = {!! json_encode($penerimaPerBulan) !!};

    new Chart(document.getElementById('donaturChart'), {
        type: 'line',
        data: {
            labels: donaturData.map(item => namaBulan[item.bulan - 1]),
            datasets: [{
                label: 'Jumlah Donatur Baru',
                data: donaturData.map(item => item.total),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    new Chart(document.getElementById('penerimaChart'), {
        type: 'line',
        data: {
            labels: penerimaData.map(item => namaBulan[item.bulan - 1]),
            datasets: [{
                label: 'Jumlah Penerima Baru',
                data: penerimaData.map(item => item.total),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    new Chart(document.getElementById('distributionChart'), {
        type: 'doughnut',
        data: {
            labels: ['Donatur', 'Penerima'],
            datasets: [{
                data: [{{ $jumlahDonatur }}, {{ $jumlahPenerima }}],
                backgroundColor: ['#3b82f6', '#10b981'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20
                    }
                }
            },
            cutout: '60%'
        }
    });
</script>
@endpush
@endsection
