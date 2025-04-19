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
        Pantau perkembangan pengguna dan aktivitas donasi makanan di platform <span class="font-semibold text-orange-600">FoodSaver</span>.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-12 animate-fade-up animate-scale">

      <div class="bg-white p-6 rounded-2xl shadow-md">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
            <i class="fas fa-users text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Pengguna</h3>
        </div>
        <p>Donatur: <strong>{{ $jumlahDonatur }}</strong></p>
        <p>Penerima: <strong>{{ $jumlahPenerima }}</strong></p>
        <canvas id="penggunaChart" height="200"></canvas>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow-md">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-green-100 text-green-600 p-3 rounded-full">
            <i class="fas fa-utensils text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Makanan Tersedia</h3>
        </div>
        <p><strong>{{ $jumlahMakananTersedia }}</strong> item</p>
        <canvas id="makananTersediaChart" height="200"></canvas>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow-md">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
            <i class="fas fa-hand-holding-heart text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Didonasikan</h3>
        </div>
        <p><strong>{{ $jumlahMakananDidonasikan }}</strong> item</p>
        <canvas id="makananDidonasikanChart" height="200"></canvas>
      </div>

      <a href="{{ route('admin.donasi') }}" class="bg-white p-6 rounded-2xl shadow-md hover:bg-gray-100 transition duration-300">
      <div class="bg-white p-6 rounded-2xl shadow-md">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
            <i class="fas fa-donate text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Total Donasi</h3>
        </div>
        <p class="text-xl font-bold text-purple-700">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</p>
        <canvas id="totalDonasiChart" height="200"></canvas>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Chart.js for Pengguna Terdaftar (Donatur vs Penerima)
  var ctx1 = document.getElementById('penggunaChart').getContext('2d');
  var penggunaChart = new Chart(ctx1, {
    type: 'pie',
    data: {
      labels: ['Donatur', 'Penerima'],
      datasets: [{
        label: 'Jumlah Pengguna',
        data: [{{ $jumlahDonatur }}, {{ $jumlahPenerima }}],
        backgroundColor: ['#007bff', '#28a745'],
        borderColor: ['#fff', '#fff'],
        borderWidth: 1
      }]
    }
  });

  // Chart.js for Makanan Tersedia
  var ctx2 = document.getElementById('makananTersediaChart').getContext('2d');
  var makananTersediaChart = new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['Makanan Tersedia', 'Makanan Didonasikan'],
      datasets: [{
        label: 'Jumlah Makanan',
        data: [{{ $jumlahMakananTersedia }}, {{ $jumlahMakananDidonasikan }}],
        backgroundColor: ['#4caf50', '#ff9800'],
        borderColor: ['#fff', '#fff'],
        borderWidth: 1
      }]
    }
  });

  // Chart.js for Total Donasi
  var ctx3 = document.getElementById('totalDonasiChart').getContext('2d');
  var totalDonasiChart = new Chart(ctx3, {
    type: 'line',
    data: {
      labels: ['Total Donasi'],
      datasets: [{
        label: 'Rp Donasi',
        data: [{{ $totalDonasi }}],
        borderColor: '#673ab7',
        backgroundColor: 'rgba(103, 58, 183, 0.2)',
        borderWidth: 2
      }]
    }
  });
</script>
@endsection
