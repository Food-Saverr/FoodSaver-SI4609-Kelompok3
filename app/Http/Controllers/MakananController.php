<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;

class MakananController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'Nama_Makanan' => 'required|string|max:255',
            'Deskripsi_Makanan' => 'nullable|string',
            'Kategori_Makanan' => 'nullable|string|max:255',
            'Foto_Makanan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Tanggal_Kedaluwarsa' => 'nullable|date',
            'Jumlah_Makanan' => 'required|integer|min:1',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $data = $request->all();
        $data['Status_Makanan'] = 'Tersedia';
        $data['id_user'] = auth()->id();

        if ($request->hasFile('Foto_Makanan')) {
            $path = $request->file('Foto_Makanan')->store('public/makanan');
            $data['Foto_Makanan'] = str_replace('public/', '', $path);
        }

        Makanan::create($data);

        return redirect()->route('makanan.index')
            ->with('success', 'Makanan berhasil ditambahkan');
    }
} 