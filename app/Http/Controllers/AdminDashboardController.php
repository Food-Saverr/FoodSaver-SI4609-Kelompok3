<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Artikel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminArtikelController extends Controller
{
    /**
     * Tampilkan statistik & daftar artikel
     */
    public function index()
    {
        // Total seluruh artikel
        $totalArtikel = Artikel::count();

        // Ambil statistik: jumlah artikel per minggu
        $artikelPerMinggu = DB::table('artikels')
            ->select(
                DB::raw('YEARWEEK(created_at) as yearweek'),
                DB::raw("DATE(DATE_ADD(created_at, INTERVAL(1-DAYOFWEEK(created_at)) DAY)) as start_of_week"),
                DB::raw('COUNT(*) as total_artikel')
            )
            ->groupBy('yearweek', 'start_of_week')
            ->orderBy('yearweek')
            ->get();

        $labels = $artikelPerMinggu->pluck('start_of_week')->map(function ($d) {
            return Carbon::parse($d)->format('d M Y');
        });

        $data = $artikelPerMinggu->pluck('total_artikel');

        // Daftar artikel terbaru, paginasi 10 per halaman
        $artikelList = Artikel::latest()->paginate(10);

        return view('DashboardAdmin.artikel', compact(
            'totalArtikel',
            'labels',
            'data',
            'artikelList'
        ));
    }

    /**
     * Form tambah artikel baru
     */
    public function create()
    {
        return view('DashboardAdmin.artikel-create');
    }

    /**
     * Simpan artikel baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'   => 'required|string|max:255',
            'isi'     => 'required|string',
            'gambar'  => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                                  ->store('artikels','public');
        }

        Artikel::create(array_merge($data, [
            'user_id' => auth()->id(),
        ]));

        return redirect()->route('admin.artikel.index')
                         ->with('success', 'Artikel berhasil dibuat.');
    }

    /**
     * Form edit artikel
     */
    public function edit(Artikel $artikel)
    {
        return view('DashboardAdmin.artikel-edit', compact('artikel'));
    }

    /**
     * Update artikel
     */
    public function update(Request $request, Artikel $artikel)
    {
        $data = $request->validate([
            'judul'   => 'required|string|max:255',
            'isi'     => 'required|string',
            'gambar'  => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            \Storage::disk('public')->delete($artikel->gambar);
            $data['gambar'] = $request->file('gambar')
                                     ->store('artikels','public');
        }

        $artikel->update($data);

        return redirect()->route('admin.artikel.index')
                         ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Hapus artikel
     */
    public function destroy(Artikel $artikel)
    {
        \Storage::disk('public')->delete($artikel->gambar);
        $artikel->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }
}
