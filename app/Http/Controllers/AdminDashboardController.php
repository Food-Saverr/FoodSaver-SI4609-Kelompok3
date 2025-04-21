<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Makanan;
use App\Models\Donasi;
use App\Models\Artikel;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->Role_Pengguna !== 'Admin') {
                return redirect()->route('login')->with('error', 'Akses ditolak. Anda harus login sebagai admin.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $jumlahDonatur = Pengguna::where('Role_Pengguna', 'Donatur')->count();
        $jumlahPenerima = Pengguna::where('Role_Pengguna', 'Pengguna')->count();

        $jumlahMakananTersedia = DB::table('makanan')->sum('Jumlah_Tersedia');
        $jumlahMakananDidonasikan = DB::table('makanan')->sum('Jumlah_Didonasi');

        $totalDonasi = DB::table('makanan')->sum('Jumlah_Didonasi');
        $totalArtikel = Artikel::where('status', 'dipublikasikan')->count();

        // Mendapatkan statistik artikel per minggu untuk chart
        $artikelPerMinggu = DB::table('artikel')
            ->select(
                DB::raw('YEARWEEK(created_at) as yearweek'),
                DB::raw('DATE(DATE_ADD(created_at, INTERVAL(1-DAYOFWEEK(created_at)) DAY)) as start_of_week'),
                DB::raw('COUNT(*) as total_artikel')
            )
            ->where('status', 'dipublikasikan')
            ->groupBy('yearweek', 'start_of_week')
            ->orderBy('yearweek')
            ->get();

        // Format data untuk chart
        $artikelLabels = $artikelPerMinggu->pluck('start_of_week')->map(function($date) {
            return date('d M Y', strtotime($date));
        });
        $artikelData = $artikelPerMinggu->pluck('total_artikel');

        return view('dashboard-admin', compact(
            'jumlahDonatur',
            'jumlahPenerima',
            'jumlahMakananTersedia', 
            'jumlahMakananDidonasikan',
            'totalDonasi',
            'totalArtikel',
            'artikelLabels',
            'artikelData',
            'totalDonasi',
        ));
    }

    public function statistikPengguna()
    {
        $jumlahDonatur = Pengguna::where('Role_Pengguna', 'Donatur')->count();
        $jumlahPenerima = Pengguna::where('Role_Pengguna', 'Pengguna')->count();
        
        // Mendapatkan data donatur dan penerima per bulan
        $donaturPerBulan = DB::table('penggunas')
            ->select(

        $penggunaBaru = Pengguna::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('bulan')
            ->get();

        return view('admin.statistik-pengguna', compact('jumlahDonatur', 'jumlahPenerima', 'penggunaBaru'));
    }

    public function statistikMakanan()
    {
        $jumlahMakananTersedia = Makanan::where('status', 'tersedia')->count();
        $jumlahMakananDidonasikan = Makanan::where('status', 'didonasikan')->count();

        return view('statistik-pengguna', compact(
            'jumlahMakananTersedia',
            'jumlahMakananDidonasikan'
        ));
    }

    public function detailDonasi()
    {
        $totalDonasi = Donasi::sum('jumlah');

        $donasiPerBulan = Donasi::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->where('Role_Pengguna', 'Donatur')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('bulan')
            ->get();
            
        $penerimaPerBulan = DB::table('penggunas')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->where('Role_Pengguna', 'Pengguna')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('bulan')
            ->get();

        return view('admin.statistik-pengguna', compact(
            'jumlahDonatur', 
            'jumlahPenerima',
            'donaturPerBulan',
            'penerimaPerBulan'
        ));
    }
    public function statistikMakanan()
    {
        $jumlahMakananTersedia = DB::table('makanan')->sum('Jumlah_Tersedia');
        $jumlahMakananDidonasikan = DB::table('makanan')->sum('Jumlah_Didonasi');
        
        // Mendapatkan data makanan per bulan
        $makananPerBulan = DB::table('makanan')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(Jumlah_Tersedia) as total_tersedia'),
                DB::raw('SUM(Jumlah_Didonasi) as total_didonasi')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('admin.makanan', compact(
            'jumlahMakananTersedia',
            'jumlahMakananDidonasikan',
            'makananPerBulan'
        ));
    }

    public function statistikDonasi()
    {
        // Total donasi keseluruhan
        $totalDonasi = DB::table('makanan')->sum('Jumlah_Didonasi');
        
        // Donasi per bulan dengan detail makanan dan donatur
        $donasiPerBulan = DB::table('makanan')
            ->join('penggunas', 'makanan.user_id', '=', 'penggunas.ID_Pengguna')
            ->select(
                DB::raw('MONTH(makanan.created_at) as bulan'),
                DB::raw('SUM(makanan.Jumlah_Didonasi) as total_donasi'),
                'penggunas.Nama_Pengguna',
                'makanan.Nama_Makanan'
            )
            ->where('makanan.Jumlah_Didonasi', '>', 0)
            ->groupBy('bulan', 'penggunas.Nama_Pengguna', 'makanan.Nama_Makanan')
            ->orderBy('bulan')
            ->get();
            
        // Top donatur dengan detail makanan
        $topDonatur = DB::table('makanan')
            ->join('penggunas', 'makanan.user_id', '=', 'penggunas.ID_Pengguna')
            ->select(
                'penggunas.Nama_Pengguna',
                'penggunas.Role_Pengguna',
                'makanan.Nama_Makanan',
                DB::raw('SUM(makanan.Jumlah_Didonasi) as total_donasi')
            )
            ->where('penggunas.Role_Pengguna', '=', 'Donatur')
            ->where('makanan.Jumlah_Didonasi', '>', 0)
            ->groupBy('penggunas.ID_Pengguna', 'penggunas.Nama_Pengguna', 'penggunas.Role_Pengguna', 'makanan.Nama_Makanan')
            ->orderByDesc('total_donasi')
            ->limit(5)
            ->get();

        return view('admin.donasi', compact(
            'totalDonasi',
            'donasiPerBulan',
            'topDonatur'
        ));
    }

    public function showTotalArtikel()
    {
        $totalArtikel = Artikel::where('status', 'dipublikasikan')->count();
        $artikelList = Artikel::where('status', 'dipublikasikan')->latest()->get();

        // Mendapatkan statistik artikel per minggu
        $artikelPerMinggu = DB::table('artikel')
            ->select(
                DB::raw('YEARWEEK(created_at) as yearweek'),
                DB::raw('DATE(DATE_ADD(created_at, INTERVAL(1-DAYOFWEEK(created_at)) DAY)) as start_of_week'),
                DB::raw('COUNT(*) as total_artikel')
            )
            ->where('status', 'dipublikasikan')
            ->groupBy('yearweek', 'start_of_week')
            ->orderBy('yearweek')
            ->get();

        // Format data untuk chart
        $labels = $artikelPerMinggu->pluck('start_of_week')->map(function($date) {
            return date('d M Y', strtotime($date));
        });
        $data = $artikelPerMinggu->pluck('total_artikel');

        return view('admin.artikel', compact(
            'totalArtikel', 
            'artikelList',
            'labels',
            'data'
        ));
    }

    public function showTotalArtikel()
    {
        $totalArtikel = Artikel::where('status', 'dipublikasikan')->count();
        $artikelDraft = Artikel::where('status', 'draft')->count();
        $artikelDihapus = Artikel::where('status', 'dihapus')->count();
        $artikelList = Artikel::where('status', 'dipublikasikan')
            ->with('user')
            ->latest()
            ->get();

        return view('admin.artikel', compact(
            'totalArtikel',
            'artikelDraft',
            'artikelDihapus',
            'artikelList'
        ));
    }

}
