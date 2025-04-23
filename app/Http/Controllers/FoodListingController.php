<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FoodListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Makanan::with('donatur')->latest();
    
        // Search by Nama_Makanan or Deskripsi_Makanan
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('Nama_Makanan', 'like', '%' . $search . '%')
                  ->orWhere('Deskripsi_Makanan', 'like', '%' . $search . '%');
            });
        }
    
        // Filter by Status_Makanan
        if ($status = $request->input('status')) {
            $query->where('Status_Makanan', $status);
        }
    
        // Filter by Kategori_Makanan
        if ($kategori = $request->input('kategori')) {
            $query->where('Kategori_Makanan', $kategori);
        }
    
        $makanans = $query->paginate(9)->appends($request->only(['search', 'status', 'kategori']));
    
        // Define categories manually
        $kategoris = ['Makanan Berat', 'Makanan Ringan', 'Makanan Penutup', 'Minuman', 'Sayuran', 'Buah-buahan'];
    
        return view('pengguna.food-listing.index', compact('makanans', 'kategoris'));
    }

    public function show(Makanan $makanan)
    {
        $makanan->load('donatur');

        return view('pengguna.food-listing.show', compact('makanan'));
    }
}