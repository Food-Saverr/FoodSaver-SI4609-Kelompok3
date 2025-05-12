<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonaturMakananController extends Controller
{
    public function index()
    {
        // Update Status_Makanan based on Jumlah_Makanan
        Makanan::where('id_user', Auth::id())->update([
            'Status_Makanan' => DB::raw("
                CASE
                    WHEN Jumlah_Makanan = 0 THEN 'Habis'
                    WHEN Jumlah_Makanan BETWEEN 1 AND 4 THEN 'Segera Habis'
                    WHEN Jumlah_Makanan >= 5 THEN 'Tersedia'
                    ELSE Status_Makanan
                END
            ")
        ]);

        $makanans = Makanan::where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('donatur.food-listing.index', compact('makanans'));
    }

    public function create()
    {
        return view('donatur.food-listing.create');
    }

    public function store(Request $request)
    {
        // Debug: Log incoming request data
        Log::info('Store method called', ['request' => $request->all(), 'files' => $request->hasFile('Foto_Makanan')]);

        $validatedData = $request->validate([
            'Nama_Makanan' => 'required|string|max:255',
            'Deskripsi_Makanan' => 'nullable|string',
            'Jumlah_Makanan' => 'required|integer|min:0',
            'Kategori_Makanan' => 'nullable|string|max:100',
            'Foto_Makanan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Status_Makanan' => 'nullable|string|in:Tersedia,Segera Habis,Habis',
            'Tanggal_Kedaluwarsa' => 'required|date|after_or_equal:today',
            'Lokasi_Makanan' => 'nullable|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ], [
            'Nama_Makanan.required' => 'Nama makanan harus diisi.',
            'Jumlah_Makanan.required' => 'Jumlah makanan harus diisi.',
            'Jumlah_Makanan.integer' => 'Jumlah makanan harus berupa angka bulat.',
            'Jumlah_Makanan.min' => 'Jumlah makanan harus minimal 0.',
            'Foto_Makanan.required' => 'Foto makanan harus diunggah.',
            'Foto_Makanan.image' => 'File harus berupa gambar.',
            'Foto_Makanan.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'Foto_Makanan.max' => 'Ukuran gambar maksimal 2MB.',
            'Tanggal_Kedaluwarsa.required' => 'Tanggal kedaluwarsa harus diisi.',
            'Tanggal_Kedaluwarsa.after_or_equal' => 'Tanggal kedaluwarsa harus hari ini atau setelahnya.',
            'latitude.required' => 'Latitude harus diisi.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'longitude.required' => 'Longitude harus diisi.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
        ]);

        // Debug: Log validation passed
        Log::info('Validation passed', ['validatedData' => $validatedData]);

        // Set Status_Makanan based on Jumlah_Makanan
        $validatedData['Status_Makanan'] = match (true) {
            $validatedData['Jumlah_Makanan'] == 0 => 'Habis',
            $validatedData['Jumlah_Makanan'] < 5 => 'Segera Habis',
            default => 'Tersedia',
        };

        $fotoPath = $request->file('Foto_Makanan')->store('makanan-fotos', 'public');

        $dataToSave = $validatedData;
        $dataToSave['Foto_Makanan'] = $fotoPath;
        $dataToSave['id_user'] = Auth::id();
        $dataToSave['latitude'] = $request->latitude;
        $dataToSave['longitude'] = $request->longitude;

        try {
            Makanan::create($dataToSave);
            Log::info('Food listing created successfully', ['data' => $dataToSave]);
            return redirect()->route('donatur.food-listing.index')
                ->with('success', 'Data makanan berhasil ditambahkan!');
        } catch (\Exception $e) {
            Storage::disk('public')->delete($fotoPath);
            Log::error('Failed to create food listing', ['error' => $e->getMessage(), 'data' => $dataToSave]);
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data makanan. Silakan coba lagi.')
                ->withInput();
        }
    }

    public function show(Makanan $makanan)
    {
        if ($makanan->id_user !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat makanan ini.');
        }
        return view('donatur.food-listing.show', compact('makanan'));
    }

    public function edit(Makanan $makanan)
    {
        if ($makanan->id_user !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit makanan ini.');
        }
        return view('donatur.food-listing.edit', compact('makanan'));
    }

    public function update(Request $request, Makanan $makanan)
    {
        if ($makanan->id_user !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk memperbarui makanan ini.');
        }

        // Debug: Log incoming request data
        Log::info('Update method called', ['request' => $request->all(), 'files' => $request->hasFile('Foto_Makanan')]);

        $validatedData = $request->validate([
            'Nama_Makanan' => 'required|string|max:255',
            'Deskripsi_Makanan' => 'nullable|string',
            'Jumlah_Makanan' => 'required|integer|min:0',
            'Kategori_Makanan' => 'nullable|string|max:100',
            'Foto_Makanan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Status_Makanan' => 'nullable|string|in:Tersedia,Segera Habis,Habis',
            'Tanggal_Kedaluwarsa' => 'required|date',
            'Lokasi_Makanan' => 'nullable|string|max:255',
        ], [
            'Nama_Makanan.required' => 'Nama makanan harus diisi.',
            'Jumlah_Makanan.required' => 'Jumlah makanan harus diisi.',
            'Jumlah_Makanan.integer' => 'Jumlah makanan harus berupa angka bulat.',
            'Jumlah_Makanan.min' => 'Jumlah makanan harus minimal 0.',
            'Foto_Makanan.image' => 'File harus berupa gambar.',
            'Foto_Makanan.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'Foto_Makanan.max' => 'Ukuran gambar maksimal 2MB.',
            'Tanggal_Kedaluwarsa.required' => 'Tanggal kedaluwarsa harus diisi.',
        ]);

        // Debug: Log validation passed
        Log::info('Update validation passed', ['validatedData' => $validatedData]);

        // Set Status_Makanan based on Jumlah_Makanan
        $validatedData['Status_Makanan'] = match (true) {
            $validatedData['Jumlah_Makanan'] == 0 => 'Habis',
            $validatedData['Jumlah_Makanan'] < 5 => 'Segera Habis',
            default => 'Tersedia',
        };

        if ($request->hasFile('Foto_Makanan')) {
            if ($makanan->Foto_Makanan && Storage::disk('public')->exists($makanan->Foto_Makanan)) {
                Storage::disk('public')->delete($makanan->Foto_Makanan);
            }
            $validatedData['Foto_Makanan'] = $request->file('Foto_Makanan')->store('makanan-fotos', 'public');
        }

        try {
            $makanan->update($validatedData);
            Log::info('Food listing updated successfully', ['data' => $validatedData]);
            return redirect()->route('donatur.food-listing.index')
                ->with('success', 'Data makanan berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Failed to update food listing', ['error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data makanan. Silakan coba lagi.')
                ->withInput();
        }
    }

    public function destroy(Makanan $makanan)
    {
        if ($makanan->id_user !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus makanan ini.');
        }

        try {
            if ($makanan->Foto_Makanan && Storage::disk('public')->exists($makanan->Foto_Makanan)) {
                Storage::disk('public')->delete($makanan->Foto_Makanan);
            }
            $makanan->delete();
            Log::info('Food listing deleted successfully', ['id' => $makanan->id]);
            return redirect()->route('donatur.food-listing.index')
                ->with('success', 'Data makanan berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Failed to delete food listing', ['error' => $e->getMessage(), 'id' => $makanan->id]);
            return redirect()->route('donatur.food-listing.index')
                ->with('error', 'Gagal menghapus data makanan. Silakan coba lagi.');
        }
    }
}
