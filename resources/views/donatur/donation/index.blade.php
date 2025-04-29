@extends('layouts.appdonatur')

@section('title', 'Daftar Donasi')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Daftar Donasi Anda</h1>
                <p class="text-gray-500">Riwayat dan status donasi yang telah Anda lakukan</p>
            </div>
            <a href="{{ route('donatur.donation.create') }}" class="mt-4 md:mt-0 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-2.5 px-6 rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200">
                <i class="fas fa-hand-holding-heart mr-2"></i>Donasi Baru
            </a>
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

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl overflow-hidden">
                <thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Tanggal</th>
                        <th class="py-3 px-4 text-left">Nominal</th>
                        <th class="py-3 px-4 text-left">Metode Pembayaran</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($donations as $donation)
                    <tr class="hover:bg-orange-50 transition duration-150">
                        <td class="py-3 px-4 font-medium">
                            {{ $donation->created_at->format('d M Y') }}
                        </td>
                        <td class="py-3 px-4">
                            @php 
                                $formattedNominal = number_format($donation->nominal, 0, ',', '.');
                            @endphp
                            Rp {{ $formattedNominal }}
                        </td>
                        <td class="py-3 px-4">
                            @switch($donation->payment_method)
                                @case('credit_card')
                                    Kartu Kredit
                                    @break
                                @case('bank_transfer')
                                    Transfer Bank
                                    @break
                                @case('e-wallet')
                                    E-Wallet
                                    @break
                                @default
                                    {{ $donation->payment_method }}
                            @endswitch
                        </td>
                        <td class="py-3 px-4">
                            @if($donation->status == 'Pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                    <i class="fas fa-clock mr-1"></i>Pending
                                </span>
                            @elseif($donation->status == 'Disetujui')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Diterima
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('donatur.donation.show', $donation->id) }}" 
                               class="text-blue-500 hover:text-blue-700 transition px-2 py-1 rounded-lg hover:bg-blue-50">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-hand-holding-heart text-5xl text-gray-300 mb-3"></i>
                                <p class="text-lg font-medium">Belum ada donasi</p>
                                <p class="text-sm text-gray-400">Anda belum melakukan donasi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $donations->links() }}
        </div>
    </div>
</div>
@endsection