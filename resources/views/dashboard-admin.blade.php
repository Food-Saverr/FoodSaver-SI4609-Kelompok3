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

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 animate-fade-up animate-scale">
      <a href="{{ url('/admin/statistik-pengguna') }}" class="block h-full">
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition h-full flex flex-col">
          <div class="flex items-center space-x-4 mb-4">
            <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
              <i class="fas fa-users text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold">Statistik Pengguna</h3>
          </div>
          <div class="mb-4">
            <p class="mb-2">Donatur: <strong>{{ $jumlahDonatur }}</strong></p>
            <p>Penerima: <strong>{{ $jumlahPenerima }}</strong></p>
          </div>
          <div class="mt-auto">
            <canvas id="penggunaChart" height="180"></canvas>
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
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const ctx1 = document.getElementById('penggunaChart').getContext('2d');
    new Chart(ctx1, {
      type: 'pie',
      data: {
        labels: ['Donatur', 'Penerima'],
        datasets: [{
          data: [{{ $jumlahDonatur }}, {{ $jumlahPenerima }}],
          backgroundColor: ['#007bff', '#28a745']
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });

    const ctx2 = document.getElementById('statistikMakananChart').getContext('2d');
    new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: ['Tersedia', 'Didonasikan'],
        datasets: [{
          label: 'Jumlah Makanan',
          data: [{{ $jumlahMakananTersedia }}, {{ $jumlahMakananDidonasikan }}],
          backgroundColor: ['#4caf50', '#ff9800']
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });

    const ctx3 = document.getElementById('totalDonasiChart').getContext('2d');
    new Chart(ctx3, {
      type: 'line',
      data: {
        labels: ['Total Donasi'],
        datasets: [{
          label: 'Rp Donasi',
          data: [{{ $totalDonasi }}],
          borderColor: '#673ab7',
          backgroundColor: 'rgba(103, 58, 183, 0.2)',
          borderWidth: 2,
          fill: true
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  });
</script>
@endsection
