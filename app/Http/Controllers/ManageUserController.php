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

    // Method lain untuk create, edit, delete akan ditambahkan nantinya
}


// coba commit lagi FS-55