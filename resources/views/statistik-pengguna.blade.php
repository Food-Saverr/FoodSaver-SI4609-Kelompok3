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

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-12 animate-fade-up animate-scale">
      <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
            <i class="fas fa-users text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Pengguna Terdaftar</h3>
        </div>
        <p class="text-gray-700">Donatur: <strong>{{ $jumlahDonatur }}</strong></p>
        <p class="text-gray-700">Penerima: <strong>{{ $jumlahPenerima }}</strong></p>
        <p class="text-sm text-gray-500 mt-2">Memantau pertumbuhan komunitas FoodSaver.</p>
        <canvas id="penggunaChart" height="200"></canvas>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
</script>
@endsection
