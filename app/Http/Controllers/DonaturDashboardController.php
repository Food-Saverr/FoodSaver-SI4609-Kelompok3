<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonaturDashboardController extends Controller
{
    public function index()
    {
        // Ensure only Donatur can access
        if (Auth::user()->Role_Pengguna !== 'Donatur') {
            abort(403, 'Hanya Donatur yang dapat mengakses dashboard ini.');
        }

        // Stats for dashboard
        $totalDonasi = Makanan::where('id_user', Auth::id())->count();
        $limbahDicegah = Makanan::where('id_user', Auth::id())->sum('Jumlah_Makanan') * 0.5; // Assume 0.5 kg per portion
        $penerimaTerbantu = Makanan::where('id_user', Auth::id())
            ->where('Status_Makanan', 'Tersedia')
            ->count(); // Proxy: count of available listings
        $recentMakanans = Makanan::where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('dashboard-donatur', compact('totalDonasi', 'limbahDicegah', 'penerimaTerbantu', 'recentMakanans'));
    }
}
