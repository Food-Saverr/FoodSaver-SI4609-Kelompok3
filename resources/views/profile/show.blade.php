@extends(Auth::user()->Role_Pengguna == 'Donatur' ? 'layouts.appdonatur' : 'layouts.app') <!-- Tentukan layout yang tepat -->

@section('title', 'Profil ' . Auth::user()->Nama_Pengguna)

@section('content')
<div class="max-w-3xl mx-auto px-6 py-8 bg-white shadow-lg rounded-xl mt-16">
    <h2 class="text-3xl font-bold text-center text-orange-600 mb-6">Profil {{ Auth::user()->Role_Pengguna }}</h2>

    <!-- Menampilkan Pesan Sukses -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <!-- Foto Profil -->
    <div class="flex justify-center mb-6">
        @if(Auth::user()->foto)
            <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Foto Profil" class="w-32 h-32 rounded-full object-cover border-4 border-orange-500 shadow-xl">
        @else
            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-3xl text-orange-500 border-4 border-orange-500 shadow-xl">
                <i class="fas fa-user-circle"></i>
            </div>
        @endif
    </div>

    <!-- Informasi Pengguna -->
    <div class="space-y-6">
        <div class="bg-gray-50 p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <p class="mt-1 text-gray-900 font-semibold">{{ Auth::user()->Nama_Pengguna }}</p>
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="mt-1 text-gray-900 font-semibold">{{ Auth::user()->Email_Pengguna }}</p>
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
            <!-- Alamat -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <p class="mt-1 text-gray-900 font-semibold">{{ Auth::user()->Alamat_Pengguna }}</p>
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
            <!-- Peran -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Peran</label>
                <p class="mt-1 text-gray-900 font-semibold">{{ Auth::user()->Role_Pengguna }}</p>
            </div>
        </div>
    </div>

    <!-- Tombol Edit dan Kembali -->
    <div class="mt-8 grid grid-cols-2 gap-4">
        <a href="{{ route(Auth::user()->Role_Pengguna == 'Donatur' ? 'dashboard.donatur' : 'dashboard.pengguna') }}" class="py-3 bg-gray-300 text-gray-700 text-lg font-semibold rounded-md hover:bg-gray-400 transition duration-300 text-center">
            Kembali ke Dashboard
        </a>
        <a href="{{ route('profile.edit') }}" class="py-3 bg-orange-600 text-white text-lg font-semibold rounded-md hover:bg-orange-700 transition duration-300 text-center">
            Edit Profile
        </a>
    </div>

    <!-- Tombol Hapus Akun -->
    <div class="mt-8 grid grid-cols-1 gap-4">
        <button onclick="openModal()" class="py-3 bg-red-600 text-white text-lg font-semibold rounded-md hover:bg-red-700 transition duration-300 w-full text-center">
            Hapus Akun
        </button>
    </div>

    <!-- Modal Konfirmasi Hapus Akun -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h3 class="text-xl font-bold text-red-600 mb-4">Konfirmasi Hapus Akun</h3>
            <p class="mb-4 text-gray-700">Anda yakin ingin menghapus akun Anda? Semua data akan hilang dan tidak dapat dipulihkan.</p>

            <div class="flex justify-between">
                <!-- Tombol Batal -->
                <button onclick="closeModal()" class="py-2 px-4 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                    Batal
                </button>

                <!-- Tombol Hapus Akun -->
                <form action="{{ route('profile.delete') }}" method="POST" id="delete-account-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="py-2 px-4 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
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
