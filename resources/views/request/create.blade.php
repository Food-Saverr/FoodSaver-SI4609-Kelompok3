@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="text-center">
        <h1 class="text-2xl md:text-3xl font-bold text-orange-600 mb-8">Lanjutkan pesanan</h1>
    </div>

    <div class="flex flex-col md:flex-row items-center justify-between bg-white p-6 rounded-2xl shadow-md space-y-6 md:space-y-0">
        <!-- Gambar makanan -->
        <div class="flex-shrink-0">
            <img src="{{ asset($makanan->Foto) }}" alt="{{ $makanan->Nama_Makanan }}" class="rounded-xl w-72 h-auto object-cover shadow-lg">
        </div>

        <!-- Detail makanan -->
        <div class="flex-1 text-center md:text-left px-6">
            <h2 class="text-xl md:text-2xl font-bold mb-2">{{ $makanan->Nama_Makanan }}</h2>
            <p class="text-lg text-gray-700 mb-1">{{ $makanan->Lokasi }}</p>
            <p class="text-sm text-gray-500">Expired: {{ \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>

<div class="mt-10">
    <form action="{{ route('request.store', $makanan->ID_Makanan) }}" method="POST" class="space-y-4">
        @csrf
        <div class="flex justify-center gap-4">
            
            <!-- Tombol kembali -->
            <a href="{{ route('request.index') }}" 
               class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-full transition duration-300">
                Kembali
            </a>

            <!-- Tombol kirim permintaan -->
            <button type="submit" 
                    class="w-full md:w-auto bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-6 rounded-full transition duration-300">
                Kirim Permintaan
            </button>
        </div>
    </form>
</div>

@endsection
