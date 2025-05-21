<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $pengguna = Pengguna::paginate(10); // Gunakan pagination agar daftar pengguna tidak terlalu panjang
        return view('admin.manage-user.show', compact('pengguna'));
    }

    // Menampilkan detail pengguna
    public function show($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('admin.manage-user.show-detail', compact('pengguna'));
    }

    // Menampilkan form untuk membuat pengguna baru
    public function create()
    {
        return view('admin.manage-user.create');
    }

    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'Nama_Pengguna' => 'required',
            'Email_Pengguna' => 'required|email|unique:penggunas',
            'Role_Pengguna' => 'required',
        ]);

        Pengguna::create($request->all());

        return redirect()->route('admin.manage-user.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit pengguna
    public function edit($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('admin.manage-user.edit', compact('pengguna'));
    }

    // Memperbarui pengguna
    public function update(Request $request, $id)
    {
        $request->validate([
            'Nama_Pengguna' => 'required',
            'Email_Pengguna' => 'required|email',
            'Role_Pengguna' => 'required',
        ]);

        $pengguna = Pengguna::findOrFail($id);
        $pengguna->update($request->all());

        return redirect()->route('admin.manage-user.index')->with('success', 'Pengguna berhasil diperbarui');
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('admin.manage-user.index')->with('success', 'Pengguna berhasil dihapus');
    }

    // Menonaktifkan akun pengguna
    public function deactivate($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->update(['is_active' => false]);

        return redirect()->route('admin.manage-user.index')->with('success', 'Pengguna berhasil dinonaktifkan');
    }
}
