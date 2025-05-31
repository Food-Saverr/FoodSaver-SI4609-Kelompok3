@extends('layouts.app')

@section('title', 'Detail Permintaan - ' . ($request->makanan->Nama_Makanan ?? 'Permintaan'))

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <a href="{{ route('pengguna.request.index') }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-6">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Riwayat Permintaan
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Main Content - Takes 9/12 of the space -->
            <div class="lg:col-span-9">
                <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow">
                    <h1 class="text-3xl font-extrabold title-font gradient-text mb-6">{{ $request->makanan->Nama_Makanan ?? 'Permintaan' }}</h1>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <!-- Food Image & Quick Info - 5 columns on md screens -->
                        <div class="md:col-span-5">
                            <!-- Food Image -->
                            <div class="relative rounded-2xl overflow-hidden bg-gray-100 shadow-md h-72 mb-5">
                                <img src="{{ $request->makanan->Foto_Makanan ? asset('storage/' . $request->makanan->Foto_Makanan) : asset('images/food-placeholder.jpg') }}" 
                                     alt="{{ $request->makanan->Nama_Makanan ?? 'Makanan' }}" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4">
                                    @php
                                        $displayStatus = $request->makanan->Status_Makanan ?? 'Tidak Tersedia';
                                        if ($request->makanan->Jumlah_Makanan == 0) {
                                            $displayStatus = 'Habis';
                                        } elseif ($request->makanan->Jumlah_Makanan < 5) {
                                            $displayStatus = 'Segera Habis';
                                        }
                                    @endphp
                                    @if($displayStatus == 'Tersedia')
                                        <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium shadow-md">
                                            <i class="fas fa-check-circle mr-1"></i>{{ $displayStatus }}
                                        </span>
                                    @elseif($displayStatus == 'Segera Habis')
                                        <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium shadow-md">
                                            <i class="fas fa-clock mr-1"></i>{{ $displayStatus }}
                                        </span>
                                    @elseif($displayStatus == 'Habis')
                                        <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-medium shadow-md">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $displayStatus }}
                                        </span>
                                    @else
                                        <span class="px-4 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-medium shadow-md">
                                            <i class="fas fa-info-circle mr-1"></i>{{ $displayStatus }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Quick Info Cards Grid -->
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div class="p-4 bg-blue-50 rounded-xl shadow-sm text-center">
                                    <div class="text-blue-500 mb-2">
                                        <i class="fas fa-boxes text-xl"></i>
                                    </div>
                                    <p class="text-xs text-blue-800 font-semibold mb-1">JUMLAH</p>
                                    <p class="text-base font-bold text-gray-800">{{ $request->makanan->Jumlah_Makanan ?? '-' }} porsi</p>
                                </div>
                                <div class="p-4 bg-purple-50 rounded-xl shadow-sm text-center">
                                    <div class="text-purple-500 mb-2">
                                        <i class="fas fa-clock text-xl"></i>
                                    </div>
                                    <p class="text-xs text-purple-800 font-semibold mb-1">DITAMBAHKAN</p>
                                    <p class="text-base font-bold text-gray-800">{{ $request->makanan->created_at ? $request->makanan->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y') : '-' }}</p>
                                </div>
                            </div>

                            <!-- Donatur -->
                            <div class="p-5 bg-orange-50 rounded-xl shadow-sm">
                                <h3 class="text-lg font-semibold text-orange-800 mb-4">
                                    <i class="fas fa-user-circle mr-2"></i>Informasi Donatur
                                </h3>
                                <div class="flex items-center">
                                    <img src="{{ optional($request->makanan->donatur)->Foto_Profil ? asset('storage/' . optional($request->makanan->donatur)->Foto_Profil) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(optional($request->makanan->donatur)->Email_Pengguna ?? 'default@example.com'))) . '?d=mp&s=48' }}" 
                                         class="w-16 h-16 rounded-full border-2 border-orange-200" 
                                         alt="{{ optional($request->makanan->donatur)->Nama_Pengguna ?? 'Donatur' }}" 
                                         onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=48'">
                                    <div class="ml-4">
                                        <p class="font-medium text-gray-800 text-lg">{{ optional($request->makanan->donatur)->Nama_Pengguna ?: 'Pengguna #' . ($request->makanan->id_user ?? 'N/A') }}</p>
                                        <p class="text-gray-500">{{ optional($request->makanan->donatur)->Role_Pengguna ?: 'Donatur' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Request Details - 7 columns on md screens -->
                        <div class="md:col-span-7 h-full flex flex-col">
                            <!-- Detail Cards Grid -->
                            <div class="grid grid-cols-1 gap-5 h-full flex-grow">
                                <!-- Kategori -->
                                <div class="p-5 bg-blue-50 rounded-xl shadow-sm">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center p-3 bg-blue-100 rounded-lg mr-4 w-12 h-12">
                                            <i class="fas fa-tag text-blue-500 text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-blue-500 mb-1">Kategori Makanan</h3>
                                            <p class="font-semibold text-gray-800 text-lg">{{ $request->makanan->Kategori_Makanan ?: 'Tidak ada kategori' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Kedaluwarsa -->
                                <div class="p-5 bg-red-50 rounded-xl shadow-sm">
                                    @php
                                        try {
                                            $expDate = \Carbon\Carbon::parse($request->makanan->Tanggal_Kedaluwarsa);
                                            $now = \Carbon\Carbon::now();
                                            $isPast = $expDate->isPast();
                                            $isToday = $expDate->isToday();
                                            $totalHours = $now->diffInHours($expDate, false);
                                            $daysLeft = floor($totalHours / 24);
                                            $hoursLeft = $totalHours % 24;
                                        } catch (\Exception $e) {
                                            $expDate = null;
                                            $isPast = true;
                                        }
                                    @endphp
                                    
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center p-3 bg-red-100 rounded-lg mr-4 w-12 h-12">
                                            @if(is_null($expDate))
                                                <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                                            @elseif($isPast)
                                                <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                                            @elseif($isToday && $totalHours <= 0)
                                                <i class="fas fa-exclamation-circle text-yellow-500 text-lg"></i>
                                            @else
                                                <i class="fas fa-calendar-alt text-red-500 text-lg"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-red-500 mb-1">Tanggal Kedaluwarsa</h3>
                                            <div>
                                                @if(is_null($expDate))
                                                    <p class="text-red-600 font-semibold text-lg">Tanggal Tidak Valid</p>
                                                @elseif($isPast)
                                                    <p class="text-red-600 font-semibold text-lg">{{ $expDate->setTimezone('Asia/Jakarta')->format('d M Y') }}</p>
                                                    <p class="text-red-500 text-sm italic">Kedaluwarsa</p>
                                                @elseif($isToday && $totalHours <= 0)
                                                    <p class="text-yellow-600 font-semibold text-lg">{{ $expDate->setTimezone('Asia/Jakarta')->format('d M Y') }}</p>
                                                    <p class="text-yellow-500 text-sm italic">Kurang dari 1 jam</p>
                                                @else
                                                    <p class="{{ $daysLeft <= 3 ? 'text-yellow-600' : 'text-gray-800' }} font-semibold text-lg">{{ $expDate->setTimezone('Asia/Jakarta')->format('d M Y') }}</p>
                                                    <p class="{{ $daysLeft <= 3 ? 'text-yellow-500' : 'text-gray-500' }} text-sm italic">
                                                        {{ $daysLeft }} hari, {{ $hoursLeft }} jam lagi
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Lokasi (Full Width) -->
                                <div class="p-5 bg-green-50 rounded-xl shadow-sm">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center p-3 bg-green-100 rounded-lg mr-4 w-12 h-12">
                                            <i class="fas fa-map-marker-alt text-green-500 text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-green-500 mb-1">Lokasi Pengambilan</h3>
                                            <p class="font-semibold text-gray-800 text-lg">{{ $request->makanan->Lokasi_Makanan ?: 'Tidak ditentukan' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Deskripsi -->
                                <div class="p-5 bg-gray-50 rounded-xl shadow-sm h-full flex flex-col">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas fa-info-circle mr-3 text-gray-500"></i>Deskripsi Makanan
                                    </h3>
                                    <p class="text-gray-700 leading-relaxed flex-grow">{{ $request->makanan->Deskripsi_Makanan ?: 'Tidak ada deskripsi.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Status Update Card - Takes 3/12 of the space -->
            <div class="lg:col-span-3">
                <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow sticky top-28">
                    <div class="text-center mb-6">
                        <div class="inline-block p-3 bg-blue-100 rounded-full mb-3">
                            <i class="fas fa-clipboard-check text-blue-500 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold gradient-text">Status Permintaan</h3>
                    </div>

                    <!-- Current Status and Last Updated -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-6 shadow-sm">
                        <h4 class="text-sm font-semibold text-gray-800 mb-2">Status Saat Ini</h4>
                        <p class="text-gray-700 mb-2">
                            @if($request->Status_Request == 'Pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            @elseif($request->Status_Request == 'Approved')
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    <i class="fas fa-spinner mr-1"></i>On-Going
                                </span>
                            @elseif($request->Status_Request == 'Done')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Done
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                    <i class="fas fa-times-circle mr-1"></i>Reject
                                </span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-600">
                            <strong>Terakhir Diperbarui:</strong> 
                            {{ $request->updated_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    @if($request->Status_Request === 'Approved')
                        <div class="mt-6 p-5 bg-orange-50 rounded-xl shadow-sm">
                            <h3 class="text-lg font-semibold text-orange-800 mb-4">
                                <i class="fas fa-calendar-alt mr-2"></i>Pengaturan Pengambilan
                            </h3>

                            @if($request->Status_Pengambilan === 'Belum_Dijadwalkan')
                                <form action="{{ route('pengguna.request.update-pickup', $request->ID_Request) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div class="bg-white rounded-lg p-4 shadow-sm">
                                        <div class="mb-4">
                                            <label for="waktu_pengambilan" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-clock mr-2"></i>Pilih Waktu Pengambilan
                                            </label>
                                            <input type="datetime-local" name="waktu_pengambilan" id="waktu_pengambilan" 
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                                min="{{ now()->addHours(1)->format('Y-m-d\TH:i') }}"
                                                required>
                                            <p class="mt-1 text-sm text-gray-500">Pilih waktu minimal 1 jam dari sekarang</p>
                                        </div>
                                        <div class="mb-4">
                                            <label for="alamat_pengambilan" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-map-marker-alt mr-2"></i>Alamat Pengambilan
                                            </label>
                                            <textarea name="alamat_pengambilan" id="alamat_pengambilan" rows="3"
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                                required>{{ $request->Alamat_Pengambilan }}</textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg hover:bg-orange-600 transition-colors flex items-center justify-center">
                                        <i class="fas fa-calendar-check mr-2"></i>Jadwalkan Pengambilan
                                    </button>
                                </form>
                            @elseif($request->Status_Pengambilan === 'Dijadwalkan')
                                <div class="space-y-4">
                                    <div class="bg-white rounded-lg p-4 shadow-sm">
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-calendar text-blue-500 mr-3"></i>
                                            <div>
                                                <p class="text-sm font-medium text-gray-700">Waktu Pengambilan:</p>
                                                <p class="text-lg font-semibold text-gray-900">{{ $request->Waktu_Pengambilan->setTimezone('Asia/Jakarta')->format('d F Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-map-marker-alt text-blue-500 mr-3"></i>
                                            <div>
                                                <p class="text-sm font-medium text-gray-700">Alamat Pengambilan:</p>
                                                <p class="text-lg font-semibold text-gray-900">{{ $request->Alamat_Pengambilan }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex space-x-3">
                                        <button onclick="openEditPickupModal('{{ $request->ID_Request }}', '{{ $request->Waktu_Pengambilan ? $request->Waktu_Pengambilan->format('Y-m-d\TH:i') : '' }}', '{{ $request->makanan->Lokasi_Makanan }}')" 
                                            class="flex-1 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors flex items-center justify-center">
                                            <i class="fas fa-edit mr-2"></i>Ubah Jadwal
                                        </button>
                                        @if($request->Status_Request === 'Pending')
                                            <form action="{{ route('pengguna.request.cancel', $request->ID_Request) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan permintaan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition-colors flex items-center justify-center">
                                                    <i class="fas fa-times-circle mr-2"></i>Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @elseif($request->Status_Pengambilan === 'Siap_Diambil')
                                <div class="space-y-4">
                                    <div class="bg-white rounded-lg p-4 shadow-sm">
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-calendar text-green-500 mr-3"></i>
                                            <div>
                                                <p class="text-sm font-medium text-gray-700">Waktu Pengambilan:</p>
                                                <p class="text-lg font-semibold text-gray-900">{{ $request->Waktu_Pengambilan->setTimezone('Asia/Jakarta')->format('d F Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-map-marker-alt text-green-500 mr-3"></i>
                                            <div>
                                                <p class="text-sm font-medium text-gray-700">Alamat Pengambilan:</p>
                                                <p class="text-lg font-semibold text-gray-900">{{ $request->Alamat_Pengambilan }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-green-100 text-green-800 rounded-lg p-4 text-center">
                                        <i class="fas fa-check-circle text-2xl mb-2"></i>
                                        <p class="font-semibold">Makanan Sudah Siap Diambil</p>
                                    </div>
                                </div>
                            @elseif($request->Status_Pengambilan === 'Dibatalkan')
                                <div class="space-y-4">
                                    <div class="bg-red-100 text-red-800 rounded-lg p-4 text-center">
                                        <i class="fas fa-times-circle text-2xl mb-2"></i>
                                        <p class="font-semibold">Pengambilan Dibatalkan</p>
                                    </div>
                                    @if($request->Catatan_Pembatalan)
                                        <div class="bg-white rounded-lg p-4 shadow-sm">
                                            <p class="text-sm font-medium text-gray-700 mb-2">Alasan Pembatalan:</p>
                                            <p class="text-gray-900">{{ $request->Catatan_Pembatalan }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        @if($request->Status_Request === 'Pending')
                            <form action="{{ route('pengguna.request.cancel', $request->ID_Request) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition-colors">
                                    Batalkan Permintaan
                                </button>
                            </form>
                        @endif

                        @if(Auth::user()->Role_Pengguna === 'Admin' || 
                            (Auth::user()->Role_Pengguna === 'Donatur' && $request->makanan->id_user === Auth::id()))
                            <form action="{{ route('pengguna.request.update', $request->ID_Request) }}" method="POST" class="w-full">
                                @csrf
                                <select name="status_request" 
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 mb-3">
                                    <option value="Pending" {{ $request->Status_Request === 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Approved" {{ $request->Status_Request === 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Done" {{ $request->Status_Request === 'Done' ? 'selected' : '' }}>Done</option>
                                    <option value="Rejected" {{ $request->Status_Request === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <button type="submit" class="w-full bg-orange-500 text-white py-2 px-4 rounded-lg hover:bg-orange-600 transition-colors">
                                    Update Status
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pengambilan -->
<div id="editPickupModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">
        <button onclick="closeEditPickupModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-xl font-bold mb-4 text-orange-600">Ubah Jadwal Pengambilan</h3>
        <form id="editPickupForm" action="" method="POST" class="space-y-4">
            @csrf
            <div class="mb-4">
                <label for="edit_waktu_pengambilan" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-clock mr-2"></i>Pilih Waktu Pengambilan
                </label>
                <input type="datetime-local" name="waktu_pengambilan" id="edit_waktu_pengambilan" 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    min="{{ now()->addHours(1)->format('Y-m-d\TH:i') }}"
                    required>
                <p class="mt-1 text-sm text-gray-500">Pilih waktu minimal 1 jam dari sekarang</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-map-marker-alt mr-2"></i>Lokasi Pengambilan
                </label>
                <div class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-50">
                    <p id="modal_lokasi_pengambilan" class="text-gray-700"></p>
                </div>
            </div>
            <button type="submit" class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg hover:bg-orange-600 transition-colors flex items-center justify-center">
                <i class="fas fa-calendar-check mr-2"></i>Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script>
    function openEditPickupModal(id, waktu, lokasi) {
        const modal = document.getElementById('editPickupModal');
        const form = document.getElementById('editPickupForm');
        const waktuInput = document.getElementById('edit_waktu_pengambilan');
        const lokasiElement = document.getElementById('modal_lokasi_pengambilan');
        
        // Set form action
        form.action = `/pengguna/request/${id}/pickup/edit`;
        
        // Set input values
        waktuInput.value = waktu || '';
        lokasiElement.textContent = lokasi || 'Lokasi tidak tersedia';
        
        modal.classList.remove('hidden');
    }

    function closeEditPickupModal() {
        document.getElementById('editPickupModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('editPickupModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditPickupModal();
        }
    });
</script>
@endsection