<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MakananSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('makanans')->insert([
            [
                'Nama_Makanan' => 'Nasi Goreng',
                'Deskripsi_Makanan' => 'Nasi goreng dengan ayam dan telur.',
                'Kategori_Makanan' => 'Makanan Berat',
                'Status_Makanan' => 'Tersedia',
                'Tanggal_Kedaluwarsa' => Carbon::now()->addDays(2),
                'Lokasi_Makanan' => 'Jakarta Selatan',
                'Foto' => 'nasi_goreng.jpg',
                'ID_Pengguna' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Nama_Makanan' => 'Salad Buah',
                'Deskripsi_Makanan' => 'Salad segar dengan berbagai buah tropis.',
                'Kategori_Makanan' => 'Makanan Ringan',
                'Status_Makanan' => 'Tersedia',
                'Tanggal_Kedaluwarsa' => Carbon::now()->addDays(1),
                'Lokasi_Makanan' => 'Bandung',
                'Foto' => 'salad_buah.jpg',
                'ID_Pengguna' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
