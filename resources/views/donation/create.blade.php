@extends('layouts.donation-layout')

@section('title', 'Donasi - FoodSaver')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Donasi - FoodSaver</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            overflow-x: hidden;
        }
        .title-font {
            font-family: 'Montserrat', sans-serif;
        }
        .animate-fade-up {
            opacity: 0;
            animation: fadeUp 0.8s forwards ease-out;
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
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto flex flex-col-reverse lg:flex-row bg-white rounded-3xl overflow-hidden custom-shadow">
            <!-- Form Section -->
            <div class="w-full lg:w-1/2 p-10 flex flex-col justify-center">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Form Donasi</h1>
                    <p class="text-gray-500">Berikan donasi terbaikmu untuk mendukung website ini</p>
                </div>

                <!-- Flash Message -->
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg animate-fade-up">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Error Message -->
                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-up">
                    <p class="text-sm font-medium">Terdapat kesalahan dalam input:</p>
                    <ul class="mt-1 text-sm list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('donation.store') }}" method="POST" class="space-y-6">
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
                            placeholder="Masukkan Nominal Donasi" required />
                    </div>

                    <div>
                        <label for="note" class="block text-gray-700 font-medium mb-1">Catatan (Opsional)</label>
                        <textarea name="note" id="note" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-400"
                            placeholder="Tulis pesan atau maksud donasi...">{{ old('note') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Metode Pembayaran</label>
                        <select name="payment_method"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-400" 
                            required>
                            <option value="">-- Pilih Metode Pembayaran --</option>
                            <option value="credit_card">Kartu Kredit</option>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="e-wallet">E-Wallet</option>
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3.5 rounded-xl font-semibold transition transform hover:scale-105 hover:shadow-lg">
                        <i class="fas fa-hand-holding-heart mr-2"></i> Donasikan Sekarang
                    </button>
                </form>

                <p class="mt-6 text-center text-gray-600 text-sm">
                    Terima kasih atas kontribusi Anda ❤️
                </p>
            </div>

            <!-- Image Section -->
            <div class="w-full lg:w-1/2 bg-cover bg-center relative" 
                style="background-image: url('https://images.unsplash.com/photo-1483918793747-5adbf82956c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=934&q=80')">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-900 via-orange-800 to-gray-900 opacity-80"></div>
                
                <div class="relative z-10 p-10 h-full flex flex-col justify-between text-white">
                    <div>
                        <img src="/FoodSaver (3).png" alt="FoodSaver Logo" class="w-32 mb-6 drop-shadow-lg" />
                    </div>
                    
                    <div>
                        <h2 class="title-font text-4xl font-extrabold mb-6 leading-tight text-transparent bg-clip-text bg-gradient-to-r from-white to-orange-200">
                            Donasi,<br/> Untuk Perkembangan Web FoodSaver!
                        </h2>
                        
                        <p class="max-w-md text-orange-100 mb-8">
                            Kami sangat berterimakasih pada pengguna FoodSaver ingin melakukan donasi untuk perkembangan FoodSaver, stay safe!
                        </p>
                        
                        <!-- <div class="flex space-x-3 text-sm">
                            <span class="bg-orange-700/60 backdrop-blur-sm py-2 px-4 rounded-full flex items-center">
                                <i class="fas fa-leaf mr-2 text-orange-300"></i>
                                Lingkungan
                            </span>
                            <span class="bg-orange-700/60 backdrop-blur-sm py-2 px-4 rounded-full flex items-center">
                                <i class="fas fa-seedling mr-2 text-orange-300"></i>
                                Berkelanjutan
                            </span>
                            <span class="bg-orange-700/60 backdrop-blur-sm py-2 px-4 rounded-full flex items-center">
                                <i class="fas fa-heart mr-2 text-orange-300"></i>
                                Komunitas
                            </span> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <div class="flex justify-center items-center space-x-4">
                <div class="text-sm text-gray-600">
                    © 2025 FoodSaver. All rights reserved.
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-600 hover:text-orange-600"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-600 hover:text-orange-600"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gray-600 hover:text-orange-600"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
@endsection