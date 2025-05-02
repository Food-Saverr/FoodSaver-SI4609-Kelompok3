<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin exists
        if (!Pengguna::where('Email_Pengguna', 'admin@example.com')->exists()) {
            Pengguna::create([
                'Nama_Pengguna' => 'Admin Utama',
                'Email_Pengguna' => 'admin@example.com',
                'Password_Pengguna' => Hash::make('admin123'),
                'Alamat_Pengguna' => 'Jl. Admin No. 1',
                'Role_Pengguna' => 'Admin',
            ]);
        }

        // Check if regular user exists
        if (!Pengguna::where('Email_Pengguna', 'pengguna@example.com')->exists()) {
            Pengguna::create([
                'Nama_Pengguna' => 'Pengguna Biasa',
                'Email_Pengguna' => 'pengguna@example.com',
                'Password_Pengguna' => Hash::make('pengguna123'),
                'Alamat_Pengguna' => 'Jl. Pengguna No. 2',
                'Role_Pengguna' => 'Pengguna',
            ]);
        }

        // Check if donatur exists
        if (!Pengguna::where('Email_Pengguna', 'donatur@example.com')->exists()) {
            Pengguna::create([
                'Nama_Pengguna' => 'Donatur Aktif',
                'Email_Pengguna' => 'donatur@example.com',
                'Password_Pengguna' => Hash::make('donatur123'),
                'Alamat_Pengguna' => 'Jl. Donatur No. 3',
                'Role_Pengguna' => 'Donatur',
            ]);
        }
    }
}