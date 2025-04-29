<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\Pengguna;

class ArtikelSeeder extends Seeder
{
    public function run()
    {
        // Dapatkan ID admin
        $admin = Pengguna::where('Role_Pengguna', 'Admin')->first();

        if ($admin) {
            // Artikel yang dipublikasikan
            Artikel::create([
                'judul' => 'Tips Mengurangi Limbah Makanan',
                'konten' => 'Berikut adalah beberapa tips untuk mengurangi limbah makanan di rumah Anda...',
                'status' => 'dipublikasikan',
                'user_id' => $admin->ID_Pengguna
            ]);

            Artikel::create([
                'judul' => 'Manfaat Berbagi Makanan',
                'konten' => 'Berbagi makanan tidak hanya membantu sesama tetapi juga memberikan manfaat bagi lingkungan...',
                'status' => 'dipublikasikan',
                'user_id' => $admin->ID_Pengguna
            ]);

            // Artikel draft
            Artikel::create([
                'judul' => 'Cara Menyimpan Makanan dengan Benar',
                'konten' => 'Draft artikel tentang cara menyimpan makanan...',
                'status' => 'draft',
                'user_id' => $admin->ID_Pengguna
            ]);
        }
    }
} 