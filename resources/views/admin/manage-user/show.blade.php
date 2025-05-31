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
                        <td class="py-3 px-4 text-left">{{ $user->Nama_Pengguna }}</td> <!-- Corrected $pengguna to $user -->
                        <td class="py-3 px-4 text-left">{{ $user->Email_Pengguna }}</td> <!-- Corrected $pengguna to $user -->
                        <td class="py-3 px-4 text-left">{{ $user->Role_Pengguna }}</td> <!-- Corrected $pengguna to $user -->
                        <td class="py-3 px-4 text-left">
                            <!-- Form untuk Mengubah Status Akun -->
                            <form action="{{ route('admin.manage-user.update-status', $user->id_user) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <select name="is_active" class="px-4 py-1 border rounded-md" onchange="this.form.submit()">
                                    <option value="1" {{ $user->is_active == 1 ? 'selected' : '' }}>Aktif</option> <!-- Corrected $pengguna to $user -->
                                    <option value="0" {{ $user->is_active == 0 ? 'selected' : '' }}>Nonaktif</option> <!-- Corrected $pengguna to $user -->
                                </select>
                            </form>
                        </td>
                        <td class="py-3 px-4 text-left">
                            <!-- Tombol Lihat -->
                            <a href="{{ route('admin.manage-user.show', $user->id_user) }}" class="text-blue-500 hover:text-blue-700 transition px-2 py-1 rounded-lg hover:bg-blue-50">
                                <i class="fas fa-eye"></i> <!-- Simbol Lihat -->
                            </a>

                            <!-- Tombol Edit -->
                            <a href="{{ route('admin.manage-user.edit', $user->id_user) }}" class="text-green-500 hover:text-green-700 transition px-2 py-1 rounded-lg hover:bg-green-50">
                                <i class="fas fa-edit"></i> <!-- Simbol Edit -->
                            </a>

                            <!-- Tombol Hapus Akun -->
                            <button onclick="openModal({{ $user->id_user }})" class="text-red-500 hover:text-red-700 transition px-2 py-1 rounded-lg hover:bg-red-50">
                                <i class="fas fa-trash"></i> <!-- Simbol Hapus -->
                            </button>
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
            <form action="" method="POST" id="delete-account-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition animate-scale shadow">
                    Hapus Akun
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk membuka modal
    function openModal(userId) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('delete-account-form').action = '/admin/manage-user/' + userId;
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
