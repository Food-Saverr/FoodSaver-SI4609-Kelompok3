<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Forum;
use Carbon\Carbon;

class ForumSeeder extends Seeder
{
    public function run()
    {
        // Sample forum data with different creation dates
        $forums = [
            [
                'judul' => 'Tips Menyimpan Makanan dengan Baik',
                'deskripsi' => 'Diskusi tentang cara menyimpan makanan agar tetap segar dan tahan lama.',
                'is_active' => true,
                'created_at' => Carbon::now()->subMonths(3)
            ],
            [
                'judul' => 'Ide Menu dari Sisa Makanan',
                'deskripsi' => 'Bagikan ide kreatif untuk mengolah sisa makanan menjadi menu baru.',
                'is_active' => true,
                'created_at' => Carbon::now()->subMonths(2)
            ],
            [
                'judul' => 'Cara Mengurangi Food Waste',
                'deskripsi' => 'Diskusi tentang strategi mengurangi pemborosan makanan.',
                'is_active' => true,
                'created_at' => Carbon::now()->subMonth()
            ],
            [
                'judul' => 'Pengalaman Berbagi Makanan',
                'deskripsi' => 'Ceritakan pengalaman Anda dalam berbagi makanan dengan sesama.',
                'is_active' => false,
                'created_at' => Carbon::now()->subWeeks(2)
            ],
            [
                'judul' => 'Resep dari Bahan Sisa',
                'deskripsi' => 'Bagikan resep kreatif menggunakan bahan sisa.',
                'is_active' => true,
                'created_at' => Carbon::now()->subWeek()
            ]
        ];

        foreach ($forums as $forum) {
            Forum::create($forum);
        }
    }
} 