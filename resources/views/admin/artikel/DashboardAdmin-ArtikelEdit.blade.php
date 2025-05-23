@extends('layouts.appadmin')

@section('title', 'Edit Artikel - FoodSaver')

@section('content')
<section class="pt-24 pb-8">
  <div class="container mx-auto px-4 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Edit Artikel</h1>

    @if($errors->any())
      <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.artikel.update', $artikel->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
      @csrf
      @method('PUT')

      {{-- Judul --}}
      <div>
        <label class="block mb-1 font-medium">Judul</label>
        <input
          type="text"
          name="judul"
          value="{{ old('judul', $artikel->judul) }}"
          required
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
        />
      </div>

      {{-- Konten --}}
      <div>
        <label class="block mb-1 font-medium">Konten</label>
        <textarea
          name="konten"
          rows="6"
          required
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
        >{{ old('konten', $artikel->konten) }}</textarea>
      </div>

      {{-- Gambar --}}
      <div>
        <label class="block mb-1 font-medium">Gambar (opsional)</label>
        @if($artikel->gambar)
          <div class="mb-2">
            <img
              src="{{ asset('storage/'.$artikel->gambar) }}"
              alt="Current image" accept="image/*"
              class="h-32 object-cover rounded"
            />
          </div>
        @endif
        <input
          type="file"
          name="gambar"
          class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                 file:rounded-lg file:border-0
                 file:text-sm file:font-semibold
                 file:bg-gray-100 file:text-gray-700
                 hover:file:bg-gray-200"
        />
      </div>

      {{-- Actions --}}
      <div class="flex justify-end space-x-3">
        <a
          href="{{ route('admin.artikel.index') }}"
          class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition"
        >
          Batal
        </a>
        <button
          type="submit"
          class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
        >
          Update Artikel
        </button>
      </div>
    </form>
  </div>
</section>
@endsection
