@extends('layouts.appdonatur')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow animate-fade-up-delay">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Detail Pembayaran</h1>
                <p class="text-gray-500">Ringkasan donasi Anda</p>
            </div>

            @if (session('invoice'))
                {{-- Donation Summary --}}
                <div class="bg-orange-50 rounded-xl p-6 mb-8 animate-fade-up-delay">
                    <h3 class="text-lg font-semibold text-orange-600 mb-4">
                        <i class="fas fa-donate mr-2"></i>Informasi Donasi
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 flex items-center">
                                <i class="fas fa-user mr-2 text-orange-400"></i>Nama Donatur
                            </span>
                            <span class="font-medium">{{ session('invoice')->full_name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 flex items-center">
                                <i class="fas fa-phone mr-2 text-orange-400"></i>Nomor Telepon
                            </span>
                            <span class="font-medium">{{ session('invoice')->phone }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 flex items-center">
                                <i class="fas fa-credit-card mr-2 text-orange-400"></i>Metode Pembayaran
                            </span>
                            <span class="font-medium">
                                @php
                                    $paymentMethodLabels = [
                                        'credit_card' => 'Kartu Kredit',
                                        'bank_transfer' => 'Transfer Bank',
                                        'e-wallet' => 'E-Wallet'
                                    ];
                                    echo $paymentMethodLabels[session('invoice')->payment_method] ?? session('invoice')->payment_method;
                                @endphp
                            </span>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            <span class="text-gray-900 font-semibold flex items-center">
                                <i class="fas fa-money-bill-wave mr-2 text-orange-400"></i>Total Donasi
                            </span>
                            <span class="text-orange-600 font-bold">
                                Rp {{ number_format(session('invoice')->nominal, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-4">
                    <a href="{{ route('donatur.payment.downloadInvoice', session('invoice')->donation_id) }}"
                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3.5 rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200 text-center block">
                        <i class="fas fa-file-download mr-2"></i>Unduh Invoice
                    </a>
                    <a href="{{ route('dashboard.donatur') }}"
                        class="w-full bg-white border border-orange-500 text-orange-600 py-3.5 rounded-xl font-semibold transition hover:bg-orange-50 text-center block animate-scale">
                        <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                    </a>
                </div>
            @else
                <div class="text-center bg-red-50 border-l-4 border-red-500 p-8 rounded-xl animate-fade-up-delay">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-exclamation-circle text-5xl text-red-500 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Tidak Ada Invoice</h3>
                        <p class="text-gray-500 mb-6">Saat ini tidak ada invoice yang tersedia. Silakan coba lagi nanti.</p>
                        <a href="{{ route('dashboard.donatur') }}"
                            class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3.5 rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200">
                            <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <div class="mt-8 text-center text-sm text-gray-600">
            © 2025 FoodSaver. All rights reserved.
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