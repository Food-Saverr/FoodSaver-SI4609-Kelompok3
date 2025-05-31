<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        // Mengambil hanya pengguna dengan role Donatur dan Pengguna
        $pengguna = Pengguna::whereIn('Role_Pengguna', ['Donatur', 'Pengguna'])->paginate(10); 

        // Mengirim data ke view
        return view('admin.manage-user.show', compact('pengguna'));
    }

    public function show($id)
    {
        $pengguna = Pengguna::findOrFail($id); // Find the user by ID, or throw an exception if not found
        return view('admin.manage-user.show-detail', compact('pengguna')); // Pass user data to the view
    }

    // Menampilkan form untuk mengedit pengguna
    public function edit($id)
    {
        $pengguna = Pengguna::findOrFail($id); // Ambil data pengguna berdasarkan ID
        return view('admin.manage-user.edit', compact('pengguna')); // Kirim data pengguna ke halaman edit
    }

    // Memperbarui pengguna
    public function update(Request $request, $id)
    {
        // Validasi input form
        $request->validate([
            'Nama_Pengguna' => 'required',
            'Email_Pengguna' => 'required|email',
            'Role_Pengguna' => 'required',
        ]);

        $pengguna = Pengguna::findOrFail($id); // Cari pengguna berdasarkan ID
        $pengguna->update($request->all()); // Update data pengguna dengan input baru

         return redirect()->route('admin.manage-user.show', $pengguna->id_user)->with('success', 'Pengguna berhasil diperbarui');
    }

    // Menampilkan halaman konfirmasi untuk menghapus akun
    public function confirmDelete($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('admin.manage-user.confirm-delete', compact('pengguna'));
    }

    // Menghapus akun pengguna setelah konfirmasi
    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id); // Ambil data pengguna berdasarkan ID

        // Hapus akun pengguna
        $pengguna->delete();

        // Redirect ke halaman daftar pengguna dengan flash message
        return redirect()->route('admin.manage-user.index')->with('success', 'Pengguna berhasil dihapus');
    }

    
    // Menonaktifkan akun pengguna
    public function deactivate($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->update(['is_active' => false]);

        return redirect()->route('admin.manage-user.index')->with('success', 'Pengguna berhasil dinonaktifkan');
    }

    // Mengaktifkan akun pengguna
    public function activate($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->update(['is_active' => true]);

        return redirect()->route('admin.manage-user.index')->with('success', 'Pengguna berhasil diaktifkan');
    }

    //update status akun pengguna (index)
    public function updateStatus(Request $request, $id)
    {
        $pengguna = Pengguna::findOrFail($id); // Cari pengguna berdasarkan ID
        $pengguna->is_active = $request->is_active; // Perbarui status akun
        $pengguna->save(); // Simpan perubahan

        // Kembali ke halaman daftar pengguna dengan pesan sukses
        return redirect()->route('admin.manage-user.index')->with('success', 'Status akun berhasil diperbarui');
    }
}
