@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #location-map {
        height: 400px;
        width: 100%;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Makanan Baru</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('makanan.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="Nama_Makanan">Nama Makanan</label>
                            <input type="text" class="form-control @error('Nama_Makanan') is-invalid @enderror" 
                                id="Nama_Makanan" name="Nama_Makanan" value="{{ old('Nama_Makanan') }}" required>
                            @error('Nama_Makanan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Deskripsi_Makanan">Deskripsi</label>
                            <textarea class="form-control @error('Deskripsi_Makanan') is-invalid @enderror" 
                                id="Deskripsi_Makanan" name="Deskripsi_Makanan" rows="3">{{ old('Deskripsi_Makanan') }}</textarea>
                            @error('Deskripsi_Makanan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Kategori_Makanan">Kategori</label>
                            <select class="form-control @error('Kategori_Makanan') is-invalid @enderror" 
                                id="Kategori_Makanan" name="Kategori_Makanan">
                                <option value="">Pilih Kategori</option>
                                <option value="Makanan Pokok">Makanan Pokok</option>
                                <option value="Lauk Pauk">Lauk Pauk</option>
                                <option value="Sayuran">Sayuran</option>
                                <option value="Buah-buahan">Buah-buahan</option>
                                <option value="Snack">Snack</option>
                            </select>
                            @error('Kategori_Makanan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Foto_Makanan">Foto Makanan</label>
                            <input type="file" class="form-control @error('Foto_Makanan') is-invalid @enderror" 
                                id="Foto_Makanan" name="Foto_Makanan">
                            @error('Foto_Makanan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Tanggal_Kedaluwarsa">Tanggal Kedaluwarsa</label>
                            <input type="datetime-local" class="form-control @error('Tanggal_Kedaluwarsa') is-invalid @enderror" 
                                id="Tanggal_Kedaluwarsa" name="Tanggal_Kedaluwarsa" value="{{ old('Tanggal_Kedaluwarsa') }}">
                            @error('Tanggal_Kedaluwarsa')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="Jumlah_Makanan">Jumlah Makanan</label>
                            <input type="number" class="form-control @error('Jumlah_Makanan') is-invalid @enderror" 
                                id="Jumlah_Makanan" name="Jumlah_Makanan" value="{{ old('Jumlah_Makanan') }}" min="1">
                            @error('Jumlah_Makanan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Lokasi Makanan</label>
                            <div id="location-map"></div>
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                            <p class="text-muted">Klik pada peta untuk menentukan lokasi makanan</p>
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Tambah Makanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map;
    let marker;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        map = L.map('location-map').setView([-6.2088, 106.8456], 13); // Default to Jakarta

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Get user's location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                map.setView([lat, lng], 13);
                
                // Add marker at user's location
                marker = L.marker([lat, lng]).addTo(map);
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            });
        }

        // Handle map click
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            // Update marker position
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }

            // Update hidden inputs
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });
    });
</script>
@endsection 