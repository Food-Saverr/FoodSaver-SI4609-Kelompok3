<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class ProfileController extends Controller
{
    // Menampilkan halaman profil pengguna
    public function show()
    {
        $user = Auth::user(); // Ambil data pengguna yang sedang login

        // Tentukan tampilan berdasarkan role pengguna
        return view('profile.show', compact('user'));
    }

    // Menampilkan form edit profil
    public function edit()
    {
        $user = Auth::user();  // Ambil data pengguna yang sedang login
        return view('profile.edit', compact('user'));
    }

    // Memperbarui data profil pengguna
    public function update(Request $request)
    {
        // Validasi input untuk profil
        $request->validate([
            'Nama_Pengguna' => 'nullable|string|max:255',
            'Email_Pengguna' => 'nullable|email',
            'Alamat_Pengguna' => 'nullable|string',
            'old_password' => 'nullable|string|min:8', // Validasi password lama jika ada
            'new_password' => 'nullable|string|min:8|confirmed', // Validasi password baru dan konfirmasi
        ]);

        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Jika password lama dan baru ada, verifikasi dan update password
        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (!Hash::check($request->old_password, $user->Password_Pengguna)) {
                return back()->withErrors(['old_password' => 'Password lama tidak cocok.'])->withInput();
            }

            $user->Password_Pengguna = Hash::make($request->new_password);
        }

        // Update data profil jika ada perubahan (kecuali password)
        if ($request->filled('Nama_Pengguna')) {
            $user->Nama_Pengguna = $request->Nama_Pengguna;
        }

        if ($request->filled('Email_Pengguna')) {
            $user->Email_Pengguna = $request->Email_Pengguna;
        }

        if ($request->filled('Alamat_Pengguna')) {
            $user->Alamat_Pengguna = $request->Alamat_Pengguna;
        }

        // Simpan perubahan
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }

    // Menampilkan halaman konfirmasi untuk menghapus akun
    public function confirmDelete()
    {
        return view('profile.confirm-delete');
    }

    // Menghapus akun pengguna setelah konfirmasi
    public function destroy()
    {
        $user = Auth::user();  // Ambil data pengguna yang sedang login

        // Hapus foto profil jika ada
        if ($user->foto) {
            \Storage::delete($user->foto);
        }

        // Hapus akun pengguna
        $user->delete();

        // Logout setelah menghapus akun
        Auth::logout();

        // Redirect ke halaman utama atau landing page
        return redirect('/')->with('success', 'Akun Anda berhasil dihapus!');
    }

    // Menampilkan form edit password
    public function showChangePasswordForm()
    {
        return view('profile.change-password');
    }

    // Memperbarui password pengguna
    public function updatePassword(Request $request)
    {
        // Validasi input untuk password
        $request->validate([
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();  // Ambil data pengguna yang sedang login

        // Cek apakah password lama yang dimasukkan benar
        if (!Hash::check($request->old_password, $user->Password_Pengguna)) {
            return back()->withErrors(['old_password' => 'Password lama tidak cocok.'])->withInput();
        }

        // Update password baru
        $user->Password_Pengguna = Hash::make($request->new_password);

        // Simpan perubahan password
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('profile.show')->with('success', 'Password berhasil diperbarui!');
    }        
}
