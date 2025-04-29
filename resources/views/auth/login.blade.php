<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - FoodSaver</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8fafc;
        overflow-x: hidden;
        }
        .title-font {
        font-family: 'Montserrat', sans-serif;
        }
        .animate-fade-up {
        opacity: 0;
        animation: fadeUp 0.8s forwards ease-out;
        }
        .animate-fade-up-delay {
        opacity: 0;
        animation: fadeUp 0.8s forwards ease-out;
        animation-delay: 0.3s;
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
        .animate-scale {
        transition: all 0.3s ease-in-out;
        }
        .animate-scale:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4);
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
        .input-focus-effect:focus {
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);              
        }
        .hero-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .floating {
        animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="min-h-screen flex bg-gradient-to-br from-orange-50 to-gray-100">

    <!-- Left: Branding & Image -->
    <div class="hidden lg:flex w-1/2 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-orange-900 via-orange-800 to-gray-900 opacity-90 z-10"></div>
        <div class="absolute inset-0 hero-pattern z-20 opacity-30"></div>
        <div class="h-full w-full bg-cover bg-center transition-all duration-1000 hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1483918793747-5adbf82956c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=934&q=80');"></div>
        
        <div class="absolute inset-0 flex flex-col justify-center items-start px-16 z-30 text-white">
        <div class="floating">
            <img src="/FoodSaver (3).png" alt="FoodSaver Logo" class="w-32 mb-6 drop-shadow-lg" />
        </div>
        
        <button onclick="location.href='/'" class="text-sm text-orange-200 flex items-center hover:text-white transition-colors group mb-10">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Website
        </button>
        
        <h2 class="title-font text-5xl font-extrabold mb-6 leading-tight text-transparent bg-clip-text bg-gradient-to-r from-white to-orange-200">
            Selamatkan Makanan,<br/> Selamatkan Dunia
        </h2>
        
        <p class="max-w-md text-orange-100 text-lg mb-8">
            Bergabung dengan FoodSaver dan bantu hentikan pemborosan makanan untuk masa depan yang lebih baik dan berkelanjutan.
        </p>
        
        <div class="flex space-x-3 text-sm">
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
            </span>
        </div>
        </div>
    </div>

    <!-- Right: Login Form -->
    <div class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md bg-white/70 backdrop-blur-xl rounded-3xl p-10 custom-shadow animate-fade-up">
        <div class="text-center mb-10">
            <div class="flex justify-center mb-2">
            <img src="/api/placeholder/60/60" alt="FoodSaver Icon" class="w-16 h-16 lg:hidden" />
            </div>
            <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Login ke Akun Anda</h1>
            <p class="text-gray-500">Selamat datang kembali di FoodSaver</p>
        </div>

        <!-- Flash Message -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg animate-fade-up-delay">
            {{ session('success') }}
        </div>
        @endif

        <!-- Error Message -->
        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-up-delay">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">Mohon periksa kembali detail login Anda</p>
                    <ul class="mt-1 text-sm list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
            <label for="Email_Pengguna" class="block text-gray-700 font-medium mb-1">Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="far fa-envelope"></i>
                </span>
                <input
                type="email"
                name="Email_Pengguna"
                id="Email_Pengguna"
                placeholder="Masukkan email Anda"
                value="{{ old('Email_Pengguna') }}"
                class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                required
                />
            </div>
            </div>

            <div>
            <div class="flex justify-between items-center mb-1">
                <label for="Password_Pengguna" class="block text-gray-700 font-medium">Password</label>
            </div>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fas fa-lock"></i>
                </span>
                <input
                type="password"
                name="Password_Pengguna"
                id="Password_Pengguna"
                placeholder="Masukkan password Anda"
                class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                required
                />
            </div>
            </div>

            <div class="flex items-center">
            <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-400" />
            <label for="remember" class="ml-2 block text-sm text-gray-600">
                Ingat saya di perangkat ini
            </label>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3.5 rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Masuk Sekarang
            </button>
        </form>

        <p class="mt-8 text-center text-gray-600">
            Belum punya akun?
            <a href="/registrasi" class="text-orange-500 font-semibold hover:underline">
            Daftar Sekarang
            </a>
        </p>
        </div>
    </div>

</body>
</html>