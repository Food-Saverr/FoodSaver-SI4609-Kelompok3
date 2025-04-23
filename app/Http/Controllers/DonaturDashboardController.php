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
        $totalDonasi = Makanan::where('ID_Pengguna', Auth::id())->count();
        $penerimaTerbantu = Makanan::where('ID_Pengguna', Auth::id())
                                   ->where('Status_Makanan', 'Tersedia')
                                   ->count(); // Proxy: count of available listings
        $recentMakanans = Makanan::where('ID_Pengguna', Auth::id())
                                ->orderBy('created_at', 'desc')
                                ->take(3)
                                ->get();

        return view('dashboard-donatur', compact('totalDonasi', 'limbahDicegah', 'penerimaTerbantu', 'recentMakanans'));
    }
}