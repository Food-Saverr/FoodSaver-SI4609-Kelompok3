@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow animate-fade-up-delay">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Konfirmasi Pembayaran Donasi</h1>
                <p class="text-gray-500">Konfirmasi detail pembayaran donasi Anda</p>
            </div>

            {{-- Flash Messages --}}
            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-up-delay">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">Terdapat kesalahan:</p>
                        <ul class="mt-1 text-sm list-disc list-inside">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            {{-- Donation Summary --}}
            <div class="bg-orange-50 rounded-xl p-6 mb-8 animate-fade-up-delay">
                <h3 class="text-lg font-semibold text-orange-600 mb-4">
                    <i class="fas fa-donate mr-2"></i>Ringkasan Donasi
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 flex items-center">
                            <i class="fas fa-user mr-2 text-orange-400"></i>Nama Donatur
                        </span>
                        <span class="font-medium">{{ $donation->full_name }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 flex items-center">
                            <i class="fas fa-phone mr-2 text-orange-400"></i>Nomor Telepon
                        </span>
                        <span class="font-medium">{{ $donation->phone }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                        <span class="text-gray-900 font-semibold flex items-center">
                            <i class="fas fa-money-bill-wave mr-2 text-orange-400"></i>Total Donasi
                        </span>
                        <span class="text-orange-600 font-bold">
                            Rp {{ number_format($donation->nominal, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Payment Method Display --}}
            <div class="mb-8 animate-fade-up-delay">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    <i class="fas fa-credit-card mr-2"></i>Metode Pembayaran
                </h3>
                @php
                    $paymentMethodLabels = [
                        'credit_card' => ['icon' => 'credit-card', 'label' => 'Kartu Kredit'],
                        'bank_transfer' => ['icon' => 'university', 'label' => 'Transfer Bank'],
                        'e-wallet' => ['icon' => 'wallet', 'label' => 'E-Wallet']
                    ];

                    $selectedMethod = $donation->payment_method ?? '';
                    $methodDetails = $paymentMethodLabels[$selectedMethod] ?? [
                        'icon' => 'exclamation-circle',
                        'label' => 'Metode Pembayaran Tidak Valid'
                    ];
                @endphp

                <div class="flex items-center p-4 border border-gray-200 rounded-xl bg-gray-50">
                    <i class="fas fa-{{ $methodDetails['icon'] }} text-orange-500 text-xl mr-3"></i>
                    <span class="font-medium {{ $selectedMethod ? 'text-gray-800' : 'text-red-600' }}">
                        {{ $methodDetails['label'] }}
                    </span>
                </div>
            </div>

            {{-- Payment Confirmation Form --}}
            <form action="{{ route('pengguna.payment.store') }}" method="POST">
                @csrf
                <input type="hidden" name="donation_id" value="{{ $donation->id }}">
                @if($selectedMethod)
                <input type="hidden" name="payment_method" value="{{ $selectedMethod }}">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3.5 rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200">
                    <i class="fas fa-check-circle mr-2"></i>Konfirmasi Pembayaran
                </button>
                @else
                <div class="w-full bg-red-50 border-l-4 border-red-500 text-red-600 p-4 rounded-lg text-center animate-fade-up-delay">
                    <i class="fas fa-exclamation-circle mr-2"></i>Silakan pilih metode pembayaran terlebih dahulu
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f3f4f6;
        overflow-x: hidden;
    }
    .title-font {
        font-family: 'Montserrat', sans-serif;
    }
    .gradient-text {
        background: linear-gradient(90deg, #f97316, #ea580c);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    .custom-shadow {
        box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.1), 
                    0 3px 20px -5px rgba(0, 0, 0, 0.1);
    }
    .animate-scale {
        transition: transform 0.2s ease;
    }
    .animate-scale:hover {
        transform: scale(1.05);
    }
    .animate-fade-up-delay {
        opacity: 0;
        animation: fadeUp 0.8s forwards ease-out 0.2s;
    }
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection