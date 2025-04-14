@extends('layouts.app')

@section('title', 'Total Donasi - FoodSaver')

@section('content')
<section class="pt-28 md:pt-32 pb-16 bg-gradient-to-br from-orange-50 to-gray-100 min-h-screen">
  <div class="container mx-auto px-4">
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-purple-700 mb-2">Statistik Total Donasi</h1>
      <p class="text-gray-600">Lihat kontribusi pengguna terhadap platform.</p>
    </div>

    {{-- Tombol Kembali --}}
    <div class="mb-6">
      <a href="{{ route('admin.dashboard') }}"
         class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-300">
        ← Kembali ke Dashboard
      </a>
    </div>

    {{-- Chart atau konten lainnya --}}
    <div class="bg-white p-6 rounded-xl shadow">
      <canvas id="donasiBulananChart" height="300"></canvas>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('donasiBulananChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: {!! json_encode($donasiPerBulan->pluck('bulan')) !!},
      datasets: [{
        label: 'Total Donasi per Bulan',
        data: {!! json_encode($donasiPerBulan->pluck('total')) !!},
        backgroundColor: '#7e57c2'
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return 'Rp ' + value.toLocaleString('id-ID');
            }
          }
        }
      }
    }
  });
</script>
@endsection
