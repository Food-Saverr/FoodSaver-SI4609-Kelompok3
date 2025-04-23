<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FoodListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Makanan::with('donatur')->latest();
    
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('Nama_Makanan', 'like', '%' . $search . '%')
                  ->orWhere('Deskripsi_Makanan', 'like', '%' . $search . '%');
            });
        }
    
        if ($status = $request->input('status')) {
            $query->where('Status_Makanan', $status);
        }
    
        if ($kategori = $request->input('kategori')) {
            $query->where('Kategori_Makanan', $kategori);
        }
    
        $makanans = $query->paginate(9)->appends($request->only(['search', 'status', 'kategori']));
    
        $kategoris = ['Makanan Berat', 'Makanan Ringan', 'Makanan Penutup', 'Minuman', 'Sayuran', 'Buah-buahan'];
    
        return view('pengguna.food-listing.index', compact('makanans', 'kategoris'));
    }

    public function show(Makanan $makanan)
    {
        $makanan->load('donatur');
        return view('pengguna.food-listing.show', compact('makanan'));
    }

    public function storeRequest(Request $request, Makanan $makanan)
    {
        if (Auth::user()->Role_Pengguna !== 'Pengguna') {
            abort(403, 'Hanya Penerima yang dapat mengajukan permintaan.');
        }

        if ($makanan->Jumlah_Makanan <= 0 || $makanan->Status_Makanan === 'Habis') {
            return redirect()->back()->with('error', 'Makanan ini sudah habis.');
        }

        try {
            $expDate = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa);
            if ($expDate->isPast()) {
                return redirect()->back()->with('error', 'Makanan ini sudah kedaluwarsa.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Tanggal kedaluwarsa tidak valid.');
        }

        $existingRequest = Requests::where('ID_Makanan', $makanan->ID_Makanan)
                                 ->where('ID_Pengguna', Auth::id())
                                 ->exists();

        if ($existingRequest) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan permintaan untuk makanan ini.');
        }

        $validated = $request->validate([
            'Pesan' => 'nullable|string|max:500',
        ]);

        try {
            Requests::create([
                'ID_Makanan' => (int) $makanan->ID_Makanan, // Explicitly cast to integer
                'ID_Pengguna' => (int) Auth::id(), // Explicitly cast to integer
                'Pesan' => $validated['Pesan'] ?? null, // Ensure null if not provided
                'Status_Request' => 'Pending',
            ]);
            return redirect()->back()->with('success', 'Permintaan berhasil diajukan.');
        } catch (\Exception $e) {
            Log::error('Failed to store request: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengajukan permintaan. Silakan coba lagi.');
        }
    }
}