@extends('layouts.appadmin')

@section('title', 'Edit Pengguna - FoodSaver')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-4xl mx-auto">
        <!-- Navigasi -->
        <a href="{{ route('admin.manage-user.index') }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-4">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Daftar Pengguna
        </a>

        <!-- Form Edit Pengguna -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">
                    Edit Pengguna
                </h1>

                <div class="flex space-x-2 mt-4 md:mt-0">
                    <!-- Tombol Hapus Akun -->
                    <button onclick="openModal()" class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition animate-scale shadow">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </div>
            </div>

            <!-- Edit Form -->
            <form action="{{ route('admin.manage-user.update', $pengguna->id_user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <!-- Nama Pengguna -->
                    <div class="p-4 bg-blue-50 rounded-xl">
                        <h3 class="text-sm font-medium text-blue-500 mb-1">Nama Pengguna</h3>
                        <input type="text" name="Nama_Pengguna" id="Nama_Pengguna" value="{{ old('Nama_Pengguna', $pengguna->Nama_Pengguna) }}" class="w-full px-4 py-2 border rounded-md">
                        @error('Nama_Pengguna')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Pengguna -->
                    <div class="p-4 bg-indigo-50 rounded-xl">
                        <h3 class="text-sm font-medium text-indigo-500 mb-1">Email</h3>
                        <input type="email" name="Email_Pengguna" id="Email_Pengguna" value="{{ old('Email_Pengguna', $pengguna->Email_Pengguna) }}" class="w-full px-4 py-2 border rounded-md">
                        @error('Email_Pengguna')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role Pengguna -->
                    <div class="p-4 bg-green-50 rounded-xl">
                        <h3 class="text-sm font-medium text-green-500 mb-1">Role Pengguna</h3>
                        <select name="Role_Pengguna" id="Role_Pengguna" class="w-full px-4 py-2 border rounded-md">
                            <option value="Admin" {{ $pengguna->Role_Pengguna == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Donatur" {{ $pengguna->Role_Pengguna == 'Donatur' ? 'selected' : '' }}>Donatur</option>
                            <option value="Pengguna" {{ $pengguna->Role_Pengguna == 'Pengguna' ? 'selected' : '' }}>Pengguna</option>
                        </select>
                        @error('Role_Pengguna')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Akun -->
                    <div class="p-4 bg-yellow-50 rounded-xl">
                        <h3 class="text-sm font-medium text-yellow-500 mb-1">Status Akun</h3>
                        <select name="is_active" id="is_active" class="w-full px-4 py-2 border rounded-md">
                            <option value="1" {{ $pengguna->is_active == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $pengguna->is_active == 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('is_active')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat Pengguna -->
                    <div class="p-4 bg-blue-50 rounded-xl">
                        <h3 class="text-sm font-medium text-blue-500 mb-1">Alamat Pengguna</h3>
                        <input type="text" name="Alamat_Pengguna" id="Alamat_Pengguna" value="{{ old('Alamat_Pengguna', $pengguna->Alamat_Pengguna) }}" class="w-full px-4 py-2 border rounded-md">
                        @error('Alamat_Pengguna')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>     
                                   
                </div>

                <div class="mt-6">
                    <button type="submit" class="py-2 px-4 bg-green-500 text-white rounded-xl hover:bg-green-600 font-medium transition animate-scale shadow">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.manage-user.show', $pengguna->id_user) }}" class="py-2 px-4 bg-gray-500 text-white rounded-xl hover:bg-gray-600 font-medium transition animate-scale shadow">
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
                <form action="{{ route('admin.manage-user.destroy', $pengguna->id_user) }}" method="POST" id="delete-account-form">
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
</script>
@endsection