<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penggunas')->insert([
            'Nama_Pengguna' => 'Admin Utama',
            'Email_Pengguna' => 'admin@example.com',
            'Password_Pengguna' => Hash::make('admin123'),
            'Alamat_Pengguna' => 'Jl. Admin No. 1',
            'Role_Pengguna' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
