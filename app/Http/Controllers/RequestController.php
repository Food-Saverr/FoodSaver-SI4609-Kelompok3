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
        // Validasi untuk waktu pengambilan
        $request->validate([
            'Waktu_Pengambilan' => 'required|date|after:now', // Waktu pengambilan harus setelah waktu sekarang
        ]);

        // Menyimpan permintaan baru dengan status 'Menunggu'
        Permintaan::create([
            'ID_Pengguna' => auth()->id(), // ID Pengguna yang sedang login
            'ID_Makanan' => $idMakanan, // ID Makanan yang dipilih
            'Waktu_Permintaan' => now(),
            'Waktu_Pengambilan' => $request->Waktu_Pengambilan,
            'Status_Permintaan' => 'Menunggu', // Status permintaan awal
        ]);

        // Setelah permintaan dibuat, arahkan pengguna ke halaman riwayat permintaan
        return redirect()->route('request.index')->with('success', 'Permintaan makanan berhasil dibuat! Menunggu persetujuan Admin.');
    }
}
