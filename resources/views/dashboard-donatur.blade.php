<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FoodSaver - Selamatkan Makanan, Selamatkan Dunia</title>
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
    .navbar-scrolled {
      backdrop-filter: blur(8px);
      background-color: rgba(249, 115, 22, 0.95);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
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
      box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.1), 0 3px 20px -5px rgba(0, 0, 0, 0.1);
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
  <script>
    window.addEventListener('scroll', function() {
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
      <img src="{{ asset('FoodSaver (3).png') }}" alt="FoodSaver Logo" class="h-10 md:h-12 w-auto" />
      <nav class="hidden md:flex items-center space-x-6">
        <a href="#features" class="text-white hover:text-orange-200 transition-colors">About</a>
        <a href="#testimoni" class="text-white hover:text-orange-200 transition-colors">Testimoni</a>
        <a href="#faq" class="text-white hover:text-orange-200 transition-colors">FAQ</a>
        <a href="#kontak" class="text-white hover:text-orange-200 transition-colors">Kontak</a>

        @guest
          <a href="{{ route('login.form') }}" class="bg-white text-orange-600 px-4 py-2 rounded-full font-semibold hover:bg-orange-100 transition animate-scale">Login</a>
        @endguest

        @auth
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-white text-orange-600 px-4 py-2 rounded-full font-semibold hover:bg-orange-100 transition animate-scale">Logout</button>
          </form>
        @endauth
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="pt-28 md:pt-36 pb-16 bg-orange-500 bg-opacity-90 text-white text-center relative z-10">
    <div class="container mx-auto px-4">
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4 title-font">Selamatkan Makanan,<br />Selamatkan Dunia</h1>
      <p class="text-lg md:text-xl mb-6">Bergabunglah dengan FoodSaver untuk mengurangi limbah makanan dan berbagi kebaikan demi masa depan yang lebih hijau.</p>
      <a href="#daftar" class="bg-white text-orange-600 px-6 py-3 rounded-full font-semibold hover:bg-orange-100 transition animate-scale inline-flex items-center gap-2">
        <i class="fas fa-user-plus"></i> Gabung Sekarang
      </a>
    </div>
  </section>

</body>
</html>