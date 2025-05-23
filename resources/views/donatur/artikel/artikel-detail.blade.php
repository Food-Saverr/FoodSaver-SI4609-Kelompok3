@extends('layouts.app')

@section('title', $artikel->judul)

@section('content')
<div class="mx-[15%] px-4 py-8 pt-28">
    {{-- Judul --}}
    <h1 class="text-3xl font-bold mb-2 text-center">{{ $artikel->judul }}</h1>

    {{-- Penulis & Tanggal --}}
    <p class="text-center text-gray-600 mb-6">
        Oleh {{ optional($artikel->user)->Nama_Pengguna ?? 'Admin' }} &bull; 
        {{ \Carbon\Carbon::parse($artikel->created_at)->translatedFormat('d F Y') }}
    </p>

    {{-- Gambar --}}
    @if($artikel->gambar)
        <img 
            src="{{ asset('storage/'.$artikel->gambar) }}" 
            alt="{{ $artikel->judul }}" 
            class="mb-6 rounded-lg w-full max-w-3xl mx-auto"
        >
    @endif

    {{-- Konten --}}
    <div class="prose prose-lg mx-auto mb-8" style="text-align: justify;">
        {!! nl2br(e($artikel->konten)) !!}
    </div>

    {{-- Kembali --}}
    <div class="text-center">
        <a href="{{ route('artikel.donatur') }}" class="text-orange-500 hover:underline">
            &larr; Kembali ke daftar artikel
        </a>
    </div>
</div>
@endsection
