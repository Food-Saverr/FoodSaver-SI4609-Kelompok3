<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminArtikelController extends Controller
{
    /**
     * Show list of articles in Admin panel
     */
    public function index()
    {
        $artikelList = Artikel::latest()->paginate(10);

        return view('DashboardAdmin.artikel', [
            'artikelList'  => $artikelList,
            'totalArtikel' => Artikel::count(),
            'labels'       => Artikel::selectRaw("DATE_FORMAT(created_at, '%Y-%u') as week")
                                    ->groupBy('week')
                                    ->orderBy('week')
                                    ->pluck('week'),
            'data'         => Artikel::selectRaw('count(*) as cnt')
                                    ->groupByRaw("DATE_FORMAT(created_at, '%Y-%u')")
                                    ->orderByRaw("DATE_FORMAT(created_at, '%Y-%u')")
                                    ->pluck('cnt'),
        ]);
    }

    /**
     * Show the create-article form
     */
    public function create()
    {
        return view('DashboardAdmin.artikel-create');
    }

    /**
     * Store a brand-new article
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'    => 'required|string|max:255',
            'slug'     => 'required|string|unique:artikels,slug',
            'excerpt'  => 'nullable|string|max:500',
            'konten'   => 'required|string',
            'kategori' => 'nullable|string|max:100',
            'gambar'   => 'nullable|image|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')
                                        ->store('artikels', 'public');
        }

        // Create Artikel, assign current admin user as author
        Artikel::create(array_merge($validated, [
            'user_id' => Auth::id(),
        ]));

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    /**
     * Show the edit-article form
     */
    public function edit(Artikel $artikel)
    {
        return view('DashboardAdmin.artikel-edit', compact('artikel'));
    }

    /**
     * Update an existing article
     */
    public function update(Request $request, Artikel $artikel)
    {
        $validated = $request->validate([
            'judul'    => 'required|string|max:255',
            'slug'     => 'required|string|unique:artikels,slug,' . $artikel->id,
            'excerpt'  => 'nullable|string|max:500',
            'konten'   => 'required|string',
            'kategori' => 'nullable|string|max:100',
            'gambar'   => 'nullable|image|max:2048',
        ]);

        // If there's a new image, delete old and store new
        if ($request->hasFile('gambar')) {
            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $validated['gambar'] = $request->file('gambar')
                                          ->store('artikels', 'public');
        }

        $artikel->update($validated);

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Delete an article
     */
    public function destroy(Artikel $artikel)
    {
        // Remove associated image if present
        if ($artikel->gambar) {
            Storage::disk('public')->delete($artikel->gambar);
        }

        $artikel->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }
}
