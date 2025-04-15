<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $__env->yieldContent('title', 'FoodSaver - Selamatkan Makanan, Selamatkan Dunia'); ?></title>
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
            <a href="<?php echo e(route('dashboard.pengguna')); ?>" class="text-white hover:text-orange-200 transition-colors">Home</a>
            <a href="" class="text-white hover:text-orange-200 transition-colors">Food Listing</a>
            <a href="" class="text-white hover:text-orange-200 transition-colors">Forum</a>
            <a href="" class="text-white hover:text-orange-200 transition-colors">Artikel</a>
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login.form')); ?>" class="bg-white text-orange-600 px-4 py-2 rounded-full font-semibold hover:bg-orange-100 transition animate-scale">
                    Login
                </a>
            <?php endif; ?>
            <?php if(auth()->guard()->check()): ?>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-orange-200 font-semibold focus:outline-none">
                        <?php if(Auth::user()->foto): ?>
                            <img src="<?php echo e(asset('storage/' . Auth::user()->foto)); ?>" alt="Profile" class="w-8 h-8 rounded-full object-cover border-2 border-white">
                        <?php else: ?>
                            <i class="fas fa-user-circle text-2xl"></i>
                        <?php endif; ?>
                        <span><?php echo e(Auth::user()->Nama_Pengguna); ?></span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div 
                        x-show="open" 
                        @click.away="open = false"
                        x-transition 
                        class="absolute right-0 mt-2 w-48 bg-white text-orange-600 rounded-xl shadow-lg py-2 z-50"
                    >
                        <a href="" class="block px-4 py-2 hover:bg-orange-100">Lihat Profil</a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-orange-100">Logout</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-24 pb-10 px-4 container mx-auto">
        <?php echo $__env->yieldContent('content'); ?>
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
<?php /**PATH C:\Users\ahmad\Documents\Project\FoodSaver-SI4609-Kelompok3\resources\views/layouts/app.blade.php ENDPATH**/ ?>