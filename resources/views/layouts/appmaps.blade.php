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
        .navbar-link:not(.disabled):after {
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
        .navbar-link:not(.disabled):hover:after, .navbar-link.active:after {
            width: 70%;
        }
        .navbar-link.disabled {
            color: #9ca3af;
            cursor: not-allowed;
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
<body class="text-gray-800" x-data="{ open: false }">
    <!-- Sidebar Overlay -->
    <template x-if="open">
        <div class="fixed inset-0 bg-black/40 z-40 transition-opacity duration-300" @click="open = false"></div>
    </template>
    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 h-full w-64 bg-white shadow-xl z-50 transition-transform duration-300 transform" :class="open ? 'translate-x-0' : '-translate-x-full'">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <img src="/FoodSaver.png" alt="FoodSaver Logo" class="h-10 md:h-12 w-auto" />
                <button class="text-gray-700 hover:text-orange-600 focus:outline-none" @click="open = false">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2 text-base font-semibold">
                <a href="{{ route('dashboard.pengguna') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard.pengguna') ? 'bg-orange-100 text-orange-600' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} transition duration-150">
                    <i class="fas fa-home mr-3"></i>Home
                </a>
                <a href="{{ route('pengguna.food-listing.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('pengguna.food-listing.index') ? 'bg-orange-100 text-orange-600' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} transition duration-150">
                    <i class="fas fa-utensils mr-3"></i>Food Listing
                </a>
                <a href="{{ route('pengguna.maps.index') }}" class="navbar-link hover:text-orange-600 {{ request()->routeIs('pengguna.maps.index') ? 'active gradient-text' : 'text-gray-700' }}">
                    <i class="fas fa-map-marked-alt mr-3"></i>Nearby Food Finder
                </a>
                <a href="#" class="flex items-center px-4 py-3 rounded-lg text-gray-400 cursor-not-allowed">
                    <i class="fas fa-comments mr-3"></i>Forum
                </a>
                <a href="#" class="flex items-center px-4 py-3 rounded-lg text-gray-400 cursor-not-allowed">
                    <i class="fas fa-newspaper mr-3"></i>Artikel
                </a>
            </nav>
            <div class="px-6 py-4 border-t border-gray-100">
                @guest
                    <a href="{{ route('login.form') }}" class="block w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-full font-semibold text-center hover:bg-orange-700 transition animate-scale">
                        Login
                    </a>
                @endguest
                @auth
                    <div class="flex flex-col items-start space-y-1">
                        <a href="/profile" class="flex items-center group mb-1">
                            <img 
                                src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->Email_Pengguna))) . '?d=mp&s=32' }}" 
                                class="w-10 h-10 rounded-full border-2 border-orange-200 group-hover:border-orange-400 transition" 
                                alt="{{ Auth::user()->Nama_Pengguna }}"
                                onerror="this.src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=32'"
                            >
                            <div class="ml-3 font-bold text-gray-800 group-hover:text-orange-600 transition text-base">{{ Auth::user()->Nama_Pengguna }}</div>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="mt-1">
                            @csrf
                            <button type="submit" class="text-red-600 text-xs font-semibold hover:underline">Logout</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </aside>
    <!-- Hamburger Button -->
    <button class="fixed top-4 left-4 z-60 bg-white rounded-full p-2 shadow-lg border border-gray-200" @click="open = true">
        <i class="fas fa-bars text-2xl text-orange-500"></i>
    </button>
    <!-- Main Content -->
    <div>
        <main class="min-h-screen pt-8">
            @yield('content')
        </main>
        <footer class="bg-white border-t border-gray-100 py-6 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} FoodSaver. All rights reserved.
        </footer>
    </div>
    @yield('scripts')
</body>
</html>