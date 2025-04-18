@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center font-bold text-2xl mb-6 text-orange-500">Daftar Makanan</h2>

    <div class="flex flex-col gap-6">
        @foreach($makanans->chunk(2) as $row)
            <div class="flex flex-col md:flex-row gap-6 justify-center">
                @foreach($row as $makanan)
                    <div class="w-full md:w-1/2 max-w-xs bg-white shadow-md rounded-2xl overflow-hidden animate-scale relative">
                        <div class="relative">
                            <img src="{{ asset($makanan->Foto) }}"
                                 alt="{{ $makanan->Nama_Makanan }}"
                                 class="w-full h-40 object-cover">

                            <span class="absolute top-2 right-2 bg-{{ $makanan->Status_Makanan === 'Tersedia' ? 'green' : 'red' }}-500 text-white text-xs px-3 py-1 rounded-full">
                                {{ $makanan->Status_Makanan }}
                            </span>
                        </div>

                        <div class="bg-orange-100 text-center py-4 px-3 rounded-b-2xl">
                            <h3 class="text-orange-500 font-semibold text-lg mb-1">{{ $makanan->Nama_Makanan }}</h3>
                            <p class="text-gray-500 text-sm">{{ $makanan->Lokasi_Makanan }}</p>
                            <p class="text-gray-400 text-xs mb-3">{{ $makanan->created_at->format('Y-m-d H:i:s') }}</p>

                            <a href="{{ route('request.create', $makanan->ID_Makanan) }}"
                               class="bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm px-5 py-2 rounded-lg transition">
                                Pesan
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
@endsection
