<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penggunas')->insert([
            [
                'Nama_Pengguna' => 'Admin Utama',
                'Email_Pengguna' => 'admin@example.com',
                'Password_Pengguna' => Hash::make('admin123'),
                'Alamat_Pengguna' => 'Jl. Admin No. 1',
                'Role_Pengguna' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Nama_Pengguna' => 'Pengguna Biasa',
                'Email_Pengguna' => 'pengguna@example.com',
                'Password_Pengguna' => Hash::make('pengguna123'),
                'Alamat_Pengguna' => 'Jl. Pengguna No. 2',
                'Role_Pengguna' => 'Pengguna',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}