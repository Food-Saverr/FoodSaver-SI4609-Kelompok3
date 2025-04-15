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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
      <div class="bg-white rounded-2xl shadow-md p-6 animate-fade-up animate-scale">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
            <i class="fas fa-users text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Pengguna Terdaftar</h3>
        </div>
        <p class="text-gray-700">Donatur: <strong>{{ $jumlahDonatur }}</strong></p>
        <p class="text-gray-700">Penerima: <strong>{{ $jumlahPenerima }}</strong></p>
        <p class="text-sm text-gray-500 mt-2">Memantau pertumbuhan komunitas FoodSaver.</p>
      </div>
      <div class="bg-white rounded-2xl shadow-md p-6 animate-fade-up animate-scale">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-green-100 text-green-600 p-3 rounded-full">
            <i class="fas fa-box-open text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Statistik Makanan</h3>
        </div>
        <p class="text-gray-700">Makanan Tersedia: <strong>{{ $jumlahMakananTersedia }}</strong></p>
        <p class="text-gray-700">Telah Didonasikan: <strong>{{ $jumlahMakananDidonasikan }}</strong></p>
        <p class="text-sm text-gray-500 mt-2">Mengetahui jumlah makanan yang berhasil disalurkan.</p>
      </div>

    </div>

  </div>
</section>
@endsection
