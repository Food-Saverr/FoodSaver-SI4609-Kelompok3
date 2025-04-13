<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses request login.
     */
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'Email_Pengguna'   => 'required|email',
            'Password_Pengguna'=> 'required|string',
        ]);

        // Cari pengguna berdasarkan email
        $user = Pengguna::where('Email_Pengguna', $request->Email_Pengguna)->first();

        // Jika user ditemukan dan password cocok
        if ($user && Hash::check($request->Password_Pengguna, $user->Password_Pengguna)) {
            // Lakukan autentikasi menggunakan sistem session Laravel
            Auth::login($user, $request->has('remember'));

            // Cek role pengguna untuk menentukan redirect yang sesuai
            if ($user->Role_Pengguna === 'Pengguna') {
                // TODO: Ganti '/dashboard-user' dengan route/view untuk pengguna
                return redirect()->intended('/dashboard-user');
            } elseif ($user->Role_Pengguna === 'Admin') {
                // TODO: Ganti '/dashboard-admin' dengan route/view untuk admin
                return redirect()->intended('/dashboard-admin');
            }
            // Fallback redirect jika role tidak diketahui
            return redirect()->intended('/');
        }

        // TODO: Jika autentikasi gagal, redirect kembali dengan error pop-up!
        return redirect()->back()->withErrors([
            'Email_Pengguna' => 'Email atau Password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
