@extends(
    Auth::user()->Role_Pengguna == 'Donatur' ? 'layouts.appdonatur' : (
        Auth::user()->Role_Pengguna == 'Admin' ? 'layouts.appadmin' : 'layouts.app')
)

@section('title', 'Profil ' . Auth::user()->Nama_Pengguna)

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-4xl mx-auto">
        <!-- Navigasi -->
        <a href="{{ route(Auth::user()->Role_Pengguna == 'Donatur' ? 'dashboard.donatur' : 'dashboard.pengguna') }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-4">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Dashboard
        </a>

        <!-- Menampilkan Pesan Sukses -->
        @if(session('success'))
            <div class="mb-6 mt-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg animate-fade-up-delay">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        

        <!-- Informasi Pengguna -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">
                    Profil {{ Auth::user()->Nama_Pengguna }}
                </h1>

                <div class="flex space-x-2 mt-4 md:mt-0">
                    <!-- Tombol Hapus Akun -->
                    <button onclick="openModal()" class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition animate-scale shadow">
                        <i class="fas fa-trash mr-2"></i> Hapus
                    </button>
                    <!-- Tombol Edit -->
                    <a href="{{ route('profile.edit') }}" class="py-2 px-4 bg-green-500 text-white rounded-xl hover:bg-green-600 font-medium transition animate-scale shadow">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                </div>
            </div>

            <!-- Detail Informasi Pengguna -->
            <div class="space-y-6">
                <!-- Nama Pengguna -->
                <div class="p-4 bg-blue-50 rounded-xl">
                    <h3 class="text-sm font-medium text-blue-500 mb-1">Nama Lengkap</h3>
                    <p class="font-medium text-gray-800">{{ Auth::user()->Nama_Pengguna }}</p>
                </div>

                <!-- Email Pengguna -->
                <div class="p-4 bg-indigo-50 rounded-xl">
                    <h3 class="text-sm font-medium text-indigo-500 mb-1">Email</h3>
                    <p class="font-medium text-gray-800">{{ Auth::user()->Email_Pengguna }}</p>
                </div>

                <!-- Alamat Pengguna -->
                <div class="p-4 bg-green-50 rounded-xl">
                    <h3 class="text-sm font-medium text-green-500 mb-1">Alamat</h3>
                    <p class="font-medium text-gray-800">{{ Auth::user()->Alamat_Pengguna }}</p>
                </div>

                <!-- Role Pengguna -->
                <div class="p-4 bg-yellow-50 rounded-xl">
                    <h3 class="text-sm font-medium text-yellow-500 mb-1">Role</h3>
                    <p class="font-medium text-gray-800">{{ Auth::user()->Role_Pengguna }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Akun -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h3 class="text-xl font-bold text-red-600 mb-4">Konfirmasi Hapus Akun</h3>
            <p class="mb-4 text-gray-700">Anda yakin ingin menghapus akun Anda? Semua data akan hilang dan tidak dapat dipulihkan.</p>

            <div class="flex justify-between">
                <!-- Tombol Batal -->
                <button onclick="closeModal()" class="py-2 px-4 bg-gray-500 hover:bg-gray-600 text-white rounded-xl font-medium transition animate-scale shadow">
                    Batal
                </button>

                <!-- Tombol Hapus Akun -->
                <form action="{{ route('profile.delete') }}" method="POST" id="delete-account-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="py-2 px-4 bg-red-600 text-white rounded-xl font-medium transition animate-scale shadow">
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
</script>
@endsection