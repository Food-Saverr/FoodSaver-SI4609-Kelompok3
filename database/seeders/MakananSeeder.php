<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Makanan;
use App\Models\User;
use Carbon\Carbon;

class MakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
<<<<<<< HEAD
        // Mendapatkan ID user dengan role Donatur
=======
>>>>>>> 7bb7304eb8bf3ff2bd53c44e09cfb991043359ab
        $donaturId = User::where('Role_Pengguna', 'Donatur')->first()->id ?? 1;

        $makananData = [
            [
                'Nama_Makanan' => 'Nasi Goreng',
                'Jumlah_Tersedia' => 5,
                'Jumlah_Didonasi' => 0,
                'user_id' => $donaturId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Nama_Makanan' => 'Mie Ayam',
                'Jumlah_Tersedia' => 3,
                'Jumlah_Didonasi' => 0,
                'user_id' => $donaturId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Nama_Makanan' => 'Soto Ayam',
                'Jumlah_Tersedia' => 0,
                'Jumlah_Didonasi' => 4,
                'user_id' => $donaturId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Nama_Makanan' => 'Gado-gado',
                'Jumlah_Tersedia' => 0,
                'Jumlah_Didonasi' => 2,
                'user_id' => $donaturId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($makananData as $makanan) {
            Makanan::create($makanan);
        }
    }
} 