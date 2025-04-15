<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MakananSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('makanans')->insert([
            'Nama_Makanan' => 'Roti Tawar',
            'Deskripsi_Makanan' => 'Roti tawar sisa toko, masih layak konsumsi',
            'Kategori_Makanan' => 'Roti',
            'Status_Makanan' => 'Tersedia',
            'Tanggal_Kedaluwarsa' => now()->addDays(2),
            'Lokasi_Makanan' => 'Bandung',
            'ID_Pengguna' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
