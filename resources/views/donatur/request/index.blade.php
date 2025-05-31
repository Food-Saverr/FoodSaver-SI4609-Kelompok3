@extends('layouts.appdonatur')

@section('title', 'Daftar Permintaan: ' . $makanan->Nama_Makanan)

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <a href="{{ route('donatur.food-listing.show', $makanan->ID_Makanan) }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-6">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Detail Makanan
        </a>

        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow">
            <h1 class="text-3xl font-extrabold title-font gradient-text mb-4">Permintaan untuk {{ $makanan->Nama_Makanan }}</h1>

            <!-- Status Categories -->
            <div class="grid grid-cols-5 gap-2 mb-6">
                <a href="{{ route('donatur.request.index', ['id_makanan' => $makanan->ID_Makanan, 'status' => 'All']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status', 'All') == 'All' ? 'bg-gray-200 text-gray-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    All
                </a>
                <a href="{{ route('donatur.request.index', ['id_makanan' => $makanan->ID_Makanan, 'status' => 'Pending']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status') == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    Pending
                </a>
                <a href="{{ route('donatur.request.index', ['id_makanan' => $makanan->ID_Makanan, 'status' => 'Approved']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status') == 'Approved' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    On-Going
                </a>
                <a href="{{ route('donatur.request.index', ['id_makanan' => $makanan->ID_Makanan, 'status' => 'Done']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status') == 'Done' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    Done
                </a>
                <a href="{{ route('donatur.request.index', ['id_makanan' => $makanan->ID_Makanan, 'status' => 'Rejected']) }}" 
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
                    <a href="{{ route('donatur.food-listing.show', $makanan->ID_Makanan) }}" class="inline-block mt-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2.5 px-6 rounded-xl font-semibold hover:from-orange-600 hover:to-orange-700 transition animate-scale">
                        Kembali ke Detail Makanan
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-600 border-b border-gray-200">
                                <th class="py-3 px-4">Pengguna</th>
                                <th class="py-3 px-4">Pesan</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4 px-4">{{ $request->pengguna->Nama_Pengguna ?? 'Pengguna Tidak Tersedia' }}</td>
                                    <td class="py-4 px-4">{{ $request->Pesan ?? '-' }}</td>
                                    <td class="py-4 px-4">
                                        <form action="{{ route('donatur.request.update', $request->ID_Request) }}" method="POST" class="status-update-form">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status_request" class="w-full rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-blue-400 transition-all p-2 text-sm text-gray-700" onchange="this.form.submit()">
                                                <option value="Pending" class="bg-yellow-100 text-yellow-800" {{ $request->Status_Request == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Approved" class="bg-blue-100 text-blue-800" {{ $request->Status_Request == 'Approved' ? 'selected' : '' }}>On-Going</option>
                                                <option value="Done" class="bg-green-100 text-green-800" {{ $request->Status_Request == 'Done' ? 'selected' : '' }}>Done</option>
                                                <option value="Rejected" class="bg-red-100 text-red-800" {{ $request->Status_Request == 'Rejected' ? 'selected' : '' }}>Cancel</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="local-time" data-time="{{ $request->created_at->toIso8601String() }}">
                                            {{ $request->created_at->format('d M Y H:i') }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        @if($request->Status_Request === 'Approved')
                                            <div class="space-y-2">
                                                <button onclick="openPickupInfoModal('{{ $request->ID_Request }}', '{{ $request->Waktu_Pengambilan ? $request->Waktu_Pengambilan->format('Y-m-d\TH:i:s') : '-' }}', '{{ $request->Status_Pengambilan }}')" 
                                                    class="w-full text-sm bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors flex items-center justify-center">
                                                    <i class="fas fa-info-circle mr-2"></i>Info Pengambilan
                                                </button>
                                                @if($request->Status_Pengambilan === 'Dijadwalkan' || $request->Status_Pengambilan === 'Siap_Diambil')
                                                    <form action="{{ route('donatur.request.update', $request->ID_Request) }}" method="POST" class="mt-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="status_pengambilan" class="w-full rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-blue-400 transition-all p-2 text-sm text-gray-700" onchange="this.form.submit()">
                                                            <option value="Dijadwalkan" {{ $request->Status_Pengambilan === 'Dijadwalkan' ? 'selected' : '' }}>Sedang Disiapkan</option>
                                                            <option value="Siap_Diambil" {{ $request->Status_Pengambilan === 'Siap_Diambil' ? 'selected' : '' }}>Siap Diambil</option>
                                                        </select>
                                                    </form>
                                                @endif
                                            </div>
                                        @endif
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

<!-- Modal Info Pengambilan -->
<div id="pickupInfoModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">
        <button onclick="closePickupInfoModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-xl font-bold mb-4 text-orange-600">Info Pengambilan</h3>
        <div class="space-y-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-1">Status Pengambilan</p>
                <p id="modal_pickup_status" class="font-semibold text-gray-800"></p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-1">Waktu Pengambilan</p>
                <p id="modal_pickup_waktu" class="font-semibold text-gray-800"></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.status-update-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin mengubah status permintaan ini?')) {
                e.preventDefault();
            }
        });
    });

    // Convert all timestamps to local time
    document.querySelectorAll('.local-time').forEach(element => {
        const timestamp = element.getAttribute('data-time');
        if (timestamp) {
            const date = new Date(timestamp);
            element.textContent = date.toLocaleString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
        }
    });

    function openPickupInfoModal(id, waktu, status) {
        const modal = document.getElementById('pickupInfoModal');
        if (waktu && waktu !== '-') {
            const date = new Date(waktu);
            document.getElementById('modal_pickup_waktu').textContent = date.toLocaleString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
        } else {
            document.getElementById('modal_pickup_waktu').textContent = '-';
        }
        
        // Set status text based on status
        let statusText = '';
        let statusClass = '';
        switch(status) {
            case 'Belum_Dijadwalkan':
                statusText = 'Menunggu Jadwal';
                statusClass = 'text-gray-600';
                break;
            case 'Dijadwalkan':
                statusText = 'Dijadwalkan';
                statusClass = 'text-blue-600';
                break;
            case 'Siap_Diambil':
                statusText = 'Siap Diambil';
                statusClass = 'text-green-600';
                break;
            case 'Dibatalkan':
                statusText = 'Dibatalkan';
                statusClass = 'text-red-600';
                break;
        }
        document.getElementById('modal_pickup_status').textContent = statusText;
        document.getElementById('modal_pickup_status').className = `font-semibold ${statusClass}`;
        
        modal.classList.remove('hidden');
    }

    function closePickupInfoModal() {
        document.getElementById('pickupInfoModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('pickupInfoModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePickupInfoModal();
        }
    });
</script>
@endsection