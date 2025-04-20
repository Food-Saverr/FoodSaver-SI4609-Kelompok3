@extends('layouts.app')

@section('title', 'Statistik Makanan - FoodSaver')

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
        Statistik Ketersediaan Makanan
      </h1>
      <p class="text-gray-600 mt-2 animate-fade-up-delay">
        Pantau jumlah makanan yang tersedia dan telah didonasikan di platform <span class="font-semibold text-orange-600">FoodSaver</span>.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12 animate-fade-up animate-scale">
      <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-green-100 text-green-600 p-3 rounded-full">
            <i class="fas fa-box-open text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Ketersediaan Makanan</h3>
        </div>
        <p class="text-gray-700">Tersedia: <strong>{{ $jumlahMakananTersedia ?? 0 }}</strong> item</p>
        <p class="text-gray-700">Didonasikan: <strong>{{ $jumlahMakananDidonasikan ?? 0 }}</strong> item</p>
        <p class="text-sm text-gray-500 mt-2">Jumlah makanan yang tercatat pada platform.</p>
        <canvas id="makananChart" height="200"></canvas>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
        y: {
          beginAtZero: true,
          precision: 0
        }
      }
    }
  });
</script>
@endsection
