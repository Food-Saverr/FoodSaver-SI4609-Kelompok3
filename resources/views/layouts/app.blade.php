<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'FoodSaver - Selamatkan Makanan, Selamatkan Dunia')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8fafc;
        overflow-x: hidden;
        }
        .title-font {
        font-family: 'Montserrat', sans-serif;
        }
        .navbar-scrolled {
        backdrop-filter: blur(8px);
        background-color: rgba(249, 115, 22, 0.95);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .animate-scale {
        transition: all 0.3s ease-in-out;
        }
        .animate-scale:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4);
        }
    </style>
    <script>
        window.addEventListener('scroll', function () {
        const header = document.querySelector('header');
        if (window.scrollY > 50) {
            header.classList.add('navbar-scrolled');
        } else {
            header.classList.remove('navbar-scrolled');
        }
        });
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-orange-50 to-gray-100 scroll-smooth">
    <!-- Navbar -->
    <header class="fixed top-0 w-full bg-gradient-to-r from-orange-500 to-orange-600 shadow z-50 transition-all duration-500 h-16 md:h-20">
        <div class="container mx-auto h-full flex items-center justify-between px-4">
        <img src="/FoodSaver (3).png" alt="FoodSaver Logo" class="h-10 md:h-12 w-auto" />

        <nav class="hidden md:flex items-center space-x-6">
            <a href="{{ route('dashboard.pengguna') }}" class="text-white hover:text-orange-200 transition-colors">Home</a>
            <a href="" class="text-white hover:text-orange-200 transition-colors">Food Listing</a>
            <a href="" class="text-white hover:text-orange-200 transition-colors">Forum</a>
            <a href="" class="text-white hover:text-orange-200 transition-colors">Artikel</a>
            <a href="{{ route('request.index') }}" class="text-white hover:text-orange-200 transition-colors">Request Makanan</a>

            @guest
            <a href="{{ route('login.form') }}" class="bg-white text-orange-600 px-4 py-2 rounded-full font-semibold hover:bg-orange-100 transition animate-scale">
                Login
            </a>
            @endguest

            @auth
            <div x-data="{ open: false }" class="relative">
            <button 
                @click="open = !open" 
                @keydown.escape.window="open = false"
                class="flex items-center gap-2 text-white font-semibold focus:outline-none"
            >
                @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Profile"
                    class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-md ring-2 ring-orange-300 transition duration-300">
                @else
                <i class="fas fa-user-circle text-2xl text-white"></i>
                @endif
                <span class="hidden md:inline">{{ Auth::user()->Nama_Pengguna }}</span>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.063a.75.75 0 011.14.98l-4.25 4.657a.75.75 0 01-1.14 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Dropdown -->
            <div 
                x-show="open" 
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-2xl ring-1 ring-orange-300 z-50 overflow-hidden"
                style="display: none;"
            >
                <div class="bg-orange-100 px-5 py-4 flex items-center gap-3 border-b border-orange-200">
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow">
                @else
                    <i class="fas fa-user-circle text-3xl text-orange-600"></i>
                @endif
                <div>
                    <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->Nama_Pengguna }}</p>
                    <p class="text-xs text-gray-500">Pengguna FoodSaver</p>
                </div>
                </div>
                <a href="" 
                class="block px-5 py-3 text-sm text-gray-700 hover:bg-orange-100 hover:text-orange-600 transition font-medium">
                <i class="fas fa-user mr-2 text-orange-500 group-hover:text-orange-600"></i> Lihat Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full text-left px-5 py-3 text-sm text-gray-700 hover:bg-orange-100 hover:text-orange-600 transition font-medium">
                    <i class="fas fa-sign-out-alt mr-2 text-orange-500 group-hover:text-orange-600"></i> Logout
                </button>
                </form>
            </div>
            </div>
            @endauth
        </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-24 pb-10 px-4 container mx-auto">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-orange-900 text-orange-100 py-12">
        <div class="container mx-auto px-6 text-center">
        <img src="/FoodSaver (3).png" alt="Logo" class="h-16 mx-auto mb-8 floating">
        <p class="mb-8">&copy; 2025 FoodSaver. All rights reserved.</p>
        <div class="flex justify-center space-x-6">
            <a href="#" class="hover:text-orange-400"><i class="fab fa-instagram text-2xl"></i></a>
            <a href="#" class="hover:text-orange-400"><i class="fab fa-facebook text-2xl"></i></a>
            <a href="#" class="hover:text-orange-400"><i class="fab fa-twitter text-2xl"></i></a>
        </div>
        </div>
    </footer>
</body>
</html>