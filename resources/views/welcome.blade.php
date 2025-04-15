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
      <img src="/FoodSaver (3).png" alt="FoodSaver Logo" class="h-10 md:h-12 w-auto" />
      <nav class="hidden md:flex items-center space-x-6">
        <a href="#features" class="text-white hover:text-orange-200 transition-colors">About</a>
        <a href="#testimoni" class="text-white hover:text-orange-200 transition-colors">Testimoni</a>
        <a href="#faq" class="text-white hover:text-orange-200 transition-colors">FAQ</a>
        <a href="#kontak" class="text-white hover:text-orange-200 transition-colors">Kontak</a>
        <a href="/login" class="bg-white text-orange-600 px-4 py-2 rounded-full font-semibold hover:bg-orange-100 transition animate-scale">Login</a>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="relative h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-4.0.3&auto=format&fit=crop&w=934&q=80');">
    <!-- Overlay Gradien -->
    <div class="absolute inset-0 bg-gradient-to-br from-amber-900/85 via-orange-800/75 to-gray-900/90 z-10"></div>
    <!-- Pola Hero -->
    <div class="absolute inset-0 hero-pattern z-20 opacity-20"></div>
    
    <!-- Konten -->
    <div class="container mx-auto px-6 text-center relative z-30 text-white">
      <img src="/FoodSaver (3).png" alt="FoodSaver Logo" class="w-36 md:w-56 mx-auto mb-10 floating drop-shadow-2xl transition-all duration-500 hover:scale-110 hover:drop-shadow-[0_0_15px_rgba(255,191,0,0.8)]" />
      <h1 class="title-font text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 animate-fade-up leading-tight tracking-tight">
        Selamatkan Makanan,<br>Selamatkan Dunia
      </h1>
      <p class="text-lg md:text-xl lg:text-2xl text-amber-100 max-w-3xl mx-auto mb-10 animate-fade-up-delay leading-relaxed">
        Bergabunglah dengan FoodSaver untuk mengurangi limbah makanan dan berbagi kebaikan demi masa depan yang lebih hijau.
      </p>
      <a href="/registrasi" class="inline-block bg-white text-orange-800 px-10 py-4 rounded-xl font-semibold text-lg md:text-xl lg:text-2xl hover:bg-amber-100 hover:text-orange-900 transition-all duration-300 animate-scale shadow-lg shadow-amber-300/50 hover:shadow-amber-400/70">
        <i class="fas fa-hand-holding-heart mr-2"></i> Gabung Sekarang
      </a>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-24 bg-gradient-to-b from-white to-orange-50">
    <div class="container mx-auto px-6 md:px-12 lg:px-20">
      <h2 class="text-3xl md:text-4xl title-font font-extrabold text-center gradient-text mb-20 animate-fade-up">Mengapa FoodSaver?</h2>
      <div class="grid gap-10 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl custom-shadow animate-fade-up animate-scale">
          <div class="w-12 h-12 bg-orange-600/60 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-utensils text-white"></i>
          </div>
          <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">Hemat & Berbagi</h3>
          <p class="text-center text-gray-600 text-sm">Makanan berlebih dapat didistribusikan ke pihak yang membutuhkan, bantu kurangi limbah.</p>
        </div>
        <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl custom-shadow animate-fade-up animate-scale" style="animation-delay: 0.1s;">
          <div class="w-12 h-12 bg-orange-600/60 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-recycle text-white"></i>
          </div>
          <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">Kurangi Pemborosan</h3>
          <p class="text-center text-gray-600 text-sm">Minimalkan limbah makanan dengan distribusi makanan yang masih layak konsumsi.</p>
        </div>
        <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl custom-shadow animate-fade-up animate-scale" style="animation-delay: 0.2s;">
          <div class="w-12 h-12 bg-orange-600/60 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-users text-white"></i>
          </div>
          <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">Komunitas Peduli</h3>
          <p class="text-center text-gray-600 text-sm">Bergabung dengan komunitas yang aktif dan peduli dalam distribusi makanan.</p>
        </div>
        <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl custom-shadow animate-fade-up animate-scale" style="animation-delay: 0.3s;">
          <div class="w-12 h-12 bg-orange-600/60 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-map-marker-alt text-white"></i>
          </div>
          <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">Akses Pangan Terdekat</h3>
          <p class="text-center text-gray-600 text-sm">Temukan makanan donasi di sekitar Anda dengan mudah dan cepat.</p>
        </div>
        <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl custom-shadow animate-fade-up animate-scale" style="animation-delay: 0.4s;">
          <div class="w-12 h-12 bg-orange-600/60 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-book-open text-white"></i>
          </div>
          <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">Edukasi Konsumsi</h3>
          <p class="text-center text-gray-600 text-sm">Dapatkan info & tips konsumsi bertanggung jawab melalui artikel bermanfaat.</p>
        </div>
        <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl custom-shadow animate-fade-up animate-scale" style="animation-delay: 0.5s;">
          <div class="w-12 h-12 bg-orange-600/60 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-bell text-white"></i>
          </div>
          <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">Notifikasi Cepat</h3>
          <p class="text-center text-gray-600 text-sm">Sistem notifikasi dan konfirmasi donasi yang cepat, nyaman, dan real-time.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimoni Section -->
  <section id="testimoni" class="py-20 bg-gradient-to-b from-orange-50 to-white overflow-hidden">
    <div class="container mx-auto px-6 md:px-12 lg:px-20">
      <!-- Heading dan Deskripsi -->
      <div class="max-w-2xl mx-auto text-center mb-24">
        <h2 class="text-3xl md:text-4xl title-font font-extrabold gradient-text mb-4 animate-fade-up">
          Apa Kata Mereka?
        </h2>
        <p class="text-gray-600 md:text-lg leading-relaxed animate-fade-up-delay">
          Dengar cerita inspiratif dari pengguna FoodSaver tentang bagaimana platform ini membantu mengurangi pemborosan makanan dan mendukung komunitas.
        </p>
      </div>

      <!-- Grid Testimoni -->
      <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <!-- Testimoni 1 -->
        <div class="relative bg-white/80 backdrop-blur-xl p-6 rounded-3xl custom-shadow animate-fade-up animate-scale transition-all duration-300 hover:-translate-y-2">
          <div class="absolute -top-12 left-1/2 transform -translate-x-1/2">
            <img src="/vQTwQU1f_400x400.jpeg" alt="Avatar Rina" class="w-20 h-20 md:w-24 md:h-24 rounded-full border-4 border-orange-500 shadow-lg object-cover">
          </div>
          <div class="mt-12 text-center">
            <p class="text-gray-600 italic text-sm md:text-base leading-relaxed">"FoodSaver mengubah cara saya mendistribusikan makanan berlebih. Semuanya jadi lebih mudah dan cepat."</p>
            <h4 class="mt-4 font-semibold text-base md:text-lg gradient-text">Rina, Ibu Rumah Tangga</h4>
            <div class="flex justify-center mt-3 space-x-1">
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
            </div>
          </div>
        </div>

        <!-- Testimoni 2 -->
        <div class="relative bg-white/80 backdrop-blur-xl p-6 rounded-3xl custom-shadow animate-fade-up animate-scale transition-all duration-300 hover:-translate-y-2" style="animation-delay: 0.1s;">
          <div class="absolute -top-12 left-1/2 transform -translate-x-1/2">
            <img src="/Inline_01_Left_HoosFirst-39.jpg" alt="Avatar Budi" class="w-20 h-20 md:w-24 md:h-24 rounded-full border-4 border-orange-500 shadow-lg object-cover">
          </div>
          <div class="mt-12 text-center">
            <p class="text-gray-600 italic text-sm md:text-base leading-relaxed">"Dengan FoodSaver, mendonasikan makanan jadi praktis dan terpercaya. Saya merasa lebih dekat dengan komunitas."</p>
            <h4 class="mt-4 font-semibold text-base md:text-lg gradient-text">Budi, Mahasiswa</h4>
            <div class="flex justify-center mt-3 space-x-1">
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
            </div>
          </div>
        </div>

        <!-- Testimoni 3 -->
        <div class="relative bg-white/80 backdrop-blur-xl p-6 rounded-3xl custom-shadow animate-fade-up animate-scale transition-all duration-300 hover:-translate-y-2" style="animation-delay: 0.2s;">
          <div class="absolute -top-12 left-1/2 transform -translate-x-1/2">
            <img src="/Profile Picture.jpg" alt="Avatar Maya" class="w-20 h-20 md:w-24 md:h-24 rounded-full border-4 border-orange-500 shadow-lg object-cover">
          </div>
          <div class="mt-12 text-center">
            <p class="text-gray-600 italic text-sm md:text-base leading-relaxed">"FoodSaver membuat saya merasa berguna dengan memudahkan donasi makanan kepada yang membutuhkan."</p>
            <h4 class="mt-4 font-semibold text-base md:text-lg gradient-text">Maya, Relawan</h4>
            <div class="flex justify-center mt-3 space-x-1">
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
              <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="py-20 bg-gradient-to-b from-white to-gray-50 overflow-hidden">
    <div class="container mx-auto px-6 md:px-12 lg:px-20">
      <!-- Heading -->
      <div class="max-w-2xl mx-auto text-center mb-16">
        <h2 class="text-3xl md:text-4xl title-font font-extrabold gradient-text mb-4 animate-fade-up">
          Pertanyaan Umum
        </h2>
        <p class="text-gray-600 md:text-lg leading-relaxed animate-fade-up-delay">
          Temukan jawaban atas pertanyaan Anda tentang FoodSaver dan bagaimana kami membantu mengurangi pemborosan makanan.
        </p>
      </div>

      <!-- FAQ Items -->
      <div class="max-w-3xl mx-auto space-y-6">
        <!-- FAQ Item 1 -->
        <details class="group bg-white/80 backdrop-blur-xl p-6 rounded-2xl custom-shadow transition-all duration-300 hover:-translate-y-1 hover:shadow-lg animate-fade-up">
          <summary class="cursor-pointer text-lg md:text-xl font-semibold text-gray-800 flex items-center justify-between">
            <span>Apa itu FoodSaver?</span>
            <i class="fas fa-chevron-down text-orange-500 w-5 h-5 transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <p class="mt-3 text-gray-600 text-sm md:text-base leading-relaxed">
            FoodSaver adalah platform yang membantu mengurangi pemborosan makanan dengan mendistribusikan makanan berlebih ke pihak yang membutuhkan.
          </p>
        </details>

        <!-- FAQ Item 2 -->
        <details class="group bg-white/80 backdrop-blur-xl p-6 rounded-2xl custom-shadow transition-all duration-300 hover:-translate-y-1 hover:shadow-lg animate-fade-up" style="animation-delay: 0.1s;">
          <summary class="cursor-pointer text-lg md:text-xl font-semibold text-gray-800 flex items-center justify-between">
            <span>Bagaimana cara bergabung dengan FoodSaver?</span>
            <i class="fas fa-chevron-down text-orange-500 w-5 h-5 transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <p class="mt-3 text-gray-600 text-sm md:text-base leading-relaxed">
            Klik tombol "Gabung Sekarang" pada halaman utama dan lengkapi formulir pendaftaran dengan informasi yang valid.
          </p>
        </details>

        <!-- FAQ Item 3 -->
        <details class="group bg-white/80 backdrop-blur-xl p-6 rounded-2xl custom-shadow transition-all duration-300 hover:-translate-y-1 hover:shadow-lg animate-fade-up" style="animation-delay: 0.2s;">
          <summary class="cursor-pointer text-lg md:text-xl font-semibold text-gray-800 flex items-center justify-between">
            <span>Bagaimana cara mendonasikan makanan?</span>
            <i class="fas fa-chevron-down text-orange-500 w-5 h-5 transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <p class="mt-3 text-gray-600 text-sm md:text-base leading-relaxed">
            Setelah mendaftar, Anda bisa menambahkan stok makanan yang ingin didonasikan melalui dashboard dan menentukan lokasi serta jadwal pengambilan.
          </p>
        </details>

        <!-- FAQ Item 4 -->
        <details class="group bg-white/80 backdrop-blur-xl p-6 rounded-2xl custom-shadow transition-all duration-300 hover:-translate-y-1 hover:shadow-lg animate-fade-up" style="animation-delay: 0.3s;">
          <summary class="cursor-pointer text-lg md:text-xl font-semibold text-gray-800 flex items-center justify-between">
            <span>Apa saja keuntungan menggunakan FoodSaver?</span>
            <i class="fas fa-chevron-down text-orange-500 w-5 h-5 transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <p class="mt-3 text-gray-600 text-sm md:text-base leading-relaxed">
            Dengan FoodSaver, Anda membantu mengurangi pemborosan makanan, bergabung dengan komunitas peduli, dan menikmati layanan penyaluran yang cepat, terpercaya, serta terintegrasi.
          </p>
        </details>

        <!-- FAQ Item 5 -->
        <details class="group bg-white/80 backdrop-blur-xl p-6 rounded-2xl custom-shadow transition-all duration-300 hover:-translate-y-1 hover:shadow-lg animate-fade-up" style="animation-delay: 0.4s;">
          <summary class="cursor-pointer text-lg md:text-xl font-semibold text-gray-800 flex items-center justify-between">
            <span>Bagaimana keamanan data di FoodSaver?</span>
            <i class="fas fa-chevron-down text-orange-500 w-5 h-5 transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <p class="mt-3 text-gray-600 text-sm md:text-base leading-relaxed">
            FoodSaver menggunakan protokol keamanan dan enkripsi tingkat tinggi untuk menjaga kerahasiaan data pribadi dan transaksi pengguna.
          </p>
        </details>

        <!-- FAQ Item 6 -->
        <details class="group bg-white/80 backdrop-blur-xl p-6 rounded-2xl custom-shadow transition-all duration-300 hover:-translate-y-1 hover:shadow-lg animate-fade-up" style="animation-delay: 0.5s;">
          <summary class="cursor-pointer text-lg md:text-xl font-semibold text-gray-800 flex items-center justify-between">
            <span>Apakah FoodSaver tersedia di seluruh Indonesia?</span>
            <i class="fas fa-chevron-down text-orange-500 w-5 h-5 transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <p class="mt-3 text-gray-600 text-sm md:text-base leading-relaxed">
            Saat ini FoodSaver telah hadir di beberapa kota besar dan terus berkembang untuk menjangkau wilayah Indonesia yang lebih luas.
          </p>
        </details>

        <!-- FAQ Item 7 -->
        <details class="group bg-white/80 backdrop-blur-xl p-6 rounded-2xl custom-shadow transition-all duration-300 hover:-translate-y-1 hover:shadow-lg animate-fade-up" style="animation-delay: 0.6s;">
          <summary class="cursor-pointer text-lg md:text-xl font-semibold text-gray-800 flex items-center justify-between">
            <span>Bagaimana jika saya mengalami masalah saat menggunakan platform?</span>
            <i class="fas fa-chevron-down text-orange-500 w-5 h-5 transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <p class="mt-3 text-gray-600 text-sm md:text-base leading-relaxed">
            Tim dukungan FoodSaver siap membantu 24/7. Silakan hubungi kami melalui halaman kontak untuk mendapatkan bantuan lebih lanjut.
          </p>
        </details>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="kontak" class="py-20 bg-orange-50">
    <div class="container mx-auto px-6 md:px-12 lg:px-20">
      <h2 class="text-3xl md:text-4xl title-font font-extrabold text-center gradient-text mb-16 animate-fade-up">Hubungi Kami</h2>
      <div class="max-w-2xl mx-auto bg-white/70 backdrop-blur-xl p-8 rounded-3xl custom-shadow animate-fade-up">
        <form class="space-y-6">
          <div>
            <label class="block mb-1 font-medium text-gray-700">Nama</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"><i class="far fa-user"></i></span>
              <input type="text" class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition" placeholder="Nama Anda">
            </div>
          </div>
          <div>
            <label class="block mb-1 font-medium text-gray-700">Email</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"><i class="far fa-envelope"></i></span>
              <input type="email" class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition" placeholder="email@anda.com">
            </div>
          </div>
          <div>
            <label class="block mb-1 font-medium text-gray-700">Pesan</label>
            <div class="relative">
              <span class="absolute top-3 left-0 flex items-start pl-4 text-gray-400"><i class="fas fa-comment"></i></span>
              <textarea class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 bg-white/90 focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition" rows="4" placeholder="Tulis pesan Anda..."></textarea>
            </div>
          </div>
          <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3.5 rounded-xl font-semibold hover:from-orange-600 hover:to-orange-700 transition animate-scale shadow-lg shadow-orange-200">Kirim Pesan</button>
        </form>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-20 bg-orange-500 relative hero-pattern">
      <div class="absolute inset-0 bg-orange-900/30"></div>
      <div class="container mx-auto px-6 text-center relative">
          <h2 class="text-4xl font-bold title-font text-white mb-8 animate-fade-up">
              Siap Membuat Perubahan?
          </h2>
          <a href="/registrasi" class="inline-block bg-white text-orange-600 px-8 py-4 rounded-xl text-lg font-semibold hover:bg-orange-50 animate-scale shadow-xl">
              Daftar Sekarang Gratis
          </a>
      </div>
  </section>

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
