@extends('layouts.appadmin')

@section('title', 'Detail Pengguna - FoodSaver')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="max-w-4xl mx-auto">
        <!-- Navigasi -->
        <a href="{{ route('admin.manage-user.index') }}" class="text-sm text-orange-500 flex items-center hover:text-orange-700 transition-colors group mb-4">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
            Kembali ke Daftar Pengguna
        </a>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg animate-fade-up-delay">
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

        <!-- Detail Pengguna -->
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">
                    {{ $pengguna->Nama_Pengguna }}
                </h1>

                <div class="flex space-x-2 mt-4 md:mt-0">
                    <form action="{{ route('admin.manage-user.destroy', $pengguna->id_user) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition animate-scale shadow">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>

                    <a href="{{ route('admin.manage-user.edit', $pengguna->id_user) }}" class="py-2 px-4 bg-green-500 text-white rounded-xl hover:bg-green-600 font-medium transition animate-scale shadow">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                </div>
            </div>

            <!-- Detail Informasi Pengguna -->
            <div class="space-y-6">
                <!-- Nama Pengguna -->
                <div class="p-4 bg-blue-50 rounded-xl">
                    <h3 class="text-sm font-medium text-blue-500 mb-1">Nama</h3>
                    <p class="font-medium text-gray-800">{{ $pengguna->Nama_Pengguna }}</p>
                </div>

                <!-- Email Pengguna -->
                <div class="p-4 bg-indigo-50 rounded-xl">
                    <h3 class="text-sm font-medium text-indigo-500 mb-1">Email</h3>
                    <p class="font-medium text-gray-800">{{ $pengguna->Email_Pengguna }}</p>
                </div>

                <!-- Role Pengguna -->
                <div class="p-4 bg-green-50 rounded-xl">
                    <h3 class="text-sm font-medium text-green-500 mb-1">Role</h3>
                    <p class="font-medium text-gray-800">{{ $pengguna->Role_Pengguna }}</p>
                </div>

                <!-- Status Pengguna -->
                <div class="p-4 bg-yellow-50 rounded-xl">
                    <h3 class="text-sm font-medium text-yellow-500 mb-1">Status Akun</h3>
                    <p class="font-medium text-gray-800">{{ $pengguna->is_active ? 'Aktif' : 'Nonaktif' }}</p>
                </div>
            </div>

            <!-- Timeline Status -->
            <div class="p-6 bg-gray-50 rounded-xl">
                <h3 class="text-lg font-bold mb-4">Riwayat Perubahan</h3>
                <div class="relative">
                    <!-- Garis Timeline -->
                    <div class="absolute h-full w-0.5 bg-gray-200 left-6 top-0"></div>

                    <!-- Status Item -->
                    <div class="relative flex items-start mb-4 pl-16">
                        <div class="absolute left-0 rounded-full w-12 h-12 flex items-center justify-center {{ $pengguna->created_at ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                            <i class="fas fa-plus-circle text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-medium">Ditambahkan</h4>
                            <p class="text-sm text-gray-500">
                                {{ $pengguna->created_at ? $pengguna->created_at->format('d M Y, H:i') : 'Tidak tercatat' }}
                            </p>
                        </div>
                    </div>

                    <!-- Status Item -->
                    <div class="relative flex items-start mb-4 pl-16">
                        <div class="absolute left-0 rounded-full w-12 h-12 flex items-center justify-center {{ $pengguna->updated_at && $pengguna->updated_at->gt($pengguna->created_at) ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-400' }}">
                            <i class="fas fa-edit text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-medium">Terakhir Diperbarui</h4>
                            <p class="text-sm text-gray-500">
                                {{ $pengguna->updated_at && $pengguna->updated_at->gt($pengguna->created_at) ? $pengguna->updated_at->format('d M Y, H:i') : 'Belum diperbarui' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Commit Ulang -->