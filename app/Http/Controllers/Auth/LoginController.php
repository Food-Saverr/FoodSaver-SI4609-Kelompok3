<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $credentials = $request->validate([
            'Email_Pengguna' => 'required|email',
            'Password_Pengguna' => 'required'
        ]);

        if (Auth::attempt([
            'Email_Pengguna' => $credentials['Email_Pengguna'],
            'Password_Pengguna' => $credentials['Password_Pengguna']
        ])) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->Role_Pengguna === 'Admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->Role_Pengguna === 'Donatur') {
                return redirect()->route('dashboard.donatur');
            } else {
                return redirect()->route('dashboard.pengguna');
            }
        }

        return back()->withErrors([
            'Email_Pengguna' => 'Email atau password yang dimasukkan salah.',
        ])->withInput($request->only('Email_Pengguna'));
    }

    // Fitur logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}