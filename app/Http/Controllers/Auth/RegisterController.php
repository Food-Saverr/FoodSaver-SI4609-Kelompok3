<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegisterForm(){
        return view('auth.registrasi');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Nama_Pengguna'    => 'required|string|max:255',
            'Email_Pengguna'   => 'required|email|unique:penggunas,Email_Pengguna',
            'Password_Pengguna' => [
                'required',
                'string',
                'min:8',
                'max:12',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[\W]/'
            ],
            'Alamat_Pengguna'  => 'required|string',
            'Role_Pengguna'    => 'required|in:Pengguna,Donatur,Admin',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            $pengguna = Pengguna::create([
                'Nama_Pengguna'    => $request->Nama_Pengguna,
                'Email_Pengguna'   => $request->Email_Pengguna,
                'Password_Pengguna'=> Hash::make($request->Password_Pengguna),
                'Alamat_Pengguna'  => $request->Alamat_Pengguna,
                'Role_Pengguna'    => $request->Role_Pengguna,
            ]);

            // Buat notification preference untuk pengguna baru
            $pengguna->notificationPreference()->create([
                'request_status' => true,
                'new_requests' => true,
                'maintenance' => true,
                'expiration_alerts' => true
            ]);

            DB::commit();

            // Redirect ke halaman login dengan flash message
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])
                ->withInput();
        }
    }
}