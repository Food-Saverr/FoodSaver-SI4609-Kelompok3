@extends('layouts.app')

@section('title', 'Statistik Makanan - FoodSaver')

@section('content')
<section class="pt-28 md:pt-32 pb-16 bg-gradient-to-br from-orange-50 to-gray-100 min-h-screen">
  <div class="container mx-auto px-4">
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-purple-700 mb-2">Statistik Makanan</h1>
      <p class="text-gray-600">Pantau status makanan yang tersedia dan telah didonasikan.</p>
    </div>

    {{-- Tombol Kembali --}}
    <div class="mb-6">
      <a href="{{ route('admin.dashboard') }}"
         class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-300">
        ← Kembali ke Dashboard
      </a>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
      <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-green-600">
            <i class="fas fa-box-open mr-2"></i>
            Makanan Tersedia
          </h3>
          <span class="text-2xl font-bold text-green-600">{{ $jumlahMakananTersedia }}</span>
        </div>
      </div>

      <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-blue-600">
            <i class="fas fa-hand-holding-heart mr-2"></i>
            Makanan Didonasikan
          </h3>
          <span class="text-2xl font-bold text-blue-600">{{ $jumlahMakananDidonasikan }}</span>
        </div>
      </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white p-6 rounded-xl shadow">
        <h4 class="text-lg font-semibold mb-4">Distribusi Status Makanan</h4>
        <canvas id="statusMakananPieChart" height="300"></canvas>
      </div>

      <div class="bg-white p-6 rounded-xl shadow">
        <h4 class="text-lg font-semibold mb-4">Perbandingan Status Makanan</h4>
        <canvas id="statusMakananBarChart" height="300"></canvas>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Pie Chart
    const pieCtx = document.getElementById('statusMakananPieChart').getContext('2d');
    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: ['Tersedia', 'Didonasikan'],
        datasets: [{
          data: [{{ $jumlahMakananTersedia }}, {{ $jumlahMakananDidonasikan }}],
          backgroundColor: [
            'rgba(72, 187, 120, 0.8)',  // green
            'rgba(66, 153, 225, 0.8)'   // blue
          ],
          borderColor: [
            'rgba(72, 187, 120, 1)',
            'rgba(66, 153, 225, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom'
          },
          title: {
            display: true,
            text: 'Distribusi Status Makanan'
          }
        }
      }
    });

    // Bar Chart
    const barCtx = document.getElementById('statusMakananBarChart').getContext('2d');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['Status Makanan'],
        datasets: [
          {
            label: 'Tersedia',
            data: [{{ $jumlahMakananTersedia }}],
            backgroundColor: 'rgba(72, 187, 120, 0.8)',
            borderColor: 'rgba(72, 187, 120, 1)',
            borderWidth: 1
          },
          {
            label: 'Didonasikan',
            data: [{{ $jumlahMakananDidonasikan }}],
            backgroundColor: 'rgba(66, 153, 225, 0.8)',
            borderColor: 'rgba(66, 153, 225, 1)',
            borderWidth: 1
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1
            }
          }
        },
        plugins: {
          legend: {
            position: 'bottom'
          },
          title: {
            display: true,
            text: 'Perbandingan Jumlah Makanan'
          }
        }
      }
    });
  });
</script>
@endsection 