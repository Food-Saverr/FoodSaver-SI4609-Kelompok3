<!-- resources/views/admin/pengguna.blade.php -->

@extends('layouts.appadmin')

@section('title', 'Daftar Pengguna - FoodSaver')

@section('content')
<section class="pt-20 pb-16 bg-gradient-to-br from-orange-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold title-font gradient-text animate-fade-up">
                Daftar Pengguna
            </h1>
            <p class="text-gray-600 mt-2 animate-fade-up-delay">
                Pantau semua pengguna yang terdaftar di platform <span class="font-semibold text-orange-600">FoodSaver</span>.
            </p>
        </div>

        <!-- Table to display users -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full table-auto text-left">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-3 px-6">Nama</th>
                        <th class="py-3 px-6">Email</th>
                        <th class="py-3 px-6">Jenis Pengguna</th>
                        <th class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengguna as $user)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="py-3 px-6">{{ $user->Nama_Pengguna }}</td>
                        <td class="py-3 px-6">{{ $user->Email_Pengguna }}</td>
                        <td class="py-3 px-6">
                            @if($user->Role_Pengguna === 'Donatur')
                            <span class="text-blue-600">Donatur</span>
                            @else
                            <span class="text-green-600">Penerima</span>
                            @endif
                        </td>
                        <td class="py-3 px-6">
                            <!-- Lihat Detail -->
                            <a href="#" class="btn btn-info">Lihat Detail</a>

                            <!-- Edit Pengguna -->
                            <a href="#" class="py-2 px-4 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-medium transition animate-scale shadow">
                                <i class="fas fa-edit mr-2"></i>Edit</a>
                            
                            <!-- Hapus Pengguna -->
                            <form action="#" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>

                            <!-- Nonaktifkan Pengguna -->
                            @if($user->is_active)
                                <a href="#" class="btn btn-secondary">Nonaktifkan</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
