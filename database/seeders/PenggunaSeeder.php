<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $penggunas = [
            [
                'Nama_Pengguna' => 'Budi Santoso',
                'Email_Pengguna' => 'budi@example.com',
                'Password_Pengguna' => bcrypt('123'),
                'Alamat_Pengguna' => 'Jl. Merdeka No. 10, Jakarta',
                'Role_Pengguna' => 'Pengguna',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Nama_Pengguna' => 'satu',
                'Email_Pengguna' => 'satu@example.com',
                'Password_Pengguna' => bcrypt('123'),
                'Alamat_Pengguna' => 'Jl. Merdeka No. 10, Jakarta',
                'Role_Pengguna' => 'Pengguna',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Nama_Pengguna' => 'Siti Aminah',
                'Email_Pengguna' => 'siti@example.com',
                'Password_Pengguna' => bcrypt('123'),
                'Alamat_Pengguna' => 'Jl. Sudirman No. 25, Bandung',
                'Role_Pengguna' => 'Donatur',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Nama_Pengguna' => 'dua',
                'Email_Pengguna' => 'dua@example.com',
                'Password_Pengguna' => bcrypt('123'),
                'Alamat_Pengguna' => 'Jl. Merdeka No. 10, Jakarta',
                'Role_Pengguna' => 'Donatur',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Nama_Pengguna' => 'Admin Utama',
                'Email_Pengguna' => 'admin@example.com',
                'Password_Pengguna' => bcrypt('123'),
                'Alamat_Pengguna' => 'Jl. Gatot Subroto No. 1, Surabaya',
                'Role_Pengguna' => 'Admin',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('penggunas')->insert($penggunas);
    }
}