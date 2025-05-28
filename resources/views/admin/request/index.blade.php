@extends('layouts.appadmin')

@section('title', 'Daftar Permintaan: ' . $makanan->Nama_Makanan)

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <a href="{{ route('admin.food-listing.show', $makanan->ID_Makanan) }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-6">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Detail Makanan 
        </a>

        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-6 custom-shadow">
            <h1 class="text-3xl font-extrabold title-font gradient-text mb-4">Permintaan untuk {{ $makanan->Nama_Makanan }}</h1>

            <!-- Status Categories -->
            <div class="grid grid-cols-5 gap-2 mb-6">
                <a href="{{ route('admin.request.index', ['id_makanan' => $makanan->ID_Makanan, 'status' => 'All']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status', 'All') == 'All' ? 'bg-gray-200 text-gray-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    All
                </a>
                <a href="{{ route('admin.request.index', ['id_makanan' => $makanan->ID_Makanan, 'status' => 'Pending']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status') == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    Pending
                </a>
                <a href="{{ route('admin.request.index', ['id_makanan' => $makanan->ID_Makanan, 'status' => 'Approved']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status') == 'Approved' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    On-Going
                </a>
                <a href="{{ route('admin.request.index', ['id_makanan' => $makanan->ID_Makanan, 'status' => 'Done']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status') == 'Done' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    Done
                </a>
                <a href="{{ route('admin.request.index', ['id_makanan' => $makanan->ID_Makanan, 'status' => 'Rejected']) }}" 
                   class="text-center px-3 py-2 text-sm font-medium rounded-full {{ request('status') == 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                    Reject
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg animate-fade-up-delay">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-up-delay">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($requests->isEmpty())
                <div class="text-center p-6 bg-gray-50 rounded-xl">
                    <p class="text-gray-600">
                        Tidak ada permintaan dengan status 
                        {{ request('status', 'All') == 'All' ? 'apapun' : (request('status') == 'Approved' ? 'On-Going' : request('status')) }}.
                    </p>
                    <a href="{{ route('admin.food-listing.show', $makanan->ID_Makanan) }}" class="inline-block mt-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2.5 px-6 rounded-xl font-semibold hover:from-orange-600 hover:to-orange-700 transition animate-scale">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4 px-4">{{ $request->pengguna->Nama_Pengguna ?? 'Pengguna Tidak Tersedia' }}</td>
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
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                                <i class="fas fa-times-circle mr-1"></i>Reject
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection