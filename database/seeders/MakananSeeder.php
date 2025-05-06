<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Makanan;
use App\Models\Pengguna;
use Carbon\Carbon;

class MakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendapatkan ID user dengan role Donatur
        $donaturId = Pengguna::where('Role_Pengguna', 'Donatur')->first()->id_user ?? 1;

        $makananData = [
            [
                'Nama_Makanan' => 'Nasi Goreng',
                'Jumlah_Makanan' => 5,
                'Status_Makanan' => 'Tersedia',
                'id_user' => $donaturId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Nama_Makanan' => 'Mie Ayam',
                'Jumlah_Makanan' => 3,
                'Status_Makanan' => 'Tersedia',
                'id_user' => $donaturId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Nama_Makanan' => 'Soto Ayam',
                'Jumlah_Makanan' => 0,
                'Status_Makanan' => 'Habis',
                'id_user' => $donaturId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Nama_Makanan' => 'Gado-gado',
                'Jumlah_Makanan' => 0,
                'Status_Makanan' => 'Habis',
                'id_user' => $donaturId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($makananData as $makanan) {
            Makanan::create($makanan);
        }
    }
}
