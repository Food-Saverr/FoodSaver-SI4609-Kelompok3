@extends('layouts.appadmin')

@section('title', 'Tambah Artikel Baru - FoodSaver')

@section('content')
<section class="pt-24 pb-8">
  <div class="container mx-auto px-4 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Tambah Artikel Baru</h1>

    @if($errors->any())
      <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <div>
        <label class="block mb-1 font-medium">Judul</label>
        <input type="text" name="judul" value="{{ old('judul') }}" required
               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>

      <div>
        <label class="block mb-1 font-medium">Konten</label>
        <textarea name="konten" rows="6" required
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('konten') }}</textarea>
      </div>

      <div>
        <label class="block mb-1 font-medium">Gambar (opsional)</label>
        <input type="file" name="gambar" accept="image/*"
               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                      file:rounded-lg file:border-0
                      file:text-sm file:font-semibold
                      file:bg-gray-100 file:text-gray-700
                      hover:file:bg-gray-200"/>
      </div>

      <div class="flex justify-end">
        <a href="{{ route('admin.artikel.index') }}"
           class="mr-3 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</a>
        <button type="submit"
                class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
          Simpan
        </button>
      </div>
    </form>
  </div>
</section>
@endsection
