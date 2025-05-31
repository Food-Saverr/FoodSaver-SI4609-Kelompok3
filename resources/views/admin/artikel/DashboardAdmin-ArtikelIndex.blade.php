@extends('layouts.appadmin')

@section('title', 'Dashboard Artikel Admin - FoodSaver')

@section('content')
<section class="pt-24 pb-8 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Kelola Artikel</h1>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="mb-6">
            <a href="{{ route('admin.artikel.create') }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-plus mr-2"></i> Tambah Artikel
            </a>
        </div>

        {{-- Tabel Daftar Artikel --}}
        <div class="bg-white shadow rounded-lg overflow-x-auto mt-[100px]">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Judul</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Penulis</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Likes</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($artikels as $artikel)
                        <tr>
                            {{-- Judul --}}
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.artikel.edit', $artikel->id) }}"
                                   class="hover:underline text-orange-600">
                                    {{ Str::limit($artikel->judul, 50) }}
                                </a>
                            </td>

                            {{-- Penulis --}}
                            <td class="px-4 py-2">
                                {{ optional($artikel->user)->Nama_Pengguna ?? '—' }}
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-4 py-2 text-center">
                                {{ \Carbon\Carbon::parse($artikel->created_at)->translatedFormat('d M Y') }}
                            </td>

                            {{-- Likes --}}
                            <td class="px-4 py-2 text-center">
                                {{ $artikel->like_count }}
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-2 text-center space-x-2">
                                <a href="{{ route('admin.artikel.edit', $artikel->id) }}"
                                   class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-medium rounded-lg hover:bg-blue-600 transition">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>

                                <form action="{{ route('admin.artikel.destroy', $artikel->id) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs font-medium rounded-lg hover:bg-red-600 transition">
                                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                Belum ada artikel yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $artikels->links() }}
        </div>
    </div>
</section>
@endsection
