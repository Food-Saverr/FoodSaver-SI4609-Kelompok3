<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Support\Facades\Storage;

class AdminMakananController extends Controller
{
    public function index()
    {
        // Update Status_Makanan based on Jumlah_Makanan for all foods
        Makanan::query()->update([
            'Status_Makanan' => \Illuminate\Support\Facades\DB::raw("
                CASE
                    WHEN Jumlah_Makanan = 0 THEN 'Habis'
                    WHEN Jumlah_Makanan BETWEEN 1 AND 4 THEN 'Segera Habis'
                    WHEN Jumlah_Makanan >= 5 THEN 'Tersedia'
                    ELSE Status_Makanan
                END
            ")
        ]);

        // Fetch all food listings with donatur relationship
        $makanans = Makanan::with('donatur')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.food-listing.index', compact('makanans'));
    }

    public function show(Makanan $makanan)
    {
        $makanan->load('donatur');
        return view('admin.food-listing.show', compact('makanan'));
    }

    public function destroy(Makanan $makanan)
    {
        try {
            if ($makanan->Foto_Makanan && Storage::disk('public')->exists($makanan->Foto_Makanan)) {
                Storage::disk('public')->delete($makanan->Foto_Makanan);
            }
            $makanan->delete();
            return redirect()->route('admin.food-listing.index')
                           ->with('success', 'Data makanan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.food-listing.index')
                           ->with('error', 'Gagal menghapus data makanan. Silakan coba lagi.');
        }
    }
}