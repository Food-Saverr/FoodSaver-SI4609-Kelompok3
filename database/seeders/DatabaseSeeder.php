<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        DB::table('penggunas')->insert([
            'Nama_Pengguna' => 'Admin Utama',
            'Email_Pengguna' => 'admin@example.com',
            'Password_Pengguna' => Hash::make('admin123'),
            'Alamat_Pengguna' => 'Jl. Admin No. 1',
            'Role_Pengguna' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create donatur user
        DB::table('penggunas')->insert([
            'Nama_Pengguna' => 'Donatur Test',
            'Email_Pengguna' => 'donatur@example.com',
            'Password_Pengguna' => Hash::make('donatur123'),
            'Alamat_Pengguna' => 'Jl. Donatur No. 1',
            'Role_Pengguna' => 'Donatur',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Run other seeders
        $this->call([
            PenggunaSeeder::class,
            MakananSeeder::class,
            ArtikelSeeder::class,
            ForumSeeder::class,
        ]);
    }
}
