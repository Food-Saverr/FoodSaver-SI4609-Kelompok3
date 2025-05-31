@extends(
    Auth::user()->Role_Pengguna == 'Donatur' ? 'layouts.appdonatur' : (
        Auth::user()->Role_Pengguna == 'Admin' ? 'layouts.appadmin' : 'layouts.app')
)

@section('title', 'Edit Profil')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-4xl mx-auto">
        <!-- Navigasi -->
        <a href="{{ route('profile.show') }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-4">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Profil
        </a>

                <!-- Menampilkan Pesan Kesalahan jika ada -->
        @if($errors->any())
            <div class="mb-6 mt-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg animate-fade-up-delay">
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

        <!-- Form Edit Profil -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">
                    Edit Profil
                </h1>

                <div class="flex space-x-2 mt-4 md:mt-0">
                    <!-- Tombol Hapus Akun -->
                    <button onclick="openModal()" class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition animate-scale shadow">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </div>
            </div>

            <!-- Edit Form -->
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <!-- Nama Pengguna -->
                    <div class="p-4 bg-blue-50 rounded-xl">
                        <h3 class="text-sm font-medium text-blue-500 mb-1">Nama Lengkap</h3>
                        <input type="text" name="Nama_Pengguna" value="{{ old('Nama_Pengguna', $user->Nama_Pengguna) }}" class="w-full px-4 py-2 border rounded-md">
                        @error('Nama_Pengguna')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Pengguna -->
                    <div class="p-4 bg-indigo-50 rounded-xl">
                        <h3 class="text-sm font-medium text-indigo-500 mb-1">Email</h3>
                        <input type="email" name="Email_Pengguna" value="{{ old('Email_Pengguna', $user->Email_Pengguna) }}" class="w-full px-4 py-2 border rounded-md">
                        @error('Email_Pengguna')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat Pengguna -->
                    <div class="p-4 bg-green-50 rounded-xl">
                        <h3 class="text-sm font-medium text-green-500 mb-1">Alamat</h3>
                        <textarea name="Alamat_Pengguna" rows="4" class="w-full px-4 py-2 border rounded-md">{{ old('Alamat_Pengguna', $user->Alamat_Pengguna) }}</textarea>
                        @error('Alamat_Pengguna')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>  

                    <!-- Dropdown untuk Edit Password -->
                    <div class="p-4 bg-yellow-50 rounded-xl">
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
                </div>

                <div class="mt-6">
                    <button type="submit" class="py-2 px-4 bg-green-500 text-white rounded-xl hover:bg-green-600 font-medium transition animate-scale shadow">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <a href="{{ route('profile.show') }}" class="py-2 px-4 bg-gray-500 text-white rounded-xl hover:bg-gray-600 font-medium transition animate-scale shadow">
                        <i class="fas fa-arrow-left mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Akun -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h3 class="text-xl font-bold text-red-600 mb-4">Konfirmasi Hapus Akun</h3>
            <p class="mb-4 text-gray-700">Anda yakin ingin menghapus akun ini? Semua data akan hilang dan tidak dapat dipulihkan.</p>

            <div class="flex justify-between">
                <!-- Tombol Batal -->
                <button onclick="closeModal()" class="py-2 px-4 bg-gray-500 hover:bg-gray-600 text-white rounded-xl font-medium transition animate-scale shadow">
                    Batal
                </button>

                <!-- Tombol Hapus Akun -->
                <form action="{{ route('profile.delete') }}" method="POST" id="delete-account-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition animate-scale shadow">
                        Hapus Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk membuka modal
    function openModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

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