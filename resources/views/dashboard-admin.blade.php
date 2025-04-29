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
      <a href="{{ route('admin.pengguna') }}" class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
            <i class="fas fa-users text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Statistik Pengguna</h3>
        </div>
        <div class="space-y-2 mb-4">
          <p class="text-gray-700">Donatur: <strong class="text-blue-600">{{ $jumlahDonatur }}</strong></p>
          <p class="text-gray-700">Penerima: <strong class="text-blue-600">{{ $jumlahPenerima }}</strong></p>
        </div>
        <div class="mt-auto h-48">
          <canvas id="penggunaChart"></canvas>
        </div>
      </a>

      <a href="{{ route('admin.makanan') }}" class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-green-100 text-green-600 p-3 rounded-full">
            <i class="fas fa-box-open text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Statistik Makanan</h3>
        </div>
        <div class="space-y-2 mb-4">
          <p class="text-gray-700">Tersedia: <strong class="text-green-600">{{ $jumlahMakananTersedia }}</strong> item</p>
          <p class="text-gray-700">Didonasikan: <strong class="text-green-600">{{ $jumlahMakananDidonasikan }}</strong> item</p>
        </div>
        <div class="mt-auto h-48">
          <canvas id="makananChart"></canvas>
        </div>
      </a>

      <a href="{{ route('admin.donasi') }}" class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
            <i class="fas fa-donate text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Statistik Donasi</h3>
        </div>
        <div class="space-y-2 mb-4">
          <p class="text-gray-700">Total: <strong class="text-purple-600">{{ $totalDonasi }}</strong> Porsi</p>
        </div>
        <div class="mt-auto h-48">
          <canvas id="donasiChart"></canvas>
        </div>
      </a>

      <a href="{{ route('admin.artikel') }}" class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
            <i class="fas fa-newspaper text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Total Artikel Terpublikasi</h3>
        </div>
        <div class="space-y-2 mb-4">
          <p class="text-gray-700">Jumlah Artikel: <strong class="text-blue-600">{{ $totalArtikel }}</strong></p>
        </div>
        <div class="mt-auto h-48">
          <canvas id="totalArtikelChart"></canvas>
        </div>
      </a>

      <a href="{{ route('admin.statistikForum') }}" class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8a9 9 0 110-18 9 9 0 010 18zm3-7h2a2 2 0 002-2V7a2 2 0 00-2-2h-5a2 2 0 00-2 2v2"></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold">Statistik Forum</h3>
        </div>
        <div class="space-y-2 mb-4">
          <p class="text-gray-700">Total Forum Dibuat: <strong class="text-purple-600">{{ $totalForum }}</strong></p>
          <p class="text-gray-700">Diskusi Aktif: <strong class="text-purple-600">{{ $diskusiAktif }}</strong></p>
        </div>
        <div class="mt-auto h-48">
          <canvas id="forumPieChart"></canvas>
        </div>
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
        legend: { position: 'bottom' }
      }
    }
  });

  var ctx2 = document.getElementById('makananChart').getContext('2d');
  var makananChart = new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['Tersedia', 'Didonasikan'],
      datasets: [{
        label: 'Jumlah Makanan',
        data: [{{ $jumlahMakananTersedia ?? 0 }}, {{ $jumlahMakananDidonasikan ?? 0 }}],
        backgroundColor: ['#4caf50', '#ff9800'],
        borderColor: ['#fff', '#fff'],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true, precision: 0 }
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
        legend: { display: false }
      },
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

  var ctxArtikel = document.getElementById('totalArtikelChart').getContext('2d');
  var totalArtikelChart = new Chart(ctxArtikel, {
    type: 'bar',
    data: {
      labels: {!! json_encode($artikelLabels) !!},
      datasets: [{
        label: 'Jumlah Artikel per Minggu',
        data: {!! json_encode($artikelData) !!},
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
        title: {
          display: true,
          text: 'Artikel Masuk per Minggu',
          font: { size: 14 }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 1 }
        },
        x: {
          grid: { display: false },
          ticks: { maxRotation: 45, minRotation: 45 }
        }
      }
    }
  });

  var ctxForum = document.getElementById('forumPieChart').getContext('2d');
  var forumChart = new Chart(ctxForum, {
    type: 'pie',
    data: {
      labels: ['Total Forum Dibuat', 'Diskusi Aktif'],
      datasets: [{
        data: [{{ $totalForum }}, {{ $diskusiAktif }}],
        backgroundColor: ['#6b46c1', '#d53f8c'],
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
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
@endsection
