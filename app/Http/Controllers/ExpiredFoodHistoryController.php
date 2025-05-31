<?php

namespace App\Http\Controllers;

use App\Models\ExpiredFoodHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpiredFoodHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ExpiredFoodHistory::where('id_user', Auth::id())
            ->orderBy('expired_at', 'desc');

        // Filter berdasarkan tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('expired_at', [
                $request->start_date,
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori')) {
            $query->where('Kategori_Makanan', $request->kategori);
        }

        // Filter berdasarkan nama makanan
        if ($request->has('search')) {
            $query->where('Nama_Makanan', 'like', '%' . $request->search . '%');
        }

        $expiredFoods = $query->paginate(10);

        // Get unique categories for filter
        $categories = ExpiredFoodHistory::where('id_user', Auth::id())
            ->distinct()
            ->pluck('Kategori_Makanan')
            ->filter();

        // Calculate statistics
        $totalExpired = ExpiredFoodHistory::where('id_user', Auth::id())->count();
        $totalQuantity = ExpiredFoodHistory::where('id_user', Auth::id())->sum('Jumlah_Makanan');
        $totalDonated = ExpiredFoodHistory::where('id_user', Auth::id())->sum('Jumlah_Didonasi');

        return view('donatur.expired-food-history.index', compact(
            'expiredFoods',
            'categories',
            'totalExpired',
            'totalQuantity',
            'totalDonated'
        ));
    }

    public function show(ExpiredFoodHistory $expiredFood)
    {
        // Ensure the user can only view their own expired food history
        if ($expiredFood->id_user !== Auth::id()) {
            abort(403);
        }

        return view('donatur.expired-food-history.show', compact('expiredFood'));
    }
} 