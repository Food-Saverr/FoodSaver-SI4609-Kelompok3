@extends('layouts.appadmin')

@section('title', 'Detail Donasi')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-4xl mx-auto">
        <!-- Navigasi -->
        <a href="{{ route('admin.donation.index') }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-4">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Daftar Donasi
        </a>
        
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">
                    Detail Donasi
                </h1>
                
                <div class="flex space-x-2 mt-4 md:mt-0">
                    <form action="{{ route('admin.donation.destroy', $donation->id) }}" 
                          method="POST" 
                          class="inline-block" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus donasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition animate-scale shadow">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <!-- Informasi Donatur -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama Lengkap -->
                        <div class="p-4 bg-blue-50 rounded-xl">
                            <h3 class="text-sm font-medium text-blue-500 mb-1">Nama Lengkap</h3>
                            <p class="font-medium text-gray-800">
                                <i class="fas fa-user mr-2 text-blue-400"></i>
                                {{ $donation->full_name }}
                            </p>
                        </div>
                        
                        <!-- Nomor Telepon -->
                        <div class="p-4 bg-green-50 rounded-xl">
                            <h3 class="text-sm font-medium text-green-500 mb-1">Nomor Telepon</h3>
                            <p class="font-medium text-gray-800">
                                <i class="fas fa-phone mr-2 text-green-400"></i>
                                {{ $donation->phone }}
                            </p>
                        </div>
                        
                        <!-- Nominal Donasi -->
                        <div class="p-4 bg-orange-50 rounded-xl">
                            <h3 class="text-sm font-medium text-orange-500 mb-1">Nominal Donasi</h3>
                            <p class="font-medium text-gray-800">
                                <i class="fas fa-money-bill-wave mr-2 text-orange-400"></i>
                                @php 
                                    $formattedNominal = number_format($donation->nominal, 0, ',', '.');
                                @endphp
                                Rp {{ $formattedNominal }}
                            </p>
                        </div>
                        
                        <!-- Metode Pembayaran -->
                        <div class="p-4 bg-purple-50 rounded-xl">
                            <h3 class="text-sm font-medium text-purple-500 mb-1">Metode Pembayaran</h3>
                            <p class="font-medium text-gray-800">
                                <i class="fas fa-credit-card mr-2 text-purple-400"></i>
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
                            </p>
                        </div>
                    </div>
                    
                    <!-- Catatan -->
                    <div class="p-6 bg-gray-50 rounded-xl">
                        <h3 class="text-lg font-bold mb-3">Catatan Donasi</h3>
                        <div class="prose max-w-none">
                            @if($donation->note)
                                <p>{{ $donation->note }}</p>
                            @else
                                <p class="text-gray-400 italic">Tidak ada catatan</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Status Timeline -->
                    <div class="p-6 bg-gray-50 rounded-xl">
                        <h3 class="text-lg font-bold mb-4">Status Timeline</h3>
                        <div class="relative">
                            <!-- Garis Timeline -->
                            <div class="absolute h-full w-0.5 bg-gray-200 left-6 top-0"></div>
                            
                            <!-- Status Item -->
                            <div class="relative flex items-start mb-4 pl-16">
                                <div class="absolute left-0 rounded-full w-12 h-12 flex items-center justify-center {{ $donation->created_at ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                                    <i class="fas fa-plus-circle text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Dibuat</h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $donation->created_at ? $donation->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') : 'Tidak tercatat' }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Status Item -->
                            <div class="relative flex items-start mb-4 pl-16">
                                <div class="absolute left-0 rounded-full w-12 h-12 flex items-center justify-center {{ $donation->status == 'Disetujui' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-400' }}">
                                    <i class="fas fa-check-circle text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Status Donasi</h4>
                                    <p class="text-sm text-gray-500">
                                        @if($donation->status == 'Pending')
                                            <span class="text-yellow-600">Pending</span>
                                        @elseif($donation->status == 'Disetujui')
                                            <span class="text-green-600">Disetujui</span>
                                            {{ $donation->updated_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Informasi Tambahan -->
                <div class="lg:col-span-2">
                    <div class="sticky top-28 space-y-6">
                        <!-- Status Donasi -->
                        <div class="p-6 bg-gray-50 rounded-xl">
                            <h3 class="text-lg font-bold mb-4">Status Donasi</h3>
                            <div class="flex items-center space-x-3">
                                @if($donation->status == 'Pending')
                                    <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                @elseif($donation->status == 'Disetujui')
                                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        <i class="fas fa-check-circle mr-1"></i>Disetujui
                                    </span>
                                @endif
                                
                                @if($donation->status == 'Pending')
                                <form action="{{ route('admin.donation.update-status', $donation->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Disetujui">
                                    <button type="submit" class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-medium transition animate-scale shadow">
                                        Setujui
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection