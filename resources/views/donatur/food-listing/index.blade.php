@extends('layouts.appdonatur')

@section('title', 'Daftar Makanan Donasi')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Daftar Makanan Donasi</h1>
                <p class="text-gray-500">Kelola daftar makanan yang Anda donasikan</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-4">
                <a href="{{ route('donatur.expired-food-history.index') }}" 
                   class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white py-2.5 px-6 rounded-xl font-semibold transition animate-scale shadow-lg shadow-red-200">
                    <i class="fas fa-history mr-2"></i>Riwayat Kedaluwarsa
                </a>
                <a href="{{ route('donatur.food-listing.create') }}" 
                   class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-2.5 px-6 rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200">
                    <i class="fas fa-plus mr-2"></i>Tambah Makanan
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
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

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl overflow-hidden">
                <thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Foto</th>
                        <th class="py-3 px-4 text-left">Nama Makanan</th>
                        <th class="py-3 px-4 text-left">Kategori</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Kedaluwarsa</th>
                        <th class="py-3 px-4 text-left">Jumlah</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                        $hasActiveFood = false;
                    @endphp
                    @forelse($makanans as $makanan)
                        @php
                            $expDate = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa);
                            $isExpired = $expDate->isPast();
                            if (!$isExpired) {
                                $hasActiveFood = true;
                            }
                        @endphp
                        @if(!$isExpired)
                        <tr class="hover:bg-orange-50 transition duration-150">
                            <td class="py-3 px-4">
                                <img src="{{ asset('storage/' . $makanan->Foto_Makanan) }}" 
                                     alt="{{ $makanan->Nama_Makanan }}" 
                                     class="w-16 h-16 object-cover rounded-lg border border-gray-200"
                                     onerror="this.src='/api/placeholder/60/60'">
                            </td>
                            <td class="py-3 px-4 font-medium">{{ $makanan->Nama_Makanan }}</td>
                            <td class="py-3 px-4">{{ $makanan->Kategori_Makanan ?: 'Tidak ada kategori' }}</td>
                            <td class="py-3 px-4">
                                @php
                                    $displayStatus = $makanan->Status_Makanan;
                                    if ($makanan->Jumlah_Makanan == 0) {
                                        $displayStatus = 'Habis';
                                    } elseif ($makanan->Jumlah_Makanan < 5) {
                                        $displayStatus = 'Segera Habis';
                                    }
                                @endphp
                                @if($displayStatus == 'Tersedia')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                        <i class="fas fa-check-circle mr-1"></i>{{ $displayStatus }}
                                    </span>
                                @elseif($displayStatus == 'Segera Habis')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                        <i class="fas fa-clock mr-1"></i>{{ $displayStatus }}
                                    </span>
                                @elseif($displayStatus == 'Habis')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                        <i class="fas fa-times-circle mr-1"></i>{{ $displayStatus }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                        <i class="fas fa-info-circle mr-1"></i>{{ $displayStatus }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center space-x-2">
                                    @php
                                        $totalHours = $expDate->diffInHours(now(), false);
                                    @endphp
                                    <span class="{{ $totalHours <= 72 ? 'text-yellow-600' : 'text-gray-600' }} flex items-center">
                                        <i class="fas fa-calendar-alt mr-2 text-sm"></i>
                                        {{ $expDate->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                {{ $makanan->Jumlah_Makanan ? $makanan->Jumlah_Makanan . ' porsi' : 'Habis' }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('donatur.food-listing.show', $makanan->ID_Makanan) }}" 
                                       class="text-blue-500 hover:text-blue-700 transition px-2 py-1 rounded-lg hover:bg-blue-50">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('donatur.food-listing.edit', $makanan->ID_Makanan) }}" 
                                       class="text-yellow-500 hover:text-yellow-700 transition px-2 py-1 rounded-lg hover:bg-yellow-50">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('donatur.food-listing.destroy', $makanan->ID_Makanan) }}" 
                                          method="POST" 
                                          class="inline-block" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus makanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-500 hover:text-red-700 transition px-2 py-1 rounded-lg hover:bg-red-50">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-cookie-bite text-5xl text-gray-300 mb-3"></i>
                                <p class="text-lg font-medium">Belum ada data makanan</p>
                                <p class="text-sm text-gray-400">Silakan tambahkan makanan untuk donasi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    @if(!$hasActiveFood && $makanans->isNotEmpty())
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-history text-5xl text-gray-300 mb-3"></i>
                                <p class="text-lg font-medium">Semua makanan sudah kedaluwarsa</p>
                                <p class="text-sm text-gray-400">Silakan cek halaman <a href="{{ route('donatur.expired-food-history.index') }}" class="text-red-500 hover:text-red-700">Riwayat Kedaluwarsa</a> untuk melihat makanan yang sudah kedaluwarsa</p>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $makanans->links() }}
        </div>
    </div>
</div>
@endsection