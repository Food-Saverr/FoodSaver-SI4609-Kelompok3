<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class AdminMakananController extends Controller
{
    public function index()
    {
        // Update Status_Makanan based on Jumlah_Makanan
        Makanan::where('Jumlah_Makanan', 0)->update(['Status_Makanan' => 'Habis']);
        Makanan::where('Jumlah_Makanan', '>=', 1)
               ->where('Jumlah_Makanan', '<', 5)
               ->update(['Status_Makanan' => 'Segera Habis']);
        Makanan::where('Jumlah_Makanan', '>=', 5)
               ->whereNotIn('Status_Makanan', ['Segera Habis', 'Habis'])
               ->update(['Status_Makanan' => 'Tersedia']);

        // Fetch the data
        $query = Makanan::with('donatur');
        if (Auth::user()->Role_Pengguna === 'Donatur') {
            $query->where('ID_Pengguna', Auth::id());
        }
        $makanans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.food-listing.index', compact('makanans'));
    }

    public function create()
    {
        $userRole = Auth::user()->Role_Pengguna;
        if ($userRole !== 'Admin' && $userRole !== 'Donatur') {
            abort(403, 'HANYA ADMIN DAN DONATUR YANG BISA MENAMBAH admin.food-listing.');
        }
        return view('admin.food-listing.create');
    }

    public function store(Request $request)
    {
        $userRole = Auth::user()->Role_Pengguna;
        if ($userRole !== 'Admin' && $userRole !== 'Donatur') {
            abort(403, 'HANYA ADMIN DAN DONATUR YANG BISA MENAMBAH admin.food-listing.');
        }

        $validatedData = $request->validate([
            'Nama_Makanan' => 'required|string|max:255',
            'Deskripsi_Makanan' => 'nullable|string',
            'Jumlah_Makanan' => 'required|integer|min:0',
            'Kategori_Makanan' => 'nullable|string|max:100',
            'Foto_Makanan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Status_Makanan' => 'nullable|string|in:Tersedia,Segera Habis,Habis',
            'Tanggal_Kedaluwarsa' => 'required|date|after_or_equal:today',
            'Lokasi_Makanan' => 'nullable|string|max:255',
        ], [
            'Jumlah_Makanan.required' => 'Jumlah makanan harus diisi.',
            'Jumlah_Makanan.integer' => 'Jumlah makanan harus berupa angka bulat.',
            'Jumlah_Makanan.min' => 'Jumlah makanan harus minimal 0.',
        ]);

        // Set Status_Makanan based on Jumlah_Makanan
        if ($validatedData['Jumlah_Makanan'] == 0) {
            $validatedData['Status_Makanan'] = 'Habis';
        } elseif ($validatedData['Jumlah_Makanan'] < 5) {
            $validatedData['Status_Makanan'] = 'Segera Habis';
        } else {
            $validatedData['Status_Makanan'] = 'Tersedia';
        }

        $fotoPath = $request->file('Foto_Makanan')->store('makanan-fotos', 'public');

        $dataToSave = $validatedData;
        $dataToSave['Foto_Makanan'] = $fotoPath;
        $dataToSave['ID_Pengguna'] = Auth::id();

        try {
            Makanan::create($dataToSave);
            return redirect()->route('admin.food-listing.index')
                             ->with('success', 'Data makanan berhasil ditambahkan!');
        } catch (\Exception $e) {
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            return redirect()->back()
                             ->with('error', 'Gagal menambahkan data makanan: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function show(Makanan $makanan)
    {
        $makanan->load('donatur');
        return view('admin.food-listing.show', compact('makanan'));
    }

    public function edit(Makanan $makanan)
    {
        $user = Auth::user();
        if (!($user->Role_Pengguna === 'Admin' || ($user->Role_Pengguna === 'Donatur' && $user->ID_Pengguna === $makanan->ID_Pengguna))) {
            abort(403, 'ANDA TIDAK PUNYA AKSES UNTUK MENGEDIT MAKANAN INI.');
        }
        return view('admin.food-listing.edit', compact('makanan'));
    }

    public function update(Request $request, Makanan $makanan)
    {
        $user = Auth::user();
        if (!($user->Role_Pengguna === 'Admin' || ($user->Role_Pengguna === 'Donatur' && $user->ID_Pengguna === $makanan->ID_Pengguna))) {
            abort(403, 'ANDA TIDAK PUNYA AKSES UNTUK MEMPERBARUI MAKANAN INI.');
        }

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
            'Jumlah_Makanan.required' => 'Jumlah makanan harus diisi.',
            'Jumlah_Makanan.integer' => 'Jumlah makanan harus berupa angka bulat.',
            'Jumlah_Makanan.min' => 'Jumlah makanan harus minimal 0.',
        ]);

        // Set Status_Makanan based on Jumlah_Makanan
        if ($validatedData['Jumlah_Makanan'] == 0) {
            $validatedData['Status_Makanan'] = 'Habis';
        } elseif ($validatedData['Jumlah_Makanan'] < 5) {
            $validatedData['Status_Makanan'] = 'Segera Habis';
        } else {
            $validatedData['Status_Makanan'] = 'Tersedia';
        }

        $dataToUpdate = $validatedData;

        if ($request->hasFile('Foto_Makanan')) {
            if ($makanan->Foto_Makanan && Storage::disk('public')->exists($makanan->Foto_Makanan)) {
                Storage::disk('public')->delete($makanan->Foto_Makanan);
            }
            $fotoPath = $request->file('Foto_Makanan')->store('makanan-fotos', 'public');
            $dataToUpdate['Foto_Makanan'] = $fotoPath;
        } else {
            unset($dataToUpdate['Foto_Makanan']);
        }

        try {
            $makanan->update($dataToUpdate);
            return redirect()->route('admin.food-listing.index')
                             ->with('success', 'Data makanan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui data makanan: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function destroy(Makanan $makanan)
    {
        $user = Auth::user();
        if (!($user->Role_Pengguna === 'Admin' || ($user->Role_Pengguna === 'Donatur' && $user->ID_Pengguna === $makanan->ID_Pengguna))) {
            abort(403, 'ANDA TIDAK PUNYA AKSES UNTUK MENGHAPUS MAKANAN INI.');
        }

        try {
            if ($makanan->Foto_Makanan && Storage::disk('public')->exists($makanan->Foto_Makanan)) {
                Storage::disk('public')->delete($makanan->Foto_Makanan);
            }
            $makanan->delete();
            return redirect()->route('admin.food-listing.index')
                             ->with('success', 'Data makanan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.food-listing.index')
                             ->with('error', 'Gagal menghapus data makanan: ' . $e->getMessage());
        }
    }
}