<?php
namespace App\Http\Controllers;

use App\Models\Permintaan;

class RiwayatPermintaanController extends Controller
{
    // Menampilkan riwayat permintaan untuk pengguna yang sedang login
    public function index()
    {
        $permintaans = Permintaan::where('ID_Pengguna', auth()->id())->get();
        return view('request.riwayat.permintaan', compact('permintaans'));
    }
}
