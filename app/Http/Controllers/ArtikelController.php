<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;

class ArtikelController extends Controller
{
    /**
     * Tampilkan semua artikel publik dengan search & filter kategori
     */
    public function index(Request $request)
    {
        $query = Artikel::query()->latest();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%'.$request->search.'%')
                  ->orWhere('konten', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $artikels = $query->paginate(9)->withQueryString();

        return view('artikel.artikel', compact('artikels'));
    }

    /**
     * Tampilkan detail artikel berdasarkan slug
     */
    public function show($slug)
    {
        $artikel = Artikel::where('slug', $slug)->firstOrFail();
        return view('artikel.show', compact('artikel'));
    }
}
