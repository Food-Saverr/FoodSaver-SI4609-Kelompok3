<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {

        $jumlahDonatur = User::where('role', 'donatur')->count();
        $jumlahPenerima = User::where('role', 'penerima')->count();

        return view('dashboard-admin', compact(
            'jumlahDonatur',
            'jumlahPenerima'
        ));
    }

    public function statistikPengguna()
    {
        $jumlahDonatur = User::where('role', 'donatur')->count();
        $jumlahPenerima = User::where('role', 'penerima')->count();

        return view('StatistikPengguna', compact('jumlahDonatur', 'jumlahPenerima'));
    }

    public function statistikMakanan()
{
    $jumlahMakananTersedia = Makanan::where('status', 'tersedia')->count();
    $jumlahMakananDidonasikan = Makanan::where('status', 'didonasikan')->count();

    return view('admin.makanan', compact('jumlahMakananTersedia', 'jumlahMakananDidonasikan'));
}

}
