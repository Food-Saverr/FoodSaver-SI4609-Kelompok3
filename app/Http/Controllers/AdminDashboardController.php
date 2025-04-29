<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Makanan;
use App\Models\Artikel;
use App\Models\Pengguna;
use App\Models\Forum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $jumlahDonatur = Pengguna::where('Role_Pengguna', 'Donatur')->count();
        $jumlahPenerima = Pengguna::where('Role_Pengguna', 'Pengguna')->count();

        $jumlahMakananTersedia = DB::table('makanan')->sum('Jumlah_Tersedia');
        $jumlahMakananDidonasikan = DB::table('makanan')->sum('Jumlah_Didonasi');

        $totalDonasi = DB::table('makanan')->sum('Jumlah_Didonasi');
        $totalArtikel = Artikel::where('status', 'dipublikasikan')->count();

        // Mendapatkan statistik artikel per minggu untuk chart
        $artikelPerMinggu = DB::table('artikels')
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

        // Mendapatkan data donatur dan penerima per bulan
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

    public function showTotalArtikel()
    {
        $totalArtikel = Artikel::where('status', 'dipublikasikan')->count();
        $artikelList = Artikel::where('status', 'dipublikasikan')->latest()->get();

        // Mendapatkan statistik artikel per minggu
        $artikelPerMinggu = DB::table('artikels')
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
    
        return view('admin.statistikforum', compact(
            'totalForum',
            'diskusiAktif',
            'bulanLabels',
            'forumData'
        ));
    }
    
    public function statistikDonasi()
    {
        $totalDonasi = DB::table('makanan')->sum('Jumlah_Didonasi');
        
        // Mendapatkan data donasi per bulan
        $donasiPerBulan = DB::table('makanan')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(Jumlah_Didonasi) as total_donasi')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Mendapatkan top 5 donatur
        $topDonatur = DB::table('makanan')
            ->join('penggunas', 'makanan.user_id', '=', 'penggunas.ID_Pengguna')
            ->select(
                'penggunas.Nama_Pengguna',
                'makanan.Nama_Makanan',
                DB::raw('SUM(makanan.Jumlah_Didonasi) as total_donasi')
            )
            ->groupBy('penggunas.ID_Pengguna', 'penggunas.Nama_Pengguna', 'makanan.Nama_Makanan')
            ->orderBy('total_donasi', 'desc')
            ->limit(5)
            ->get();

        return view('admin.donasi', compact(
            'totalDonasi',
            'donasiPerBulan',
            'topDonatur'
        ));
    }
}
