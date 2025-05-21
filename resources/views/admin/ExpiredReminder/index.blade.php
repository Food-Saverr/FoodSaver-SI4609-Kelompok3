{{-- resources/views/admin/ExpiredReminder/index.blade.php --}}
@extends('layouts.appadmin')

@section('content')
<div class="container-fluid" style="margin-top: 80px;">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="text-3xl font-extrabold title-font gradient-text mb-2 text-center">Daftar Makanan Hampir Kedaluwarsa</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Makanan</th>
                            <th>Donatur</th>
                            <th>Tanggal Kedaluwarsa</th>
                            <th>Sisa Hari</th>
                            <th>Status Notifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($makanans as $makanan)
                            <tr>
                                <td>{{ $makanan->Nama_Makanan }}</td>
                                <td>{{ $makanan->donatur->Nama_Pengguna ?? 'Tidak Diketahui' }}</td>
                                <td>{{ \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $daysLeft = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->diffInDays(now());
                                        $isExpired = now()->gt(\Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa));
                                    @endphp
                                    @if($isExpired)
                                        <span class="badge bg-danger">Kedaluwarsa</span>
                                    @else
                                        <span class="badge {{ $daysLeft <= 2 ? 'bg-warning' : 'bg-info' }}">
                                            {{ $daysLeft }} Hari Lagi
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($makanan->notified)
                                        <span class="badge bg-success">Telah Diberitahu</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Diberitahu</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.expired-reminders.show', $makanan->ID_Makanan) }}" 
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada makanan yang hampir kedaluwarsa</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection