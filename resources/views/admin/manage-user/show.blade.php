@extends('layouts.appadmin')

@section('title', 'Daftar Pengguna - FoodSaver')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
    <div class="bg-white/70 backdrop-blur-xl rounded-2xl p-8 custom-shadow">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Daftar Pengguna</h1>
            <p class="text-gray-500">Kelola daftar pengguna yang dapat mengakses platform ini</p>
        </div>        

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

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl overflow-hidden">
                <thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Nama Pengguna</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-left">Role</th>
                        <th class="py-3 px-4 text-left">Status Akun</th>
                        <th class="py-3 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pengguna as $user)
                    <tr>
                        <td class="py-3 px-4 text-left">{{ $user->Nama_Pengguna }}</td>
                        <td class="py-3 px-4 text-left">{{ $user->Email_Pengguna }}</td>
                        <td class="py-3 px-4 text-left">{{ $user->Role_Pengguna }}</td>
                        <td class="py-3 px-4 text-left">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="py-3 px-4 text-left">
                            <!-- Tombol Lihat -->
                            <a href="{{ route('admin.manage-user.show', $user->id_user) }}" class="text-blue-500 hover:text-blue-700 transition px-2 py-1 rounded-lg hover:bg-blue-50">
                                <i class="fas fa-eye"></i> <!-- Simbol Lihat -->
                            </a>

                            <!-- Tombol Edit -->
                            <a href="{{ route('admin.manage-user.edit', $user->id_user) }}" class="text-green-500 hover:text-green-700 transition px-2 py-1 rounded-lg hover:bg-green-50">
                                <i class="fas fa-edit"></i> <!-- Simbol Edit -->
                            </a>

                            <!-- Form untuk Hapus Pengguna -->
                            <form action="{{ route('admin.manage-user.destroy', $user->id_user) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition px-2 py-1 rounded-lg hover:bg-red-50">
                                    <i class="fas fa-trash"></i> <!-- Simbol Hapus -->
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>

                <!-- Menampilkan pagination -->
                <div class="mt-4">
                    {{ $pengguna->links() }} <!-- Pagination links -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
