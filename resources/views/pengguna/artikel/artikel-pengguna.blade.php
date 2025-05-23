@extends('layouts.app')

@section('title', 'Artikel - FoodSaver')

@section('content')
<div class="container mx-auto px-4 py-8 pt-28">
  {{-- Search Bar --}}
  <form method="GET" action="{{ route('artikel.pengguna') }}" class="mb-8">
    <div class="relative max-w-md mx-auto">
      <input
        type="text"
        name="q"
        value="{{ request('q') }}"
        placeholder="Cari artikel..."
        class="w-full pl-4 pr-12 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-400"
      />
      <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-orange-600">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </form>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($artikels as $artikel)
      <div class="bg-white rounded-2xl p-4 custom-shadow animate-fade-up">
        {{-- Gambar --}}
        @if($artikel->gambar)
          <a href="{{ route('artikels.show', $artikel->slug) }}">
            <img
              src="{{ asset('storage/'.$artikel->gambar) }}"
              alt="{{ $artikel->judul }}"
              class="h-40 w-full object-cover rounded-lg mb-4"
            />
          </a>
        @endif

        {{-- Judul --}}
        <h3 class="text-lg font-semibold text-gray-800 mb-2">
          <a href="{{ route('artikels.show', $artikel->slug) }}" class="hover:underline">
            {{ Str::limit($artikel->judul, 60) }}
          </a>
        </h3>

        {{-- Like Button & Count --}}
        <form action="{{ route('artikels.toggleLike', $artikel) }}" method="POST" class="flex items-center space-x-2">
          @csrf
          <button type="submit" class="inline-flex items-center">
            @if(auth()->check() && auth()->user()->likedArtikels->contains($artikel->id))
              <i class="fas fa-heart text-red-500"></i>
            @else
              <i class="far fa-heart text-gray-400 hover:text-red-500 transition"></i>
            @endif
          </button>
          <span class="text-gray-600 text-sm">{{ $artikel->like_count }}</span>
        </form>
      </div>
    @empty
      <p class="col-span-3 text-center text-gray-500">
        Belum ada artikel yang dapat ditampilkan.
      </p>
    @endforelse
  </div>

  <div class="mt-8">
    {{ $artikels->withQueryString()->links() }}
  </div>
</div>

<style>
  .custom-shadow {
    box-shadow: 0 10px 40px -10px rgba(0,0,0,0.1), 0 3px 20px -5px rgba(0,0,0,0.1);
  }
  .animate-fade-up {
    opacity: 0;
    animation: fadeUp 0.8s forwards ease-out;
  }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
  }
</style>
@endsection