@extends('layouts.appadmin')

@section('title', 'Daftar Makanan Donasi')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Daftar Makanan Donasi</h1>
            <p class="text-gray-500">Kelola daftar makanan yang siap untuk didonasikan</p>
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
                        <th class="py-3 px-4 text-left">Donatur</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($makanans as $makanan)
                    <tr class="hover:bg-orange-50 transition duration-150">
                        <td class="py-3 px-4">
                            <img src="{{ $makanan->Foto_Makanan ? asset('storage/' . $makanan->Foto_Makanan) : asset('images/food-placeholder.jpg') }}" 
                                 alt="{{ $makanan->Nama_Makanan }}" 
                                 class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                        </td>
                        <td class="py-3 px-4 font-medium">{{ $makanan->Nama_Makanan }}</td>
                        <td class="py-3 px-4">{{ $makanan->Kategori_Makanan ?: 'Tidak ada kategori' }}</td>
                        <td class="py-3 px-4">
                            @php
                                $displayStatus = $makanan->Jumlah_Makanan == 0 ? 'Habis' : ($makanan->Jumlah_Makanan < 5 ? 'Segera Habis' : 'Tersedia');
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                         {{ $displayStatus == 'Tersedia' ? 'bg-green-100 text-green-800' : 
                                            ($displayStatus == 'Segera Habis' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                <i class="fas {{ $displayStatus == 'Tersedia' ? 'fa-check-circle' : 
                                                 ($displayStatus == 'Segera Habis' ? 'fa-clock' : 'fa-times-circle') }} mr-1"></i>
                                {{ $displayStatus }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            @php
                                try {
                                    $expDate = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa);
                                    $now = \Carbon\Carbon::now();
                                    $isPast = $expDate->isPast();
                                    $isToday = $expDate->isToday();
                                    $totalHours = $now->diffInHours($expDate, false);
                                    $daysLeft = floor($totalHours / 24);
                                    $hoursLeft = $totalHours % 24;
                                } catch (\Exception $e) {
                                    $expDate = null;
                                    $daysLeft = null;
                                    $hoursLeft = null;
                                    $isPast = true;
                                    $isToday = false;
                                }
                            @endphp
                            <div class="flex items-center space-x-2">
                                @if(is_null($expDate))
                                    <span class="text-red-600 font-medium flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-2 text-sm"></i>
                                        Tanggal Tidak Valid
                                    </span>
                                @elseif($isPast)
                                    <span class="text-red-600 font-medium flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-2 text-sm"></i>
                                        Kedaluwarsa
                                    </span>
                                @elseif($isToday && $totalHours <= 0)
                                    <span class="text-yellow-600 font-medium flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2 text-sm"></i>
                                        Kurang dari 1 jam
                                    </span>
                                @else
                                    <span class="{{ $daysLeft <= 3 ? 'text-yellow-600' : 'text-gray-600' }} flex items-center">
                                        <i class="fas fa-calendar-alt mr-2 text-sm"></i>
                                        {{ $expDate->format('d/m/Y') }}
                                        <span class="ml-1 text-xs">
                                            ({{ $daysLeft }} hari, {{ $hoursLeft }} jam lagi)
                                        </span>
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            {{ $makanan->Jumlah_Makanan ? $makanan->Jumlah_Makanan . ' porsi' : 'Habis' }}
                        </td>
                        <td class="py-3 px-4">
                            {{ $makanan->donatur->Nama_Pengguna ?? 'Pengguna ' . $makanan->ID_Pengguna }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.food-listing.show', $makanan->ID_Makanan) }}" 
                                   class="text-blue-500 hover:text-blue-700 transition px-2 py-1 rounded-lg hover:bg-blue-50">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.food-listing.destroy', $makanan->ID_Makanan) }}" 
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
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-cookie-bite text-5xl text-gray-300 mb-3"></i>
                                <p class="text-lg font-medium">Belum ada data makanan</p>
                                <p class="text-sm text-gray-400">Silakan tunggu donasi dari Donatur</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
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