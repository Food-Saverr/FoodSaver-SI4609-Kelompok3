@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Atur Waktu Permintaan untuk {{ $makanan->Nama_Makanan }}</h1>
        <form action="{{ route('request.store', $makanan->ID_Makanan) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="Waktu_Pengambilan">Waktu Pengambilan</label>
                <input type="datetime-local" name="Waktu_Pengambilan" id="Waktu_Pengambilan" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Kirim Permintaan</button>
        </form>
    </div>
@endsection
