@extends('layouts.appadmin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Makanan Hampir Kedaluwarsa</h1>
        <a href="{{ route('admin.expired-reminders.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Makanan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            @if($makanan->Foto_Makanan)
                                <img src="{{ asset('storage/' . $makanan->Foto_Makanan) }}" 
                                     alt="{{ $makanan->Nama_Makanan }}" 
                                     class="img-fluid rounded shadow" 
                                     style="max-height: 200px;">
                            @else
                                <div class="bg-light p-5 text-center">
                                    <i class="fas fa-utensils fa-5x text-gray-300"></i>
                                    <p class="mt-2 text-muted">Tidak ada gambar</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Nama Makanan</th>
                                    <td>{{ $makanan->Nama_Makanan }}</td>
                                </tr>
                                <tr>
                                    <th>Donatur</th>
                                    <td>{{ $makanan->donatur->Nama_Pengguna ?? 'Tidak Diketahui' }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>{{ $makanan->Kategori_Makanan }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kedaluwarsa</th>
                                    <td>
                                        {{ \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->format('d M Y') }}
                                        @php
                                            $daysLeft = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->diffInDays(now());
                                            $isExpired = now()->gt(\Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa));
                                        @endphp
                                        <span class="badge {{ $isExpired ? 'bg-danger' : ($daysLeft <= 2 ? 'bg-warning' : 'bg-info') }} ml-2">
                                            @if($isExpired)
                                                Kedaluwarsa
                                            @else
                                                {{ $daysLeft }} Hari Lagi
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Notifikasi</th>
                                    <td>
                                        @if($makanan->notified)
                                            <span class="badge bg-success">Telah Diberitahu</span>
                                        @else
                                            <span class="badge bg-secondary">Belum Diberitahu</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lokasi</th>
                                    <td>{{ $makanan->Lokasi_Makanan }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>{{ $makanan->Jumlah_Makanan }} porsi</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($makanan->Status_Makanan == 'Tersedia')
                                            <span class="badge bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $makanan->Deskripsi_Makanan ?: '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tindakan</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.food-listing.show', $makanan->ID_Makanan) }}" 
                           class="btn btn-info btn-block mb-2">
                            <i class="fas fa-eye fa-fw"></i> Lihat Detail Lengkap
                        </a>
                        
                        @if($makanan->donatur)
                            <a href="mailto:{{ $makanan->donatur->email }}" 
                               class="btn btn-primary btn-block mb-2">
                                <i class="fas fa-envelope fa-fw"></i> Hubungi Donatur
                            </a>
                        @endif
                        
                        @if(!$makanan->notified)
                            <form action="{{ route('admin.expired-reminders.notify', $makanan->ID_Makanan) }}" 
                                  method="POST" class="d-grid">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-block">
                                    <i class="fas fa-bell fa-fw"></i> Kirim Pengingat Sekarang
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Notifikasi</h6>
                </div>
                <div class="card-body">
                    @if($makanan->notified)
                        <p class="text-success">
                            <i class="fas fa-check-circle"></i> Notifikasi terakhir dikirim pada 
                            {{ $makanan->updated_at->format('d M Y H:i') }}
                        </p>
                    @else
                        <p class="text-muted">Bel