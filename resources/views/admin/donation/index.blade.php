@extends('layouts.appadmin')

@section('title', 'Daftar Donasi Keuangan')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Daftar Donasi Keuangan</h1>
                <p class="text-gray-500">Kelola daftar donasi keuangan yang masuk</p>
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
                        <th class="py-3 px-4 text-left">Nama Donatur</th>
                        <th class="py-3 px-4 text-left">Nomor Telepon</th>
                        <th class="py-3 px-4 text-left">Nominal</th>
                        <th class="py-3 px-4 text-left">Metode Pembayaran</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($donations as $donation)
                    <tr class="hover:bg-orange-50 transition duration-150">
                        <td class="py-3 px-4 font-medium">{{ $donation->full_name }}</td>
                        <td class="py-3 px-4">{{ $donation->phone }}</td>
                        <td class="py-3 px-4">
                            @php 
                                $formattedNominal = number_format($donation->nominal, 0, ',', '.');
                            @endphp
                            Rp {{ $formattedNominal }}
                        </td>
                        <td class="py-3 px-4">
                            @switch($donation->payment_method)
                                @case('credit_card')
                                    <span>Kartu Kredit</span>
                                    @break
                                @case('bank_transfer')
                                    <span>Transfer Bank</span>
                                    @break
                                @case('e-wallet')
                                    <span>E-Wallet</span>
                                    @break
                                @default
                                    <span>{{ $donation->payment_method }}</span>
                            @endswitch
                        </td>
                        <td class="py-3 px-4">
                            @if($donation->status == 'Pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                    <i class="fas fa-clock mr-1"></i>{{ $donation->status }}
                                </span>
                            @elseif($donation->status == 'Disetujui')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>{{ $donation->status }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.donation.show', $donation->id) }}" 
                                   class="text-blue-500 hover:text-blue-700 transition px-2 py-1 rounded-lg hover:bg-blue-50">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.donation.destroy', $donation->id) }}" 
                                      method="POST" 
                                      class="inline-block" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus donasi ini?')">
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
                        <td colspan="6" class="py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-hand-holding-heart text-5xl text-gray-300 mb-3"></i>
                                <p class="text-lg font-medium">Belum ada donasi</p>
                                <p class="text-sm text-gray-400">Tidak ada donasi yang diterima saat ini</p>
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