<?php
namespace App\Http\Controllers;

use App\Models\Permintaan;
use Illuminate\Http\Request;


class RiwayatPermintaanController extends Controller
{
    public function store(Request $request, $id_makanan)
        {
            // Validasi dan simpan data permintaan
            $permintaan = new Permintaan();
            $permintaan->ID_User = auth()->id(); // atau sesuai kebutuhan
            $permintaan->ID_Makanan = $id_makanan;
            $permintaan->Status_Permintaan = 'Menunggu';
            $permintaan->save();

            // Redirect ke halaman riwayat permintaan
            return redirect()->route('request.history')->with('success', 'Permintaan berhasil dikirim!');
        }
        public function index()
        {
            // Get all requests for the authenticated user
            $permintaans = Permintaan::where('ID_Pengguna', auth()->id())->get();
    
            // Return the view with the list of requests
            return view('request.riwayat.permintaan', compact('permintaans'));
        }
}