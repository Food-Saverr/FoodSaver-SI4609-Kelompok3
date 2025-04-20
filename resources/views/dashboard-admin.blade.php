@extends('layouts.app')

@section('title', 'Dashboard Admin - FoodSaver')

@section('content')
<section class="pt-28 md:pt-32 pb-16 bg-gradient-to-br from-orange-50 to-gray-100 min-h-screen">
  <div class="container mx-auto px-4">
    <div class="text-center mb-10">
      <h1 class="text-4xl font-extrabold title-font gradient-text animate-fade-up">
        Dashboard Admin
      </h1>
      <p class="text-gray-600 mt-2 animate-fade-up-delay">
        Pantau perkembangan pengguna di platform <span class="font-semibold text-orange-600">FoodSaver</span>.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 animate-fade-up animate-scale">
      <a href="{{ route('admin.pengguna') }}" class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
            <i class="fas fa-users text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Statistik Pengguna</h3>
        </div>
        <p>Donatur: <strong>{{ $jumlahDonatur }}</strong></p>
        <p>Penerima: <strong>{{ $jumlahPenerima }}</strong></p>
        <canvas id="penggunaChart" height="200"></canvas>
      </a>
      <a href="{{ route('admin.makanan') }}" class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-green-100 text-green-600 p-3 rounded-full">
            <i class="fas fa-utensils text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Statistik Makanan</h3>
        </div>
        <div class="space-y-2">
          <p>Tersedia: <strong>{{ $jumlahMakananTersedia }}</strong> item</p>
          <p>Didonasikan: <strong>{{ $jumlahMakananDidonasikan }}</strong> item</p>
        </div>
        <canvas id="makananChart" height="200"></canvas>
      </a>
      <a href="{{ route('admin.donasi') }}" class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
            <i class="fas fa-donate text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Statistik Donasi</h3>
        </div>
        <p class="text-xl font-bold text-purple-700">Total: {{ $totalDonasi }} Porsi</p>
        <canvas id="donasiChart" height="200"></canvas>
      </a>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  var ctxPengguna = document.getElementById('penggunaChart').getContext('2d');
  var penggunaChart = new Chart(ctxPengguna, {
    type: 'pie',
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
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }
  });

  var ctxMakanan = document.getElementById('makananChart').getContext('2d');
  var makananChart = new Chart(ctxMakanan, {
    type: 'bar',
    data: {
      labels: ['Tersedia', 'Didonasikan'],
      datasets: [{
        data: [{{ $jumlahMakananTersedia }}, {{ $jumlahMakananDidonasikan }}],
        backgroundColor: ['#22c55e', '#eab308'],
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
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
        }
      }
    }
  });
  var ctxDonasi = document.getElementById('donasiChart').getContext('2d');
  var donasiChart = new Chart(ctxDonasi, {
    type: 'line',
    data: {
      labels: ['Total Donasi'],
      datasets: [{
        data: [{{ $totalDonasi }}],
        borderColor: '#8b5cf6',
        backgroundColor: 'rgba(139, 92, 246, 0.1)',
        borderWidth: 2,
        fill: true
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
@endsection
