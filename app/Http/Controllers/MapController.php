<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function index()
    {
        $makanan = Makanan::whereNotNull(['latitude', 'longitude'])
            ->where('Status_Makanan', 'Tersedia')
            ->get();
            
        return view('maps.index', compact('makanan'));
    }

    public function nearby(Request $request)
    {
        if (!$request->latitude || !$request->longitude) {
            return response()->json(['error' => 'Lokasi tidak ditemukan'], 400);
        }
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $radius = $request->radius ?? 5; // Default radius 5km

        $makanan = Makanan::select(
            'makanans.*',
            DB::raw("
                6371 * acos(
                    cos(radians($latitude)) * 
                    cos(radians(latitude)) * 
                    cos(radians(longitude) - radians($longitude)) + 
                    sin(radians($latitude)) * 
                    sin(radians(latitude))
                ) AS distance
            ")
        )
        ->whereNotNull(['latitude', 'longitude'])
        ->where('Status_Makanan', 'Tersedia')
        ->having('distance', '<=', $radius)
        ->orderBy('distance')
        ->get();

        return response()->json($makanan);
    }

    public function updateLocation(Request $request, Makanan $makanan)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $makanan->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json(['message' => 'Lokasi berhasil diperbarui']);
    }
}