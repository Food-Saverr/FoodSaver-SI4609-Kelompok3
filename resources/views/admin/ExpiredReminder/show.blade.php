@extends('layouts.appadmin')

@section('content')
<div class="container-fluid" style="margin-top: 80px;">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border-left-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="d-flex align-items-center mb-1">
                                <a href="{{ route('admin.expired-reminders.index') }}" class="btn btn-sm btn-outline-primary mr-3">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                <h1 class="h3 font-weight-bold text-primary mb-0">Detail Makanan Kedaluwarsa</h1>
                            </div>
                            <p class="text-muted mb-0">Informasi lengkap dan tindakan untuk makanan yang mendekati tanggal kedaluwarsa.</p>
                        </div>
                        <div class="col-auto">
                            @php
                                $daysLeft = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->diffInDays(now());
                                $isExpired = now()->gt(\Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa));
                            @endphp
                            @if($isExpired)
                                <div class="px-4 py-2 bg-danger text-white rounded-pill d-inline-flex align-items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i> Kedaluwarsa
                                </div>
                            @elseif($daysLeft <= 1)
                                <div class="px-4 py-2 bg-warning text-dark rounded-pill d-inline-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> {{ $daysLeft }} Hari Lagi
                                </div>
                            @else
                                <div class="px-4 py-2 bg-info text-white rounded-pill d-inline-flex align-items-center">
                                    <i class="fas fa-clock mr-2"></i> {{ $daysLeft }} Hari Lagi
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-gradient-light">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle mr-1"></i> Informasi Makanan</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Tindakan:</div>
                            <a class="dropdown-item" href="{{ route('admin.food-listing.show', $makanan->ID_Makanan) }}">
                                <i class="fas fa-eye fa-sm fa-fw mr-2 text-gray-400"></i> Lihat Detail Lengkap
                            </a>
                            @if($makanan->donatur && $makanan->donatur->email)
                            <a class="dropdown-item" href="mailto:{{ $makanan->donatur->email }}">
                                <i class="fas fa-envelope fa-sm fa-fw mr-2 text-gray-400"></i> Email Donatur
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="position-relative d-inline-block">
                                @if($makanan->Foto_Makanan)
                                    <img src="{{ asset('storage/' . $makanan->Foto_Makanan) }}" 
                                        alt="{{ $makanan->Nama_Makanan }}" 
                                        class="img-fluid rounded shadow" 
                                        style="max-height: 200px;">
                                @else
                                    <div class="bg-light p-5 text-center rounded">
                                        <i class="fas fa-utensils fa-5x text-gray-300"></i>
                                        <p class="mt-2 text-muted">Tidak ada gambar</p>
                                    </div>
                                @endif
                                
                                <div class="position-absolute bottom-0 right-0 mb-2 mr-2">
                                    @if($makanan->Status_Makanan == 'Tersedia')
                                        <span class="badge badge-pill badge-success px-3 py-2 shadow-sm">
                                            <i class="fas fa-check-circle mr-1"></i> Tersedia
                                        </span>
                                    @else
                                        <span class="badge badge-pill badge-secondary px-3 py-2 shadow-sm">
                                            <i class="fas fa-times-circle mr-1"></i> Tidak Tersedia
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <h5 class="mt-3 font-weight-bold text-primary">{{ $makanan->Nama_Makanan }}</h5>
                            <p class="badge badge-pill badge-light">{{ $makanan->Kategori_Makanan }}</p>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mr-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <small class="text-uppercase text-muted font-weight-bold">Donatur</small>
                                        <div class="font-weight-bold">{{ $makanan->donatur->Nama_Pengguna ?? 'Tidak Diketahui' }}</div>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-info text-white rounded-circle mr-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        <small class="text-uppercase text-muted font-weight-bold">Tanggal Kedaluwarsa</small>
                                        <div class="d-flex align-items-center">
                                            <div class="font-weight-bold mr-2">{{ \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->format('d M Y') }}</div>
                                            @php
                                                $daysLeft = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->diffInDays(now());
                                                $isExpired = now()->gt(\Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa));
                                            @endphp
                                            <div class="badge badge-pill {{ $isExpired ? 'badge-danger' : ($daysLeft <= 2 ? 'badge-warning' : 'badge-info') }} px-2 py-1">
                                                @if($isExpired)
                                                    <i class="fas fa-exclamation-circle mr-1"></i> Kedaluwarsa
                                                @else
                                                    <i class="fas fa-hourglass-half mr-1"></i> {{ $daysLeft }} Hari Lagi
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center {{ $makanan->notified ? 'bg-success' : 'bg-secondary' }} text-white rounded-circle mr-3" style="width: 40px; height: 40px;">
                                        <i class="fas {{ $makanan->notified ? 'fa-bell' : 'fa-bell-slash' }}"></i>
                                    </div>
                                    <div>
                                        <small class="text-uppercase text-muted font-weight-bold">Status Notifikasi</small>
                                        <div class="font-weight-bold">
                                            @if($makanan->notified)
                                                <span class="text-success"><i class="fas fa-check-circle mr-1"></i> Telah Diberitahu</span>
                                            @else
                                                <span class="text-muted"><i class="fas fa-times-circle mr-1"></i> Belum Diberitahu</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-warning text-white rounded-circle mr-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <small class="text-uppercase text-muted font-weight-bold">Lokasi</small>
                                        <div class="font-weight-bold">{{ $makanan->Lokasi_Makanan ?: 'Tidak Ada' }}</div>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded-circle mr-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-shopping-basket"></i>
                                    </div>
                                    <div>
                                        <small class="text-uppercase text-muted font-weight-bold">Jumlah</small>
                                        <div class="font-weight-bold">{{ $makanan->Jumlah_Makanan }} porsi</div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($makanan->Deskripsi_Makanan)
                            <div class="card bg-light shadow-sm mb-3">
                                <div class="card-body">
                                    <h6 class="text-dark mb-2"><i class="fas fa-align-left mr-1"></i> Deskripsi</h6>
                                    <p class="mb-0">{{ $makanan->Deskripsi_Makanan }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Tindakan Card -->
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 bg-gradient-light">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-tasks mr-1"></i> Tindakan</h6>
                </div>
                <div class="card-body">
                    @if(!$makanan->notified)
                        <div class="alert alert-warning" role="alert">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="alert-heading font-weight-bold">Perhatian!</h6>
                                    <p class="mb-0">Makanan ini akan segera kedaluwarsa. Segera kirim notifikasi ke donatur.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="action-buttons">
                        @if(!$makanan->notified)
                            <form action="{{ route('admin.expired-reminders.notify', $makanan->ID_Makanan) }}" 
                                  method="POST" class="mb-3">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-block btn-lg shadow-sm">
                                    <i class="fas fa-bell mr-2"></i> Kirim Pengingat Sekarang
                                </button>
                            </form>
                        @else
                            <button disabled type="button" class="btn btn-success btn-block mb-3 shadow-sm">
                                <i class="fas fa-check-circle mr-2"></i> Pengingat Sudah Dikirim
                            </button>
                        @endif
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <a href="{{ route('admin.food-listing.show', $makanan->ID_Makanan) }}" 
                                   class="btn btn-info btn-block shadow-sm">
                                    <i class="fas fa-eye mr-1"></i> Detail Lengkap
                                </a>
                            </div>
                            <div class="col-6">
                                @if($makanan->donatur && $makanan->donatur->email)
                                    <a href="mailto:{{ $makanan->donatur->email }}" 
                                       class="btn btn-primary btn-block shadow-sm">
                                        <i class="fas fa-envelope mr-1"></i> Email Donatur
                                    </a>
                                @else
                                    <button disabled class="btn btn-secondary btn-block">
                                        <i class="fas fa-envelope mr-1"></i> Tidak Ada Email
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-light shadow-sm">
                        <div class="card-body py-3">
                            <h6 class="text-dark mb-2"><i class="fas fa-info-circle mr-1"></i> Status Makanan</h6>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span>Ketersediaan:</span>
                                <span class="badge {{ $makanan->Status_Makanan == 'Tersedia' ? 'badge-success' : 'badge-secondary' }} px-3 py-2">
                                    {{ $makanan->Status_Makanan }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <span>Notifikasi:</span>
                                <span class="badge {{ $makanan->notified ? 'badge-success' : 'badge-secondary' }} px-3 py-2">
                                    {{ $makanan->notified ? 'Sudah' : 'Belum' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Notifikasi Card -->
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3 bg-gradient-light">
                    <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-history mr-1"></i> Riwayat Notifikasi</h6>
                </div>
                <div class="card-body">
                    @if($makanan->notified)
                        <div class="text-center mb-4">
                            <div class="icon-circle bg-success text-white mx-auto mb-3" style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check fa-2x"></i>
                            </div>
                            <h5 class="font-weight-bold">Notifikasi Terkirim</h5>
                        </div>
                        
                        <div class="timeline mb-0">
                            <div class="timeline-item">
                                <div class="timeline-icon bg-info">
                                    <i class="fas fa-bell text-white"></i>
                                </div>
                                <div class="timeline-content p-3 bg-light rounded shadow-sm">
                                    <h6 class="font-weight-bold mb-1">Pengingat Kedaluwarsa</h6>
                                    <p class="text-muted small mb-2">{{ $makanan->updated_at->format('d M Y - H:i') }}</p>
                                    <p class="mb-0">Notifikasi pengingat kedaluwarsa telah dikirim ke donatur <strong>{{ $makanan->donatur->Nama_Pengguna ?? 'Tidak Diketahui' }}</strong>.</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="icon-circle bg-secondary text-white mx-auto mb-3" style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-bell-slash fa-2x"></i>
                            </div>
                            <h5 class="font-weight-bold text-gray-800">Belum Ada Notifikasi</h5>
                            <p class="text-muted mb-0">Belum ada pengingat yang dikirim ke donatur untuk makanan ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection