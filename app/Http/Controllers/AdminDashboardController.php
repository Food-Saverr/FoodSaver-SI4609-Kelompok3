<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pengguna;
use App\Models\Makanan;
use App\Models\Artikel;
use App\Models\Forum;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $jumlahDonatur = Pengguna::where('Role_Pengguna', 'Donatur')->count();
        $jumlahPenerima = Pengguna::where('Role_Pengguna', 'Pengguna')->count();

        $jumlahMakananTersedia = DB::table('makanans')->sum('Jumlah_Makanan');
        $jumlahMakananDidonasikan = DB::table('makanans')
            ->where('Status_Makanan', 'Habis')
            ->sum('Jumlah_Makanan');

        $totalDonasi = DB::table('makanans')->sum('Jumlah_Makanan');

        $totalArtikel = Artikel::count();

        // Statistik artikel per minggu untuk chart kecil di dashboard
        $artikelPerMinggu = \DB::table('artikels')
            ->select(
                \DB::raw('YEARWEEK(created_at, 1) as yearweek'),
                \DB::raw('MIN(DATE(created_at)) as start_of_week'),
                \DB::raw('COUNT(*) as total_artikel')
            )
            ->where('created_at', '>=', now()->subWeeks(4)) // Ambil 4 minggu terakhir untuk chart kecil
            ->groupBy('yearweek')
            ->orderBy('yearweek')
            ->get();

        $artikelLabels = $artikelPerMinggu->pluck('start_of_week')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->translatedFormat('d M');
        });
        $artikelData = $artikelPerMinggu->pluck('total_artikel');

        // Statistik artikel per minggu untuk halaman statistik
        $artikelPerMingguFull = \DB::table('artikels')
            ->select(
                \DB::raw('YEARWEEK(created_at, 1) as yearweek'),
                \DB::raw('MIN(DATE(created_at)) as start_of_week'),
                \DB::raw('COUNT(*) as total_artikel')
            )
            ->groupBy('yearweek')
            ->orderBy('yearweek')
            ->get();

        $artikelLabelsFull = $artikelPerMingguFull->pluck('start_of_week')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
        });
        $artikelDataFull = $artikelPerMingguFull->pluck('total_artikel');

        $totalForum = Forum::count();
        $diskusiAktif = Forum::where('is_active', true)->count();

        $forumPerBulan = Forum::statistikPerBulan();
        $bulanLabels = [];
        $forumData = [];

        foreach ($forumPerBulan as $data) {
            $bulanLabels[] = \Carbon\Carbon::create()->month($data->bulan)->format('F');
            $forumData[] = $data->total_forum;
        }

        return view('dashboard-admin', compact(
            'jumlahDonatur',
            'jumlahPenerima',
            'jumlahMakananTersedia',
            'jumlahMakananDidonasikan',
            'totalDonasi',
            'totalArtikel',
            'artikelLabels',
            'artikelData',
            'artikelLabelsFull',
            'artikelDataFull',
            'totalForum',
            'diskusiAktif',
            'bulanLabels',
            'forumData'
        ));
    }

    public function statistikPengguna()
    {
        $jumlahDonatur = Pengguna::where('Role_Pengguna', 'Donatur')->count();
        $jumlahPenerima = Pengguna::where('Role_Pengguna', 'Pengguna')->count();

        $donaturPerBulan = DB::table('penggunas')
            ->select(
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

        return view('DashboardAdmin.statistik-pengguna', compact(
            'jumlahDonatur',
            'jumlahPenerima',
            'donaturPerBulan',
            'penerimaPerBulan'
        ));
    }

    public function statistikMakanan()
    {
        $jumlahMakananTersedia = DB::table('makanans')->sum('Jumlah_Makanan');
        $jumlahMakananDidonasikan = DB::table('makanans')
            ->where('Status_Makanan', 'Habis')
            ->sum('Jumlah_Makanan');

        $makananPerBulan = DB::table('makanans')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(CASE WHEN Status_Makanan != "Habis" THEN Jumlah_Makanan ELSE 0 END) as total_tersedia'),
                DB::raw('SUM(CASE WHEN Status_Makanan = "Habis" THEN Jumlah_Makanan ELSE 0 END) as total_didonasi')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('bulan')
            ->get();

        return view('DashboardAdmin.makanan', compact(
            'jumlahMakananTersedia',
            'jumlahMakananDidonasikan',
            'makananPerBulan'
        ));
    }

    public function showTotalArtikel()
    {
        // Get total articles
        $totalArtikel = Artikel::count();

        // Get articles per week for the last 8 weeks
        $artikelPerMinggu = \DB::table('artikels')
            ->select(
                \DB::raw('YEARWEEK(created_at, 1) as yearweek'),
                \DB::raw('MIN(DATE(created_at)) as start_of_week'),
                \DB::raw('COUNT(*) as total_artikel')
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

        // Prepare data for charts
        $labels = $artikelPerMinggu->pluck('start_of_week')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
        });
        
        $data = $artikelPerMinggu->pluck('total_artikel');

        return view('DashboardAdmin.artikel-admin', compact(
            'totalArtikel',
            'artikelList',
            'artikelMingguIni',
            'labels',
            'data'
        ));
    }

    public function statistikForum()
    {
        $totalForum = Forum::count();
        $diskusiAktif = Forum::where('is_active', true)->count();

        $forumPerBulan = Forum::statistikPerBulan();

        $bulanLabels = [];
        $forumData = [];

        foreach ($forumPerBulan as $data) {
            $bulanLabels[] = \Carbon\Carbon::create()->month($data->bulan)->format('F');
            $forumData[] = $data->total_forum;
        }

        return view('DashboardAdmin.statistikforum', compact(
            'totalForum',
            'diskusiAktif',
            'bulanLabels',
            'forumData'
        ));
    }

    public function statistikDonasi()
    {
        $totalDonasi = DB::table('makanans')
            ->where('Status_Makanan', 'Habis')
            ->sum('Jumlah_Makanan');

        $donasiPerBulan = DB::table('makanans')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(CASE WHEN Status_Makanan = "Habis" THEN Jumlah_Makanan ELSE 0 END) as total_donasi')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('bulan')
            ->get();

        $topDonatur = DB::table('makanans')
            ->join('penggunas', 'makanans.id_user', '=', 'penggunas.id_user')
            ->select(
                'penggunas.Nama_Pengguna',
                'makanans.Nama_Makanan',
                DB::raw('SUM(CASE WHEN makanans.Status_Makanan = "Habis" THEN makanans.Jumlah_Makanan ELSE 0 END) as total_donasi')
            )
            ->groupBy('penggunas.id_user', 'penggunas.Nama_Pengguna', 'makanans.Nama_Makanan')
            ->orderBy('total_donasi', 'desc')
            ->limit(5)
            ->get();

        return view('DashboardAdmin.donasi', compact(
            'totalDonasi',
            'donasiPerBulan',
            'topDonatur'
        ));
    }
}
