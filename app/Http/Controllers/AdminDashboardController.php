<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Makanan;
use App\Models\Donasi;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $jumlahDonatur = Pengguna::where('Role_Pengguna', 'Donatur')->count();
        $jumlahPenerima = Pengguna::where('Role_Pengguna', 'Penerima')->count();
        
        // Mengambil data makanan
        $jumlahMakananTersedia = DB::table('makanan')->sum('Jumlah_Tersedia');
        $jumlahMakananDidonasikan = DB::table('makanan')->sum('Jumlah_Didonasi');
        $totalDonasi = $jumlahMakananDidonasikan; // Total donasi adalah jumlah makanan yang sudah didonasikan

        return view('dashboard-admin', compact(
            'jumlahDonatur',
            'jumlahPenerima',
            'jumlahMakananTersedia',
            'jumlahMakananDidonasikan',
            'totalDonasi'
        ));
    }

    public function statistikPengguna()
    {
        $jumlahDonatur = Pengguna::where('Role_Pengguna', 'Donatur')->count();
        $jumlahPenerima = Pengguna::where('Role_Pengguna', 'Penerima')->count();
        
        // Mendapatkan data donatur dan penerima per bulan
        $donaturPerBulan = Pengguna::where('Role_Pengguna', 'Donatur')
            ->select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(*) as total'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
            
        $penerimaPerBulan = Pengguna::where('Role_Pengguna', 'Penerima')
            ->select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(*) as total'))
            ->groupBy('bulan')
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
        
        // Donasi per bulan
        $donasiPerBulan = DB::table('makanan')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(Jumlah_Didonasi) as total_donasi')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
            
        // Top donatur
        $topDonatur = DB::table('makanan')
            ->join('penggunas', 'makanan.user_id', '=', 'penggunas.ID_Pengguna')
            ->select(
                'penggunas.Nama_Pengguna',
                'penggunas.Role_Pengguna',
                DB::raw('SUM(makanan.Jumlah_Didonasi) as total_donasi')
            )
            ->where('penggunas.Role_Pengguna', '=', 'Donatur')
            ->groupBy('penggunas.ID_Pengguna', 'penggunas.Nama_Pengguna', 'penggunas.Role_Pengguna')
            ->orderByDesc('total_donasi')
            ->limit(5)
            ->get();

        return view('admin.donasi', compact(
            'totalDonasi',
            'donasiPerBulan',
            'topDonatur'
        ));
    }
}
