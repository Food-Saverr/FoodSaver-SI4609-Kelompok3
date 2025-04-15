@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Makanan</h1>
        @foreach($makanans as $makanan)
            <div class="makanan-item">
                <h3>{{ $makanan->Nama_Makanan }}</h3>
                <p>{{ $makanan->Deskripsi_Makanan }}</p>
                <a href="{{ route('request.create', $makanan->ID_Makanan) }}" class="btn btn-primary">Request Makanan</a>
            </div>
        @endforeach
    </div>
@endsection
