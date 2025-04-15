@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Riwayat Permintaan Anda</h1>
        @foreach($permintaans as $permintaan)
            <div class="permintaan-item">
                <h3>{{ $permintaan->makanan->Nama_Makanan }}</h3>
                <p>Status: {{ $permintaan->Status_Permintaan }}</p>
                <p>Waktu Permintaan: {{ $permintaan->Waktu_Permintaan }}</p>
                <p>Waktu Pengambilan: {{ $permintaan->Waktu_Pengambilan }}</p>
            </div>
        @endforeach
    </div>
@endsection
