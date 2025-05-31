<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\Pengguna;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ArtikelSeeder extends Seeder
{
    public function run()
    {
        // Hapus semua data artikel yang ada
        DB::table('artikels')->truncate();

        // Dapatkan ID admin
        $admin = Pengguna::where('Role_Pengguna', 'Admin')->first();

        if ($admin) {
            $artikels = [
                [
                    'judul' => 'Tips Mengurangi Limbah Makanan',
                    'konten' => 'Berikut adalah beberapa tips praktis untuk mengurangi limbah makanan di rumah Anda:

1. Rencanakan Menu Mingguan
- Buat daftar belanja sesuai kebutuhan
- Periksa stok makanan yang ada
- Beli bahan sesuai porsi yang dibutuhkan

2. Simpan Makanan dengan Benar
- Gunakan wadah kedap udara
- Atur suhu kulkas dengan tepat
- Kelompokkan makanan berdasarkan jenis

3. Manfaatkan Sisa Makanan
- Olah menjadi menu baru
- Bekukan untuk penggunaan nanti
- Bagikan ke yang membutuhkan

4. Perhatikan Tanggal Kedaluwarsa
- Atur makanan berdasarkan tanggal kedaluwarsa
- Gunakan metode FIFO (First In First Out)
- Periksa secara berkala

Dengan menerapkan tips-tips di atas, kita bisa mengurangi limbah makanan dan berkontribusi pada lingkungan yang lebih baik.',
                    'gambar' => 'artikel/tips-kurangi-limbah.jpg'
                ],
                [
                    'judul' => 'Manfaat Berbagi Makanan',
                    'konten' => 'Berbagi makanan tidak hanya membantu sesama tetapi juga memberikan manfaat bagi lingkungan dan masyarakat:

1. Manfaat Sosial
- Membantu mereka yang membutuhkan
- Mempererat tali persaudaraan
- Menciptakan lingkungan yang peduli

2. Manfaat Lingkungan
- Mengurangi limbah makanan
- Menurunkan emisi gas rumah kaca
- Mengoptimalkan sumber daya

3. Manfaat Ekonomi
- Menghemat pengeluaran
- Mengurangi biaya pengelolaan sampah
- Mendorong ekonomi berkelanjutan

4. Manfaat Kesehatan
- Makanan segar lebih cepat terdistribusi
- Mengurangi risiko kontaminasi
- Mendorong pola makan sehat

Mari kita mulai berbagi makanan dan ciptakan dampak positif bagi masyarakat dan lingkungan.',
                    'gambar' => 'artikel/manfaat-berbagi.jpg'
                ],
                [
                    'judul' => 'Cara Menyimpan Makanan dengan Benar',
                    'konten' => 'Menyimpan makanan dengan benar adalah kunci untuk menjaga kualitas dan keamanan pangan. Berikut panduan lengkapnya:

1. Penyimpanan di Kulkas
- Suhu ideal: 1-4°C
- Pisahkan makanan mentah dan matang
- Gunakan wadah tertutup
- Atur rak sesuai jenis makanan

2. Penyimpanan di Freezer
- Suhu ideal: -18°C
- Bungkus dengan rapat
- Beri label tanggal
- Jangan membekukan ulang

3. Penyimpanan di Suhu Ruang
- Simpan di tempat kering dan sejuk
- Hindari paparan sinar matahari
- Gunakan wadah kedap udara
- Perhatikan tanggal kedaluwarsa

4. Tips Tambahan
- Bersihkan kulkas secara berkala
- Periksa kualitas makanan
- Atur stok dengan baik
- Buat sistem rotasi makanan

Dengan menyimpan makanan dengan benar, kita bisa:
- Memperpanjang umur simpan
- Mencegah pembusukan
- Menghemat pengeluaran
- Menjaga kualitas nutrisi',
                    'gambar' => 'artikel/cara-simpan-makanan.jpg'
                ]
            ];

            foreach ($artikels as $artikel) {
                // Generate slug unik
                $slug = Str::slug($artikel['judul']);
                $originalSlug = $slug;
                $counter = 1;

                // Cek jika slug sudah ada, tambahkan angka di belakangnya
                while (Artikel::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                Artikel::create([
                    'judul' => $artikel['judul'],
                    'slug' => $slug,
                    'konten' => $artikel['konten'],
                    'gambar' => $artikel['gambar'],
                    'user_id' => $admin->id_user
                ]);
            }
        }
    }
}
