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
                                <h1 class="text-3xl font-extrabold title-font gradient-text mb-0">Buat Pemberitahuan Baru</h1>
                            </div>
                            <p class="text-muted mb-0">Kirim pemberitahuan ke donatur mengenai makanan yang akan kedaluwarsa.</p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bell fa-3x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                <div>
                    <h5 class="font-weight-bold mb-0">Error</h5>
                    <p class="mb-0">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3 bg-gradient-light d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-paper-plane mr-1"></i> Form Pengiriman Pemberitahuan</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <div class="d-flex">
                            <div class="mr-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading font-weight-bold">Pengingat H-3 Kadaluwarsa</h6>
                                <p class="mb-0">Pemberitahuan akan dikirim ke donatur untuk memperbarui status makanan yang akan kedaluwarsa dalam 3 hari.</p>
                            </div>
                        </div>
                    </div>
            
                    <form action="{{ route('admin.expired-reminders.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="donatur" class="form-label font-weight-bold">
                                        <i class="fas fa-user mr-1 text-primary"></i> Pilih Donatur
                                    </label>
                                    <select name="donatur_id" id="donatur" class="form-control form-control-lg @error('donatur_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Donatur --</option>
                                        @foreach($donaturs as $donatur)
                                            <option value="{{ $donatur->id_user }}">{{ $donatur->Nama_Pengguna }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Pilih donatur yang akan menerima pemberitahuan</small>
                                    @error('donatur_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="makanan" class="form-label font-weight-bold d-flex align-items-center">
                                        <i class="fas fa-utensils mr-1 text-warning"></i> Pilih Makanan
                                        <div id="loading-spinner" class="ml-2 spinner-border spinner-border-sm text-primary" role="status" style="display: none;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </label>
                                    <select name="makanan_id" id="makanan" class="form-control form-control-lg @error('makanan_id') is-invalid @enderror" required disabled>
                                        <option value="">-- Pilih Makanan --</option>
                                        <!-- This will be populated via JavaScript when a donatur is selected -->
                                    </select>
                                    <div id="empty-state-message" class="mt-2 small text-muted" style="display: none;">
                                        Pilih donatur terlebih dahulu untuk melihat daftar makanan
                                    </div>
                                    <small class="text-muted">Makanan akan muncul setelah memilih donatur</small>
                                    @error('makanan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="judul" class="form-label font-weight-bold">
                                <i class="fas fa-heading mr-1 text-info"></i> Judul Pemberitahuan
                            </label>
                            <input type="text" name="judul" id="judul" class="form-control form-control-lg @error('judul') is-invalid @enderror" required value="{{ old('judul', 'Makanan Akan Segera Kedaluwarsa') }}">
                            <small class="text-muted">Judul email/notifikasi yang akan diterima donatur</small>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="pesan" class="form-label font-weight-bold">
                                        <i class="fas fa-comment-alt mr-1 text-success"></i> Isi Pesan
                                    </label>
                                    <textarea name="pesan" id="pesan" rows="5" class="form-control @error('pesan') is-invalid @enderror" required>{{ old('pesan', 'Makanan Anda akan kedaluwarsa dalam beberapa hari. Mohon segera perbarui status makanan ini.') }}</textarea>
                                    <small class="text-muted">Berikan informasi detail tentang makanan yang akan kedaluwarsa</small>
                                    @error('pesan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-eye mr-1 text-primary"></i> Pratinjau Pesan
                                    </label>
                                    <div class="card border border-info">
                                        <div class="card-body">
                                            <div id="pesan-preview" class="text-muted" style="min-height: 130px;">{{ old('pesan', 'Makanan Anda akan kedaluwarsa dalam beberapa hari. Mohon segera perbarui status makanan ini.') }}</div>
                                        </div>
                                    </div>
                                    <small class="text-muted">Pratinjau pesan yang akan dikirim ke donatur</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim Pemberitahuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 bg-gradient-light">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-question-circle mr-1"></i> Bantuan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <div class="icon-circle bg-primary text-white mx-auto mb-2" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user fa-lg"></i>
                            </div>
                            <h6 class="font-weight-bold">Langkah 1</h6>
                            <p class="small text-muted">Pilih donatur yang makanannya mendekati tanggal kedaluwarsa</p>
                        </div>
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <div class="icon-circle bg-warning text-white mx-auto mb-2" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-utensils fa-lg"></i>
                            </div>
                            <h6 class="font-weight-bold">Langkah 2</h6>
                            <p class="small text-muted">Pilih makanan yang akan kedaluwarsa dari daftar</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="icon-circle bg-success text-white mx-auto mb-2" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-paper-plane fa-lg"></i>
                            </div>
                            <h6 class="font-weight-bold">Langkah 3</h6>
                            <p class="small text-muted">Kirim pemberitahuan dengan judul dan pesan yang informatif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const donaturSelect = document.getElementById('donatur');
        const makananSelect = document.getElementById('makanan');
        const loadingSpinner = document.getElementById('loading-spinner');
        const emptyStateMessage = document.getElementById('empty-state-message');
        const submitBtn = document.querySelector('button[type="submit"]');
        
        // Initialize form validation status
        updateFormValidity();
        
        // Add event listeners to form inputs for validation
        const requiredInputs = document.querySelectorAll('select[required], input[required], textarea[required]');
        requiredInputs.forEach(input => {
            input.addEventListener('change', updateFormValidity);
            input.addEventListener('input', updateFormValidity);
        });
        
        // Form validation function
        function updateFormValidity() {
            let isValid = true;
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                }
            });
            
            if (isValid) {
                submitBtn.classList.remove('disabled', 'btn-secondary');
                submitBtn.classList.add('btn-primary');
                submitBtn.disabled = false;
            } else {
                submitBtn.classList.add('disabled', 'btn-secondary');
                submitBtn.classList.remove('btn-primary');
                submitBtn.disabled = true;
            }
        }
        
        // Donatur select change handler
        donaturSelect.addEventListener('change', function() {
            const donaturId = this.value;
            
            // Reset makanan select
            makananSelect.innerHTML = '<option value="">-- Pilih Makanan --</option>';
            makananSelect.disabled = !donaturId;
            
            if (!donaturId) {
                if (emptyStateMessage) emptyStateMessage.style.display = 'block';
                return;
            }
            
            // Show loading state
            if (loadingSpinner) loadingSpinner.style.display = 'inline-block';
            if (emptyStateMessage) emptyStateMessage.style.display = 'none';
            
            // Fetch food items for selected donatur
            fetch(`/admin/expired-reminders/get-makanan/${donaturId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Hide loading spinner
                    if (loadingSpinner) loadingSpinner.style.display = 'none';
                    
                    if (data.length === 0) {
                        // Show empty state message if no food items
                        if (emptyStateMessage) {
                            emptyStateMessage.textContent = 'Tidak ada makanan yang tersedia untuk donatur ini';
                            emptyStateMessage.style.display = 'block';
                        }
                        return;
                    }
                    
                    // Populate the food select dropdown
                    let options = '<option value="">-- Pilih Makanan --</option>';
                    
                    data.forEach(item => {
                        // Calculate days until expiry
                        const expiryDate = new Date(item.Tanggal_Kedaluwarsa);
                        const today = new Date();
                        const daysRemaining = Math.ceil((expiryDate - today) / (1000 * 60 * 60 * 24));
                        
                        let badgeClass = '';
                        if (daysRemaining <= 1) {
                            badgeClass = 'text-danger font-weight-bold';
                        } else if (daysRemaining <= 3) {
                            badgeClass = 'text-warning font-weight-bold';
                        }
                        
                        options += `<option value="${item.ID_Makanan}" ${badgeClass ? 'class="' + badgeClass + '"' : ''}>
                            ${item.Nama_Makanan} (Kedaluwarsa ${daysRemaining} hari lagi: ${item.Tanggal_Kedaluwarsa})
                        </option>`;
                    });
                    
                    makananSelect.innerHTML = options;
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (loadingSpinner) loadingSpinner.style.display = 'none';
                    
                    // Show error message
                    if (emptyStateMessage) {
                        emptyStateMessage.textContent = 'Terjadi kesalahan saat memuat data makanan';
                        emptyStateMessage.style.display = 'block';
                    }
                });
        });
        
        // Add input preview for message field
        const pesanTextarea = document.getElementById('pesan');
        const pesanPreview = document.getElementById('pesan-preview');
        
        if (pesanTextarea && pesanPreview) {
            pesanTextarea.addEventListener('input', function() {
                pesanPreview.innerHTML = this.value.replace(/\n/g, '<br>');
            });
            // Initialize preview with current value
            pesanPreview.innerHTML = pesanTextarea.value.replace(/\n/g, '<br>');
        }
    });
</script>
@endpush
@endsection
