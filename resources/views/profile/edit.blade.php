@extends(Auth::user()->Role_Pengguna == 'Donatur' ? 'layouts.appdonatur' : 'layouts.app') <!-- Tentukan layout berdasarkan role -->

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-8 bg-white shadow-lg rounded-xl mt-16">
    <h2 class="text-3xl font-bold text-center text-orange-600 mb-6">Edit Profil Saya</h2>

    <!-- Menampilkan pesan kesalahan jika ada -->
    @if($errors->any())
        <div class="bg-red-500 text-white p-4 mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Pesan sukses jika profil berhasil diperbarui -->
    @if(session('success'))
        <div class="mb-4 text-green-500">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama Lengkap -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-lg mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="Nama_Pengguna" value="{{ old('Nama_Pengguna', $user->Nama_Pengguna) }}" class="w-full p-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500" required>
        </div>

        <!-- Email -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-lg mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="Email_Pengguna" value="{{ old('Email_Pengguna', $user->Email_Pengguna) }}" class="w-full p-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500" required>
        </div>

        <!-- Alamat -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-lg mb-4">
            <label class="block text-sm font-medium text-gray-700">Alamat</label>
            <textarea name="Alamat_Pengguna" rows="4" class="w-full p-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500" required>{{ old('Alamat_Pengguna', $user->Alamat_Pengguna) }}</textarea>
        </div>

        <!-- Dropdown untuk Edit Password -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-lg mb-6">
            <button type="button" class="flex items-center justify-between w-full text-left font-medium text-gray-700 hover:text-orange-600" onclick="toggleAccordion('password-section')">
                <span>Edit Password</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rotate-0 transition-transform duration-300" id="password-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="password-section" class="accordion-content hidden mt-4 transition-all duration-300">
                <div class="mb-4">
                    <label for="old_password" class="block text-sm font-medium text-gray-700">Password Lama</label>
                    <input type="password" name="old_password" class="mt-2 w-full p-2 border border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input type="password" name="new_password" class="mt-2 w-full p-2 border border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="mt-2 w-full p-2 border border-gray-300 rounded-md">
                </div>
            </div>
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full py-3 bg-orange-600 text-white font-semibold rounded-md hover:bg-orange-700 transition duration-300">
                Simpan Perubahan
            </button>
        </div>
    </form>

    <div class="mt-4">
        <a href="{{ route('profile.show') }}" class="py-3 text-lg text-gray-700 font-semibold hover:text-gray-600 transition duration-300 text-center block">
            Kembali ke Profil
        </a>
    </div>
</div>

<script>
    // Toggle visibility of accordion content
    function toggleAccordion(sectionId) {
        const section = document.getElementById(sectionId);
        const icon = section.previousElementSibling.querySelector('svg');
        
        // Toggle content visibility
        section.classList.toggle('hidden');

        // Rotate the icon when the section is opened/closed
        icon.classList.toggle('rotate-180');
    }
</script>

@endsection