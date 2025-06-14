<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin - FoodSaver')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
        .navbar-scrolled {
            backdrop-filter: blur(12px);
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .navbar-link {
            position: relative;
            padding-bottom: 6px;
            transition: color 0.3s ease;
        }
        .navbar-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(90deg, #f97316, #ea580c);
            transition: width 0.3s ease;
        }
        .navbar-link:hover:after, .navbar-link.active:after {
            width: 70%;
        }
        .sidebar-link.active {
            background-color: rgba(249, 115, 22, 0.1);
            color: #f97316;
            border-left: 3px solid #f97316;
        }
        .dropdown-menu {
            animation: slideDown 0.3s ease-out;
            transform-origin: top;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: scaleY(0);
            }
            to {
                opacity: 1;
                transform: scaleY(1);
            }
        }
        main {
            flex: 1 0 auto;
        }
        footer {
            flex-shrink: 0;
        }
    </style>
    @yield('styles')
</head>
<body class="text-gray-800">
    <!-- Navbar -->
    <header class="fixed top-0 left-0 w-full z-50 transition duration-300 ease-in-out bg-white shadow-sm">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center">
                <img src="/FoodSaver.png" alt="FoodSaver Logo" class="h-10 md:h-12 w-auto" />
            </div>
            
            <nav class="hidden md:flex space-x-10 text-sm font-semibold">
                <a href="{{ route('dashboard.admin') }}" class="navbar-link hover:text-orange-600 {{ request()->routeIs('dashboard.admin') ? 'active gradient-text' : 'text-gray-700' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.food-listing.index') }}" class="navbar-link hover:text-orange-600 {{ request()->routeIs('admin.food-listing.index') ? 'active gradient-text' : 'text-gray-700' }}">
                    <i class="fas fa-utensils mr-2"></i>Makanan
                </a>
                <a href="{{ route('admin.manage-user.index') }}" class="navbar-link hover:text-orange-600 {{ request()->routeIs('admin.manage-user.index') ? 'active gradient-text' : 'text-gray-700' }}">
                    <i class="fas fa-users mr-2"></i>Pengguna
                </a>
                <a href="{{ route('artikels.index') }}" class="navbar-link hover:text-orange-600 {{ request()->routeIs('artikels.*') ? 'active gradient-text' : 'text-gray-700' }}">
                    <i class="fas fa-newspaper mr-2"></i>Artikel
                </a>
                <a href="{{ route('admin.forum.index') }}" class="navbar-link hover:text-orange-600 text-gray-700">
                    <i class="fas fa-comments mr-2"></i>Forum
                </a>

            </nav>
            
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-4">
                    @php
                        $role = Auth::check() ? Auth::user()->Role_Pengguna : null;
                        $prefix = $role == 'Admin' ? 'admin' : ($role == 'Donatur' ? 'donatur' : 'pengguna');
                    @endphp
                    <a href="{{ route('admin.notifications.send-form') }}" class="text-gray-600 hover:text-orange-600 transition-colors">
                        <i class="fas fa-bell text-xl"></i>
                    </a>
                    <div x-data="{ open: false }" class="relative" @keydown.escape="open = false">
                        <button @click="open = !open" class="flex items-center text-gray-700 hover:text-orange-600 transition duration-200 group">
                            <img 
                                src="{{ auth()->user()->Foto_Profil ? asset('storage/' . auth()->user()->Foto_Profil) : 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=32' }}" 
                                class="w-9 h-9 rounded-full border-2 border-orange-200 group-hover:border-orange-400 transition" 
                                alt="{{ auth()->user()->Nama_Pengguna ?? 'Admin' }}"
                                onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=32'"
                            >
                            <span class="ml-2 hidden lg:block font-medium group-hover:gradient-text">{{ auth()->user()->Nama_Pengguna ?? 'Admin' }}</span>
                            <i class="fas fa-chevron-down ml-2 text-xs group-hover:gradient-text transition"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 scale-y-0" 
                             x-transition:enter-end="opacity-100 scale-y-100" 
                             x-transition:leave="transition ease-in duration-150" 
                             x-transition:leave-start="opacity-100 scale-y-100" 
                             x-transition:leave-end="opacity-0 scale-y-0"
                             class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl py-3 z-20 custom-shadow dropdown-menu">
                            <a href="#" class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition duration-150">
                                <i class="fas fa-user-circle mr-3 text-orange-500"></i>Profil
                            </a>
                            <a href="#" class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition duration-150">
                                <i class="fas fa-cog mr-3 text-orange-500"></i>Pengaturan
                            </a>
                            <hr class="my-2 border-gray-100">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center w-full text-left px-5 py-3 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition duration-150">
                                    <i class="fas fa-sign-out-alt mr-3"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <button class="md:hidden text-gray-700 hover:text-orange-600 focus:outline-none" x-data="{ open: false }" @click="open = !open; document.getElementById('mobileMenu').classList.toggle('hidden')">
                    <i class="fas fa-bars text-2xl transition-transform" :class="open ? 'rotate-90' : ''"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Navigation Menu -->
        <div class="md:hidden hidden" id="mobileMenu">
            <div class="px-4 pt-3 pb-4 space-y-2 bg-white border-t border-gray-100 shadow-sm">
                <a href="{{ route('dashboard.admin') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('dashboard.admin') ? 'bg-orange-100 text-orange-600' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} transition duration-150">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                <a href="{{ route('admin.food-listing.index') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('admin.food-listing.*') ? 'bg-orange-100 text-orange-600' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} transition duration-150">
                    <i class="fas fa-utensils mr-3"></i>Makanan
                </a>
                <a href="#" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition duration-150">
                    <i class="fas fa-users mr-3"></i>Pengguna
                </a>
                <a href="#" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition duration-150">
                    <i class="fas fa-newspaper mr-3"></i>Artikel
                </a>
                <a href="#" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition duration-150">
                    <i class="fas fa-comments mr-3"></i>Forum
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-24">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="container mx-auto px-4">
            <div class="text-center text-gray-500 text-sm">
                © 2025 FoodSaver. All rights reserved.
            </div>
        </div>
    </footer>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('navbar-scrolled');
            } else {
                header.classList.remove('navbar-scrolled');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>