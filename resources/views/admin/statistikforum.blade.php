@extends('layouts.app')

@section('title', 'Statistik Forum - FoodSaver')

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
        Statistik Forum
      </h1>
      <p class="text-gray-600 mt-2 animate-fade-up-delay">
        Pantau perkembangan forum diskusi di platform <span class="font-semibold text-orange-600">FoodSaver</span>.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
      <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="flex items-center space-x-4 mb-4">
          <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
            <i class="fas fa-comments text-xl"></i>
          </div>
          <h3 class="text-xl font-semibold text-gray-800">Total Forum Dibuat</h3>
        </div>
        <p class="text-4xl font-bold text-purple-600 mb-2">{{ $totalForum }}</p>
        <p class="text-sm text-gray-500">Jumlah forum yang telah dibuat oleh pengguna</p>
      </div>

      <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="flex items-center space-x-4 mb-4">
          <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
            <i class="fas fa-comment-dots text-xl"></i>
          </div>
          <h3 class="text-xl font-semibold text-gray-800">Diskusi Aktif</h3>
        </div>
        <p class="text-4xl font-bold text-purple-600 mb-2">{{ $diskusiAktif }}</p>
        <p class="text-sm text-gray-500">Jumlah forum yang masih aktif</p>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
      <h4 class="text-lg font-semibold text-gray-800 mb-4">Perkembangan Forum per Bulan</h4>
      <div class="w-full h-64">
        <canvas id="forumChart"></canvas>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('forumChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: {!! json_encode($bulanLabels) !!},
      datasets: [{
        label: 'Forum Dibuat',
        data: {!! json_encode($forumData) !!},
        backgroundColor: 'rgba(139, 92, 246, 0.2)',
        borderColor: 'rgb(139, 92, 246)',
        borderWidth: 2,
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom'
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
</script>
@endpush
@endsection
