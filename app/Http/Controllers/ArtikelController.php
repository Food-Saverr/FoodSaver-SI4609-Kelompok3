<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArtikelController extends Controller
{
    public function indexAdmin(Request $request)
    {
        $query = Artikel::query();

        if ($search = $request->input('q')) {
            $query->where('judul', 'like', "%{$search}%")
                ->orWhere('konten', 'like', "%{$search}%");
        }

        $artikels = $query->latest()->paginate(10)->withQueryString();
        $total    = Artikel::count();

        return view('admin.artikel.DashboardAdmin-ArtikelIndex', [
            'artikels'     => $artikels,
            'totalArtikel' => $total,
        ]);
    }

    public function create()
    {
        return view('admin.artikel.DashboardAdmin-ArtikelCreate');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'  => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('artikels', 'public');
        }

        Artikel::create(array_merge($data, [
            'slug'    => Str::slug($data['judul']),
            'user_id' => Auth::id(),
        ]));

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.DashboardAdmin-ArtikelEdit', compact('artikel'));
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $data = $request->validate([
            'judul'  => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // hapus lama jika ada
            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $data['gambar'] = $request->file('gambar')
                ->store('artikels', 'public');
        }

        $data['slug'] = Str::slug($data['judul']);
        $artikel->update($data);

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        if ($artikel->gambar) {
            Storage::disk('public')->delete($artikel->gambar);
        }
        $artikel->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }

    public function indexPengguna(Request $request)
    {
        $query = Artikel::query();
        if ($q = $request->input('q')) {
            $query->where('judul', 'like', "%{$q}%")
                ->orWhere('konten', 'like', "%{$q}%");
        }
        $artikels = $query->latest()->paginate(12)->withQueryString();

        return view('pengguna.artikel.artikel-pengguna', compact('artikels'));
    }

    public function indexDonatur(Request $request)
    {
        $query = Artikel::query();
        if ($q = $request->input('q')) {
            $query->where('judul', 'like', "%{$q}%")
                ->orWhere('konten', 'like', "%{$q}%");
        }
        $artikels = $query->latest()->paginate(12)->withQueryString();

        return view('donatur.artikel.artikel-donatur', compact('artikels'));
    }

    public function artikelDonatur()
    {
        $artikels = Artikel::latest()->paginate(10);
        return view('donatur.artikel.artikel-donatur', compact('artikels'));
    }

    public function artikelPengguna()
    {
        $artikels = Artikel::latest()->paginate(10);
        return view('pengguna.artikel.artikel-pengguna', compact('artikels'));
    }

    public function show($slug)
    {
        $artikel = Artikel::where('slug', $slug)->firstOrFail();

        // Pastikan user sudah login (middleware 'auth' di route)
        $role = Auth::user()->Role_Pengguna;

        if ($role === 'Donatur') {
            // Return a detail view for Donatur, e.g. 'donatur.artikel.artikel-detail'
            return view('donatur.artikel.artikel-detail', compact('artikel'));
        }

        if ($role === 'Pengguna') {
            // Return a detail view for Pengguna, e.g. 'pengguna.artikel.artikel-detail'
            return view('pengguna.artikel.artikel-detail', compact('artikel'));
        }

        abort(403, ' Halaman ini tidak dapat diakses!.');
    }

    public function index(Request $request)
    {
        $query = Artikel::query();
        if ($q = $request->input('q')) {
            $query->where('judul', 'like', "%{$q}%")
                ->orWhere('konten', 'like', "%{$q}%");
        }
        $artikels = $query->latest()->paginate(12)->withQueryString();

        // Silakan sesuaikan view berikut sesuai kebutuhan public (umum)
        return view('admin.artikel.DashboardAdmin-ArtikelIndex', compact('artikels'));
    }

    public function showStatistics()
    {
        // Get total articles
        $totalArtikel = Artikel::count();

        // Get articles per week for the last 8 weeks
        $artikelPerMinggu = Artikel::select(
            DB::raw('YEARWEEK(created_at, 1) as yearweek'),
            DB::raw('MIN(DATE(created_at)) as start_of_week'),
            DB::raw('COUNT(*) as total_artikel')
        )
        ->where('created_at', '>=', now()->subWeeks(8))
        ->groupBy('yearweek')
        ->orderBy('yearweek')
        ->get();

        // Get latest articles
        $artikelList = Artikel::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Get articles published this week
        $artikelMingguIni = Artikel::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();

        // Get articles by category (if you have categories)
        $artikelPerKategori = Artikel::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get();

        // Prepare data for charts
        $labels = $artikelPerMinggu->pluck('start_of_week')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
        });
        
        $data = $artikelPerMinggu->pluck('total_artikel');

        return view('DashboardAdmin.artikel-admin', compact(
            'totalArtikel',
            'artikelList',
            'artikelMingguIni',
            'artikelPerKategori',
            'labels',
            'data'
        ));
    }
}
