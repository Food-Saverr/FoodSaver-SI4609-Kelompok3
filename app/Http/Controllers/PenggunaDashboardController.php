<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggunaDashboardController extends Controller
{
    public function index()
    {
        // Fetch available food listings
        $availableMakanans = Makanan::where('Status_Makanan', 'Tersedia')
            ->select('ID_Makanan', 'Nama_Makanan', 'Jumlah_Makanan', 'Foto_Makanan', 'Tanggal_Kedaluwarsa', 'Status_Makanan')
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard-pengguna', compact(
            'availableMakanans'
        ));
    }
}