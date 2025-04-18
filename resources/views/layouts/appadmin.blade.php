<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard Admin - FoodSaver')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
</head>
<body class="text-gray-800">
    <header class="fixed top-0 left-0 w-full z-50 transition duration-300 ease-in-out bg-white">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="text-2xl font-bold text-orange-600 title-font">FoodSaver Admin</div>
            <nav class="hidden md:flex space-x-6 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-600">Dashboard</a>
                <a href="{{ route('admin.pengguna') }}" class="hover:text-orange-600">Pengguna</a>
                <a href="{{ route('admin.makanan') }}" class="hover:text-orange-600">Makanan</a>
                <a href="{{ route('admin.artikel') }}" class="hover:text-orange-600">Artikel</a>
                <a href="{{ route('admin.forum') }}" class="hover:text-orange-600">Forum</a>
            </nav>
            <div class="md:hidden">
                <button id="toggleMenu"><i class="fas fa-bars text-xl"></i></button>
            </div>
        </div>
    </header>
    <main class="pt-28">
        @yield('content')
    </main>
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

</body>
</html>
