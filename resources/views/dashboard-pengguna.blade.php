@extends('layouts.app')

@section('title', 'Dashboard - FoodSaver')

@section('content')
<section class="pt-28 md:pt-32 pb-16 bg-gradient-to-br from-orange-50 to-gray-100 min-h-screen">
  <div class="container mx-auto px-4">
    <div class="text-center mb-10">
      <h1 class="text-4xl font-extrabold title-font gradient-text animate-fade-up">Selamat datang, {{ Auth::user()->Nama_Pengguna }}</h1>
      <p class="text-gray-600 mt-2 animate-fade-up-delay">Terima kasih telah menjadi bagian dari gerakan penyelamatan makanan bersama <span class="font-semibold text-orange-600">FoodSaver</span>.</p>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
      <div class="bg-white rounded-2xl p-6 shadow-md animate-fade-up animate-scale">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-orange-100 text-orange-600 p-3 rounded-full">
            <i class="fas fa-utensils text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Total Donasi Makanan</h3>
        </div>
        <p class="text-3xl font-bold text-orange-600">12</p>
      </div>

      <div class="bg-white rounded-2xl p-6 shadow-md animate-fade-up animate-scale">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-orange-100 text-orange-600 p-3 rounded-full">
            <i class="fas fa-leaf text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Limbah Dicegah</h3>
        </div>
        <p class="text-3xl font-bold text-green-600">18 Kg</p>
      </div>

      <div class="bg-white rounded-2xl p-6 shadow-md animate-fade-up animate-scale">
        <div class="flex items-center space-x-4 mb-2">
          <div class="bg-orange-100 text-orange-600 p-3 rounded-full">
            <i class="fas fa-users text-xl"></i>
          </div>
          <h3 class="text-lg font-semibold">Komunitas Terhubung</h3>
        </div>
        <p class="text-3xl font-bold text-orange-500">5</p>
      </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-2xl p-8 text-center shadow-xl animate-fade-up">
      <h2 class="text-2xl font-bold mb-2">Punya Makanan Berlebih?</h2>
      <p class="mb-4">Donasikan sekarang dan bantu mereka yang membutuhkan. Setiap sumbangan berarti!</p>
      <a href="" class="bg-white text-orange-600 px-6 py-3 rounded-full font-semibold hover:bg-orange-100 transition animate-scale inline-flex items-center gap-2">
        <i class="fas fa-donate"></i> Donasi Sekarang
      </a>
    </div>
  </div>
</section>
@endsection