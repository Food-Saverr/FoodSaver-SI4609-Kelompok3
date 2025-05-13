<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
{
    // Tampilkan daftar dengan search & filter kategori
    public function index(Request $request)
    {
        $query = Artikel::query();

        if ($search = $request->input('search')) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('konten', 'like', "%{$search}%");
        }

        if ($kategori = $request->input('kategori')) {
            $query->where('kategori', $kategori);
        }

        $artikels = $query->orderBy('created_at', 'desc')->paginate(9)->withQueryString();

        // Ambil semua kategori unik untuk dropdown
        $categories = Artikel::select('kategori')->distinct()->pluck('kategori');

        return view('artikels.index', compact('artikels', 'categories'));
    }

    // Tampilkan halaman detail berdasarkan slug
    public function show(string $slug)
    {
        $artikel = Artikel::where('slug', $slug)->firstOrFail();
        return view('artikels.show', compact('artikel'));
    }

    // Toggle like (auth middleware)
    public function like(int $id)
    {
        $artikel = Artikel::findOrFail($id);
        $user = Auth::user();

        if ($artikel->likedBy()->where('user_id', $user->id)->exists()) {
            $artikel->likedBy()->detach($user->id);
        } else {
            $artikel->likedBy()->attach($user->id);
        }

        return back()->with('success', 'Your like has been updated.');
    }
}