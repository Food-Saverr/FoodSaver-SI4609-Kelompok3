{{-- resources/views/donatur/ExpiredReminder/index.blade.php --}}
@extends('layouts.appdonatur')

@section('content')
<div class="container-fluid" style="margin-top: 80px;">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border-left-warning">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h1 class="text-3xl font-extrabold title-font gradient-text mb-1">
                                Reminder Makanan Kadaluwarsa
                            </h1>
                            <p class="text-muted mb-0">Daftar makanan yang mendekati tanggal kadaluwarsa dan memerlukan tindakan.</p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-3x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list mr-1"></i> Daftar Makanan Hampir Kedaluwarsa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Makanan</th>
                            <th>Tanggal Kedaluwarsa</th>
                            <th>Sisa Waktu</th>
                            <th>Status Notifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($makanans as $makanan)
                            @php
                                $daysLeft = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->diffInDays(now());
                                $isExpired = now()->gt(\Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa));
                                $rowClass = $isExpired ? 'table-danger' : ($daysLeft <= 1 ? 'table-warning' : '');
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td class="font-weight-bold">{{ $makanan->Nama_Makanan }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="far fa-calendar-alt mr-2 text-gray-500"></i>
                                        {{ \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->format('d M Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($isExpired)
                                            <div class="px-3 py-1 bg-danger text-white rounded-pill d-inline-flex align-items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i> Kedaluwarsa
                                            </div>
                                        @elseif($daysLeft <= 1)
                                            <div class="px-3 py-1 bg-warning text-dark rounded-pill d-inline-flex align-items-center">
                                                <i class="fas fa-exclamation-triangle mr-1"></i> {{ $daysLeft }} Hari Lagi
                                            </div>
                                        @else
                                            <div class="px-3 py-1 bg-info text-white rounded-pill d-inline-flex align-items-center">
                                                <i class="fas fa-clock mr-1"></i> {{ $daysLeft }} Hari Lagi
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($makanan->notified)
                                            <div class="d-inline-flex align-items-center text-success">
                                                <i class="fas fa-bell mr-1"></i> Telah Diberitahu
                                            </div>
                                        @else
                                            <div class="d-inline-flex align-items-center text-secondary">
                                                <i class="fas fa-bell-slash mr-1"></i> Belum Diberitahu
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateStatusModal{{ $makanan->ID_Makanan }}">
                                        <i class="fas fa-edit mr-1"></i> Update Status
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                        <h5 class="font-weight-bold">Tidak Ada Makanan Yang Hampir Kedaluwarsa</h5>
                                        <p class="text-muted">Semua makanan anda masih dalam kondisi baik.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals for each food item to update status -->
@foreach($makanans as $makanan)
<div class="modal fade" id="updateStatusModal{{ $makanan->ID_Makanan }}" tabindex="-1" aria-labelledby="updateStatusModalLabel{{ $makanan->ID_Makanan }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="updateStatusModalLabel{{ $makanan->ID_Makanan }}">
                    <i class="fas fa-edit mr-2"></i> Update Status Makanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('donatur.expired-reminders.update-status', $makanan->ID_Makanan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle bg-light mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; border-radius: 50%;">
                            <i class="fas fa-utensils fa-2x text-primary"></i>
                        </div>
                        <h5 class="font-weight-bold mb-0">{{ $makanan->Nama_Makanan }}</h5>
                        @php
                            $daysLeft = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->diffInDays(now());
                            $isExpired = now()->gt(\Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa));
                        @endphp
                        @if($isExpired)
                            <span class="badge bg-danger mt-2">Kedaluwarsa</span>
                        @else
                            <span class="badge {{ $daysLeft <= 1 ? 'bg-warning' : 'bg-info' }} mt-2">
                                {{ $daysLeft }} Hari Lagi
                            </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="expiry-date-{{ $makanan->ID_Makanan }}" class="form-label">
                            <i class="far fa-calendar-alt mr-1"></i> Tanggal Kedaluwarsa:
                        </label>
                        <input type="date" class="form-control" id="expiry-date-{{ $makanan->ID_Makanan }}" name="Tanggal_Kedaluwarsa" value="{{ \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->format('Y-m-d') }}">
                        <small class="text-muted">Atur ulang tanggal kedaluwarsa jika diperlukan</small>
                    </div>
                    <div class="mb-3">
                        <label for="status-{{ $makanan->ID_Makanan }}" class="form-label">
                            <i class="fas fa-tasks mr-1"></i> Status Makanan:
                        </label>
                        <select class="form-select form-control" id="status-{{ $makanan->ID_Makanan }}" name="Status_Makanan">
                            <option value="Tersedia" {{ $makanan->Status_Makanan == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Habis" {{ $makanan->Status_Makanan == 'Habis' ? 'selected' : '' }}>Habis</option>
                            <option value="Didonasikan" {{ $makanan->Status_Makanan == 'Didonasikan' ? 'selected' : '' }}>Didonasikan</option>
                        </select>
                        <small class="text-muted">Pilih status terbaru dari makanan ini</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
