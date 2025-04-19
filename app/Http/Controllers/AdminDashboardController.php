<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Makanan;
use App\Models\Donasi;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $jumlahDonatur = User::where('role', 'donatur')->count();
        $jumlahPenerima = User::where('role', 'penerima')->count();

        $jumlahMakananTersedia = Makanan::where('status', 'tersedia')->count();
        $jumlahMakananDidonasikan = Makanan::where('status', 'didonasikan')->count();

        $totalDonasi = Donasi::sum('jumlah');

        return view('dashboard-admin', compact(
            'jumlahDonatur',
            'jumlahPenerima',
            'jumlahMakananTersedia', 
            'jumlahMakananDidonasikan' ,
            'totalDonasi'
        ));
    }

    public function statistikPengguna()
    {
        $jumlahDonatur = User::where('role', 'donatur')->count();
        $jumlahPenerima = User::where('role', 'penerima')->count();

        $penggunaBaru = User::select(
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
                DB::raw('SUM(jumlah) as total')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('bulan')
            ->get();

        return view('TotalDonasi', compact('totalDonasi', 'donasiPerBulan'));
    }
}
