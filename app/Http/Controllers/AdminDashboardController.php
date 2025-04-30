<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna; // Menggunakan model Pengguna
use App\Models\Makanan; // Menggunakan model Makanan

class AdminDashboardController extends Controller
{
    public function index()
    {
        $jumlahDonatur = Pengguna::where('Role_Pengguna', 'donatur')->count();
        $jumlahPenerima = Pengguna::where('Role_Pengguna', 'penerima')->count();

        $jumlahMakananTersedia = Makanan::where('Status_Makanan', 'tersedia')->count();
        $jumlahMakananDidonasikan = Makanan::where('Status_Makanan', 'didonasikan')->count();

        return view('dashboard-admin', compact(
            'jumlahDonatur',
            'jumlahPenerima',
            'jumlahMakananTersedia',
            'jumlahMakananDidonasikan',
        ));
    }
}