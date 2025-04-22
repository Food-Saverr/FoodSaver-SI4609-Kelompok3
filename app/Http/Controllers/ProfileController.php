<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class ProfileController extends Controller
{
    // Menampilkan form edit profil
    public function edit()
    {
        $user = Auth::user();  // Ambil data pengguna yang sedang login
        return view('profile.edit', compact('user'));
    }

    // Memperbarui data profil pengguna
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'Nama_Pengguna' => 'required|string|max:255',
            'Email_Pengguna' => 'required|email',
            'Alamat_Pengguna' => 'required|string',
            'old_password' => 'nullable|string|min:8', // Validasi password lama jika ada
            'new_password' => 'nullable|string|min:8|confirmed', // Validasi password baru dan konfirmasi
        ]);

        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Cek apakah password lama yang dimasukkan benar
        if ($request->filled('old_password') && !Hash::check($request->old_password, $user->Password_Pengguna)) {
            return back()->withErrors(['old_password' => 'Password lama tidak cocok.'])->withInput();
        }

        // Update data profil (kecuali password)
        $user->Nama_Pengguna = $request->Nama_Pengguna;
        $user->Email_Pengguna = $request->Email_Pengguna;
        $user->Alamat_Pengguna = $request->Alamat_Pengguna;

        // Jika password baru diisi, update password
        if ($request->filled('new_password')) {
            $user->Password_Pengguna = Hash::make($request->new_password);
        }

        // Simpan perubahan
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
