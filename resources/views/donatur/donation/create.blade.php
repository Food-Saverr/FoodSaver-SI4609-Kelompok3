@extends('layouts.appdonatur')

@section('title', 'Donasi - FoodSaver')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow animate-fade-up-delay">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Form Donasi</h1>
                <p class="text-gray-500">Berikan donasi terbaikmu untuk mendukung FoodSaver</p>
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

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-up-delay">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">Terdapat kesalahan dalam input:</p>
                        <ul class="mt-1 text-sm list-disc list-inside">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Donation Form -->
            <form action="{{ route('donatur.donation.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="full_name" class="block text-gray-700 font-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        placeholder="Masukkan nama lengkap" required />
                </div>

                <div>
                    <label for="phone" class="block text-gray-700 font-medium mb-1">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        placeholder="Masukkan nomor telepon" required />
                </div>

                <div>
                    <label for="nominal" class="block text-gray-700 font-medium mb-1">Nominal Donasi</label>
                    <input type="text" name="nominal" id="nominal" value="{{ old('nominal') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        placeholder="Masukkan nominal donasi" required />
                </div>

                <div>
                    <label for="note" class="block text-gray-700 font-medium mb-1">Catatan (Opsional)</label>
                    <textarea name="note" id="note" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        placeholder="Tulis pesan atau maksud donasi...">{{ old('note') }}</textarea>
                </div>

                <div>
                    <label for="payment_method" class="block text-gray-700 font-medium mb-1">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-400"
                        required>
                        <option value="">-- Pilih Metode Pembayaran --</option>
                        <option value="credit_card">Kartu Kredit</option>
                        <option value="bank_transfer">Transfer Bank</option>
                        <option value="e-wallet">E-Wallet</option>
                    </select>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3.5 rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200">
                    <i class="fas fa-hand-holding-heart mr-2"></i>Donasikan Sekarang
                </button>
            </form>

            <p class="mt-6 text-center text-gray-600 text-sm">
                Terima kasih atas kontribusi Anda ❤️
            </p>
        </div>

        <!-- Footer -->
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