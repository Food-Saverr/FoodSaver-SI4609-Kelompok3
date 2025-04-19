<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Registrasi - FoodSaver</title>
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
        <div class="h-full w-full bg-cover bg-center transition-all duration-1000 hover:scale-105" style="background-image: url('https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-4.0.3&auto=format&fit=crop&w=934&q=80');"></div>
        
        <div class="absolute inset-0 flex flex-col justify-center items-start px-16 z-30 text-white">
            <div class="floating">
                <img src="/FoodSaver (3).png" alt="FoodSaver Logo" class="w-32 mb-6 drop-shadow-lg" />
            </div>
            
            <button onclick="location.href='/'" class="text-sm text-orange-200 flex items-center hover:text-white transition-colors group mb-10">
                <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                Kembali ke Website
            </button>
            
            <h2 class="title-font text-5xl font-extrabold mb-6 leading-tight text-transparent bg-clip-text bg-gradient-to-r from-white to-orange-200">
                Jadilah Bagian<br/> Dari Perubahan
            </h2>
            
            <p class="max-w-md text-orange-100 text-lg mb-8">
                Daftar ke FoodSaver dan bergabunglah dengan ribuan orang untuk menciptakan sistem pangan yang lebih berkelanjutan.
            </p>
            
            <div class="space-y-6 mb-8">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-orange-600/60 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <i class="fas fa-utensils text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Kurangi Limbah Makanan</h3>
                        <p class="text-sm text-orange-200">Selamatkan makanan berlebih dari restoran dan toko</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-orange-600/60 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <i class="fas fa-hand-holding-heart text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Bantu Komunitas</h3>
                        <p class="text-sm text-orange-200">Berbagi dengan yang membutuhkan di sekitar Anda</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-orange-600/60 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <i class="fas fa-earth-asia text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Lindungi Lingkungan</h3>
                        <p class="text-sm text-orange-200">Kurangi emisi karbon dari limbah makanan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Registration Form -->
    <div class="flex-1 flex items-center justify-center px-6 py-3">
        <div class="w-full max-w-lg bg-white/70 backdrop-blur-xl rounded-3xl p-10 custom-shadow animate-fade-up">
            <div class="text-center mb-8">
                <div class="flex justify-center mb-2">
                    <img src="/api/placeholder/60/60" alt="FoodSaver Icon" class="w-16 h-16 lg:hidden" />
                </div>
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Daftar Akun Baru</h1>
            </div>

            <!-- Error Message -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-up-delay">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">Mohon periksa kembali detail pendaftaran Anda</p>
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
            <form action="{{ route('registrasi') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Kolom Email -->
                    <div>
                        <label for="Email_Pengguna" class="block text-gray-700 font-medium mb-1">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input
                                type="email"
                                name="Email_Pengguna"
                                id="Email_Pengguna"
                                placeholder="Masukkan email Anda"
                                value="{{ old('Email_Pengguna') }}"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                                required
                            />
                        </div>
                    </div>

                    <!-- Kolom Nama Lengkap -->
                    <div>
                        <label for="Nama_Pengguna" class="block text-gray-700 font-medium mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="far fa-user"></i>
                            </span>
                            <input
                                type="text"
                                name="Nama_Pengguna"
                                id="Nama_Pengguna"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('Nama_Pengguna') }}"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                                required
                            />
                        </div>
                    </div>
                </div>

                <div>
                    <label for="Password_Pengguna" class="block text-gray-700 font-medium mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input
                            type="password"
                            name="Password_Pengguna"
                            id="Password_Pengguna"
                            placeholder="Buat password minimal 8 karakter"
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                            required
                        />
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Password harus terdiri dari minimal 8 karakter dengan huruf dan angka
                    </p>
                </div>

                <div>
                    <label for="Role_Pengguna" class="block text-gray-700 font-medium mb-1">Peran</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fas fa-user-tag"></i>
                        </span>
                        <select
                            name="Role_Pengguna"
                            id="Role_Pengguna"
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                            required
                        >
                            <option value="" {{ old('Role_Pengguna') == '' ? 'selected' : '' }} disabled>Pilih peran Anda</option>
                            <option value="Pengguna" {{ old('Role_Pengguna') == 'Penerima' ? 'selected' : '' }}>Penerima Makanan</option>
                            <option value="Donatur" {{ old('Role_Pengguna') == 'Donatur' ? 'selected' : '' }}>Donatur Makanan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="Alamat_Pengguna" class="block text-gray-700 font-medium mb-1">Alamat</label>
                    <div class="relative">
                        <span class="absolute top-3 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        <textarea
                            name="Alamat_Pengguna"
                            id="Alamat_Pengguna"
                            rows="3"
                            placeholder="Masukkan alamat lengkap Anda"
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-orange-400 input-focus-effect transition-all"
                            required
                        >{{ old('Alamat_Pengguna') }}</textarea>
                    </div>
                </div>

                <div class="flex items-center mt-4">
                    <input type="checkbox" id="terms" name="terms" class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-400" required />
                    <label for="terms" class="ml-2 block text-xs text-gray-600">
                        Saya menyetujui <a href="#" class="text-orange-500 hover:underline">syarat dan ketentuan</a> serta <a href="#" class="text-orange-500 hover:underline">kebijakan privasi</a>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3.5 rounded-xl font-semibold transition animate-scale shadow-lg shadow-orange-200 mt-4">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Sekarang
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-600">
                Sudah memiliki akun?
                <a href="/login" class="text-orange-500 font-semibold hover:underline">
                    Login di sini
                </a>
            </p>
        </div>
    </div>
</body>
</html>