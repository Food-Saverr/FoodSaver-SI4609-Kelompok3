<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegisterForm(){
        return view('auth.registrasi');
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'Nama_Pengguna'    => 'required|string|max:255',
            'Email_Pengguna'   => 'required|email|unique:penggunas,Email_Pengguna',
            'Password_Pengguna'=> [
                'required', 'string', 'min:8', 'max:12',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[\W]/'
            ],
            'Alamat_Pengguna'  => 'required|string',
        ]);

        // TODO: Ubah validasi registrasi ke dalam bentuk alert atau pop up!
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $pengguna = Pengguna::create([
            'Nama_Pengguna'    => $request->Nama_Pengguna,
            'Email_Pengguna'   => $request->Email_Pengguna,
            'Password_Pengguna'=> Hash::make($request->Password_Pengguna),
            'Alamat_Pengguna'  => $request->Alamat_Pengguna,
            'Role_Pengguna'    => 'Pengguna',
        ]);

        // TODO: Kalau validasi dalam bentuk alert atau pop up sudah selesai, debugging dalam bentuk JSON bisa dihapus!
        return response()->json([
            'message' => 'Registrasi berhasil!',
            'user'    => $pengguna
        ], 201);
    }
}

