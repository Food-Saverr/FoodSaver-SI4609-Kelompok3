@extends('layouts.appadmin')

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
<<<<<<< HEAD

=======
>>>>>>> 7bb7304eb8bf3ff2bd53c44e09cfb991043359ab
      <a href="{{ route('admin.makanan') }}" class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-green-100 text-green-600 p-3 rounded-full">
            <i class="fas fa-box-open text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Statistik Makanan</h3>
        </div>
        <div class="space-y-2">
<<<<<<< HEAD
          <p class="text-gray-700">Tersedia: <strong>{{ $jumlahMakananTersedia }}</strong> item</p>
          <p class="text-gray-700">Didonasikan: <strong>{{ $jumlahMakananDidonasikan }}</strong> item</p>
          <p class="text-sm text-gray-500">Jumlah makanan yang tercatat pada platform.</p>
        </div>
        <canvas id="makananChart" height="200"></canvas>
      </a>

=======
          <p>Tersedia: <strong>{{ $jumlahMakananTersedia }}</strong> item</p>
          <p>Didonasikan: <strong>{{ $jumlahMakananDidonasikan }}</strong> item</p>
        </div>
        <canvas id="makananChart" height="200"></canvas>
      </a>
>>>>>>> 7bb7304eb8bf3ff2bd53c44e09cfb991043359ab
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
<<<<<<< HEAD

      <a href="{{ route('admin.artikel') }}" class="block h-full">
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition h-full flex flex-col">
          <div class="flex items-center space-x-4 mb-4">
            <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
              <i class="fas fa-newspaper text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold">Total Artikel Terpublikasi</h3>
          </div>
          <div class="mb-4">
            <p class="text-xl font-bold text-blue-700">Jumlah Artikel: {{ $totalArtikel }}</p>
          </div>
          <div class="mt-auto h-48">
            <canvas id="totalArtikelChart"></canvas>
          </div>
        </div>
      </a>
      <a href="{{ url('/admin/statistik-makanan') }}" class="block h-full">
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition h-full flex flex-col">
          <div class="flex items-center space-x-4 mb-4">
            <div class="bg-green-100 text-green-600 p-3 rounded-full">
              <i class="fas fa-utensils text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold">Statistik Makanan</h3>
          </div>
          <div class="mb-4">
            <p class="mb-2">Tersedia: <strong>{{ $jumlahMakananTersedia }}</strong> item</p>
            <p>Didonasikan: <strong>{{ $jumlahMakananDidonasikan }}</strong> item</p>
          </div>
          <div class="mt-auto">
            <canvas id="statistikMakananChart" height="180"></canvas>
          </div>
        </div>
      </a>

      <a href="{{ url('/admin/total-donasi') }}" class="block h-full">
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition h-full flex flex-col">
          <div class="flex items-center space-x-4 mb-4">
            <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
              <i class="fas fa-donate text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold">Total Donasi</h3>
          </div>
          <div class="mb-4">
            <p class="text-xl font-bold text-purple-700">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</p>
          </div>
          <div class="mt-auto">
            <canvas id="totalDonasiChart" height="180"></canvas>
          </div>
        </div>
      </a>

      <a href="{{ url('/admin/total-artikel') }}" class="block h-full">
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition h-full flex flex-col">
          <div class="flex items-center space-x-4 mb-4">
            <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                <i class="fas fa-newspaper text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold">Total Artikel Terpublikasi</h3>
          </div>
          <div class="mb-4">
            <p class="text-xl font-bold text-blue-700">Jumlah Artikel: {{ $totalArtikel }}</p>
          </div>
          <div class="mt-auto">
            <canvas id="totalArtikelChart" height="180"></canvas>
          </div>
        </div>
      </a>
=======
>>>>>>> 7bb7304eb8bf3ff2bd53c44e09cfb991043359ab
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
<<<<<<< HEAD
  var ctx2 = document.getElementById('makananChart').getContext('2d');
  var makananChart = new Chart(ctx2, {
=======

  var ctxMakanan = document.getElementById('makananChart').getContext('2d');
  var makananChart = new Chart(ctxMakanan, {
>>>>>>> 7bb7304eb8bf3ff2bd53c44e09cfb991043359ab
    type: 'bar',
    data: {
      labels: ['Tersedia', 'Didonasikan'],
      datasets: [{
<<<<<<< HEAD
        label: 'Jumlah Makanan',
        data: [{{ $jumlahMakananTersedia ?? 0 }}, {{ $jumlahMakananDidonasikan ?? 0 }}],
        backgroundColor: ['#4caf50', '#ff9800'],
        borderColor: ['#fff', '#fff'],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          precision: 0
=======
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
>>>>>>> 7bb7304eb8bf3ff2bd53c44e09cfb991043359ab
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
<<<<<<< HEAD
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
  var ctxArtikel = document.getElementById('totalArtikelChart').getContext('2d');
  var totalArtikelChart = new Chart(ctxArtikel, {
    type: 'pie',
    data: {
      labels: ['Artikel Dipublikasikan'],
      datasets: [{
        label: 'Jumlah Artikel',
        data: [{{ $totalArtikel }}],
        backgroundColor: ['#3f51b5'],
        borderColor: ['#fff'],
        borderWidth: 1
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
  var ctxArtikel = document.getElementById('totalArtikelChart').getContext('2d');
  var totalArtikelChart = new Chart(ctxArtikel, {
    type: 'pie',
    data: {
      labels: ['Artikel Dipublikasikan'],
      datasets: [{
        label: 'Jumlah Artikel',
        data: [{{ $totalArtikel }}],
        backgroundColor: ['#3f51b5'],
        borderColor: ['#fff'],
        borderWidth: 1
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
=======
>>>>>>> 7bb7304eb8bf3ff2bd53c44e09cfb991043359ab
</script>
@endsection
