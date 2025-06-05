@extends('layouts.app')

@section('title', 'Riwayat Permintaan')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <a href="{{ route('pengguna.food-listing.index') }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-6">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Daftar Makanan
        </a>

        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow">
            <h1 class="text-3xl font-extrabold title-font gradient-text mb-4">Riwayat Permintaan Anda</h1>

            <!-- Status Categories -->
            <div class="grid grid-cols-5 gap-2 mb-6">
                <a href="{{ route('pengguna.request.index', ['status' => 'All']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status', 'All') == 'All' ? 'bg-gray-200 text-gray-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    All
                </a>
                <a href="{{ route('pengguna.request.index', ['status' => 'Pending']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status') == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    Pending
                </a>
                <a href="{{ route('pengguna.request.index', ['status' => 'Approved']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status') == 'Approved' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    On-Going
                </a>
                <a href="{{ route('pengguna.request.index', ['status' => 'Done']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status') == 'Done' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    Done
                </a>
                <a href="{{ route('pengguna.request.index', ['status' => 'Rejected']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status') == 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    Reject
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-xl shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if($requests->isEmpty())
                <div class="text-center p-6 bg-gray-50 rounded-xl">
                    <p class="text-gray-600">
                        Tidak ada permintaan dengan status 
                        {{ request('status', 'All') == 'All' ? 'apapun' : (request('status') == 'Approved' ? 'On-Going' : request('status')) }}.
                    </p>
                    <a href="{{ route('pengguna.food-listing.index') }}" class="inline-block mt-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2.5 px-6 rounded-xl font-semibold hover:from-orange-600 hover:to-orange-700 transition animate-scale">
                        Cari Makanan
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-600 border-b border-gray-200">
                                <th class="py-3 px-4">Makanan</th>
                                <th class="py-3 px-4">Pesan</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4 px-4">{{ $request->makanan->Nama_Makanan ?? 'Makanan Tidak Tersedia' }}</td>
                                    <td class="py-4 px-4">{{ $request->Pesan ?? '-' }}</td>
                                    <td class="py-4 px-4">
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
                                        @elseif($request->Status_Request == 'Rejected')
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                                <i class="fas fa-times-circle mr-1"></i>Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">{{ $request->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-2"  dusk="pickup-button">
                                            @if($request->Status_Request === 'Approved')
                                                @if($request->Status_Pengambilan === 'Belum_Dijadwalkan')
                                                    <button onclick="openPickupModal('{{ $request->ID_Request }}', '', '{{ $request->makanan->Lokasi_Makanan }}')" class="text-sm bg-orange-500 text-white py-2 px-4 rounded-lg hover:bg-orange-600 transition-colors flex items-center">
                                                        <i class="fas fa-calendar-plus mr-2"></i>Pickup
                                                    </button>
                                                @else
                                                    <a href="{{ route('pengguna.request.show', $request->ID_Request) }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white py-1.5 px-4 rounded-xl text-sm font-semibold hover:from-blue-600 hover:to-blue-700 transition animate-scale">
                                                        <i class="fas fa-eye mr-1"></i>Detail
                                                    </a>
                                                @endif
                                            @else
                                                <a href="{{ route('pengguna.request.show', $request->ID_Request) }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white py-1.5 px-4 rounded-xl text-sm font-semibold hover:from-blue-600 hover:to-blue-700 transition animate-scale">
                                                    <i class="fas fa-eye mr-1"></i>Detail
                                                </a>
                                            @endif
                                            @if($request->Status_Request == 'Pending')
                                                <form action="{{ route('pengguna.request.cancel', $request->ID_Request) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan permintaan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-block bg-gradient-to-r from-red-500 to-red-600 text-white py-1.5 px-4 rounded-xl text-sm font-medium hover:from-red-600 hover:to-red-700 transition animate-scale">
                                                        <i class="fas fa-times mr-1"></i>Batalkan
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Pengaturan Pickup -->
<div id="pickupModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">
        <button onclick="closePickupModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-calendar-alt mr-2"></i>Pengaturan Pengambilan
        </h3>
        <form id="pickupForm" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="alamat_pengambilan" id="alamat_pengambilan">
            <div class="mb-4">
                <label for="waktu_pengambilan" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-clock mr-2"></i>Pilih Waktu Pengambilan
                </label>
                <input type="datetime-local" name="waktu_pengambilan" id="waktu_pengambilan" 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    min="{{ now()->addHours(1)->setTimezone('Asia/Jakarta')->format('Y-m-d\TH:i') }}"
                    required>
                <p class="mt-1 text-sm text-gray-500">Pilih waktu minimal 1 jam dari sekarang (WIB)</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-map-marker-alt mr-2"></i>Lokasi Pengambilan
                </label>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p id="modal_lokasi_makanan" class="text-gray-800"></p>
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="flex-1 bg-orange-500 text-white py-2 px-4 rounded-lg hover:bg-orange-600 transition-colors flex items-center justify-center">
                    <i class="fas fa-calendar-check mr-2"></i>Jadwalkan
                </button>
                <button type="button" onclick="closePickupModal()" class="flex-1 bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openPickupModal(requestId, waktu = '', lokasi = '') {
        const modal = document.getElementById('pickupModal');
        const form = document.getElementById('pickupForm');
        const waktuInput = document.getElementById('waktu_pengambilan');
        const lokasiElement = document.getElementById('modal_lokasi_makanan');
        const alamatInput = document.getElementById('alamat_pengambilan');

        // Set form action URL with the request ID
        form.action = `/pengguna/request/${requestId}/pickup`;

        // Set input values if provided
        if (waktu) {
            // Convert UTC time to local time (WIB)
            const localTime = new Date(waktu);
            const year = localTime.getFullYear();
            const month = String(localTime.getMonth() + 1).padStart(2, '0');
            const day = String(localTime.getDate()).padStart(2, '0');
            const hours = String(localTime.getHours()).padStart(2, '0');
            const minutes = String(localTime.getMinutes()).padStart(2, '0');
            waktuInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
        } else {
            waktuInput.value = '';
        }

        // Set location
        lokasiElement.textContent = lokasi || 'Lokasi tidak tersedia';
        alamatInput.value = lokasi || '';

        modal.classList.remove('hidden');
    }

    function closePickupModal() {
        document.getElementById('pickupModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('pickupModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePickupModal();
        }
    });
</script>
@endsection