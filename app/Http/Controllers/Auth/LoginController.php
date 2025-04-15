<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;

class LoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'Email_Pengguna'    => 'required|email',
            'Password_Pengguna' => 'required|string',
        ]);

        // Cari pengguna berdasarkan email
        $user = Pengguna::where('Email_Pengguna', $request->Email_Pengguna)->first();

        if ($user && Hash::check($request->Password_Pengguna, $user->Password_Pengguna)) {
            Auth::login($user, $request->has('remember'));

            // Redirect berdasarkan role
            if ($user->Role_Pengguna === 'Pengguna') {
                return redirect()->route('dashboard.pengguna');
            } elseif ($user->Role_Pengguna === 'Donatur') {
                return redirect()->route('dashboard.donatur');
            } elseif ($user->Role_Pengguna === 'Admin') {
                return redirect()->route('dashboard.admin');
            }
            // Jika role tidak dikenal, arahkan ke landing page atau halaman default
            return redirect()->route('landing');
        }

        return redirect()->back()->withErrors([
            'Email_Pengguna' => 'Email atau Password salah.',
        ])->withInput();
    }

    // Fitur logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}