<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\Permintaan;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    // Menampilkan daftar makanan yang bisa diminta oleh pengguna
    public function index()
    {
        $makanans = Makanan::where('Status_Makanan', 'Tersedia')->get();
        return view('request.index', compact('makanans'));
    }

    // Form untuk memilih makanan dan mengatur waktu permintaan
    public function create($idMakanan)
    {
        $makanan = Makanan::findOrFail($idMakanan);
        return view('request.create', compact('makanan'));
    }

    // Menyimpan permintaan makanan oleh pengguna
    public function store(Request $request, $idMakanan)
{
    Permintaan::create([
        'ID_Pengguna' => auth()->id(),
        'ID_Makanan' => $idMakanan,
        'Waktu_Permintaan' => now(),
        'Status_Permintaan' => 'Menunggu',
    ]);

    return redirect()->route('request.history')->with('success', 'Permintaan makanan berhasil dibuat! Menunggu persetujuan Admin.');
    }
    public function destroy($idMakanan)
        {
            $permintaan = Permintaan::where('ID_Makanan', $idMakanan)
            ->where('ID_Pengguna', auth()->id())
            ->firstOrFail();

            $permintaan->delete();

            return redirect()->back()->with('success', 'Permintaan berhasil dihapus.');
        }
}
