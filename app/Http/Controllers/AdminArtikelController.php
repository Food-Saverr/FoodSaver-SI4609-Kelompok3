<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminArtikelController extends Controller
{
    // Tampilkan daftar + statistik
    public function index()
    {
        $total = Artikel::count();
        $artikels = Artikel::latest()->paginate(10);

        // akan memanggil resources/views/admin/artikel/DashboardAdmin-ArtikelIndex.blade.php
        return view('admin.artikel.DashboardAdmin-ArtikelIndex', [
            'totalArtikel' => $total,
            'artikels'     => $artikels, // perbaiki di sini
        ]);
    }

    // Form tambah
    public function create()
    {
        // resources/views/admin/artikel/DashboardAdmin-ArtikelCreate.blade.php
        return view('admin.artikel.DashboardAdmin-ArtikelCreate');
    }

    // Simpan baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'  => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('artikels', 'public');
        }

        Artikel::create(array_merge(
            $data,
            ['user_id' => Auth::id()]
        ));

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    // Form edit
    public function edit(Artikel $artikel)
    {
        // resources/views/admin/artikel/DashboardAdmin-ArtikelEdit.blade.php
        return view('admin.artikel.DashboardAdmin-ArtikelEdit', compact('artikel'));
    }

    // Update
    public function update(Request $request, Artikel $artikel)
    {
        $data = $request->validate([
            'judul'  => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($artikel->gambar);
            $data['gambar'] = $request->file('gambar')
                ->store('artikels', 'public');
        }

        $artikel->update($data);

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    // Hapus
    public function destroy(Artikel $artikel)
    {
        Storage::disk('public')->delete($artikel->gambar);
        $artikel->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }
}
