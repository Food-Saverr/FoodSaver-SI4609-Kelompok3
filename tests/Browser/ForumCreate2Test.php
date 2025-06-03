<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class ForumCreate2Test extends DuskTestCase
{
    /**
     * @group ForumCreate2
     * Test Case: TC.Forum.Create.002
     * Menguji pembuatan postingan forum dengan lampiran
     */
    public function testBuatPostinganForumDenganLampiran(): void
    {
        // Tentukan path ke file gambar di folder Downloads (menyesuaikan OS)
        $imagePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' 
            ? getenv('USERPROFILE') . '\Downloads\testppl.jpg'
            : getenv('HOME') . '/Downloads/testppl.jpg');

        // Pastikan file gambar tersedia sebelum test dijalankan
        if (!file_exists($imagePath)) {
            throw new \Exception('Image file does not exist at: ' . $imagePath);
        }

        $this->browse(function (Browser $browser) use ($imagePath) {
            // Login sebagai user biasa
            $browser->visit('/login')
                ->type('Email_Pengguna', 'ahmadfaauzi2304@gmail.com')    // Isi email pengguna
                ->type('Password_Pengguna', 'Fauzi.231104')    // Isi password pengguna
                ->press('Masuk Sekarang')                     // Tekan tombol login
                ->waitForLocation('/dashboard-pengguna', 10)  // Tunggu redirect ke dashboard
                ->assertPathIs('/dashboard-pengguna');         // Pastikan sudah di dashboard pengguna
                
            // Klik link untuk ke halaman Forum
            $browser->clickLink('Forum Komunitas')
                ->waitForLocation('/pengguna/forum', 10)      // Tunggu halaman forum tampil
                ->assertPathIs('/pengguna/forum');             // Pastikan sudah di halaman forum
                
            // Klik tombol untuk membuat postingan baru
            $browser->clickLink('Buat Postingan Baru')
                ->waitForLocation('/pengguna/forum/create', 10) // Tunggu halaman buat postingan tampil
                ->assertPathIs('/pengguna/forum/create')      // Pastikan sudah di halaman buat postingan
                ->assertSee('Tulis Postingan Baru');           // Pastikan judul form tampil
                
            // Gunakan JavaScript sederhana untuk mengisi nilai input judul
            $browser->script([
                'document.querySelector("input[name=judul]").value = "Tips Mengurangi Limbah Makanan dengan Gambar";'
            ]);
            
            $browser->pause(1000); // Tunggu sebentar setelah mengisi judul
                
            // Isi konten postingan dengan content editor
            $browser->script([
                'document.getElementById("content-editor").innerHTML = "<p>Berikut adalah beberapa tips dengan gambar ilustrasi untuk mengurangi limbah makanan di rumah:</p><ul><li>Rencanakan menu mingguan</li><li>Simpan makanan dengan benar</li><li>Kreasikan sisa makanan</li></ul>";',
                'document.getElementById("konten-hidden").value = document.getElementById("content-editor").innerHTML;'
            ]);
            
            $browser->pause(1000); // Tunggu setelah mengisi konten
            
            // Lampirkan file gambar
            $browser->attach('attachments[]', $imagePath)
                ->pause(3000); // Tunggu proses upload selesai
                
            // Screenshot sebelum submit
            $browser->screenshot('forum-create-with-attachment');
            
            // Submit form menggunakan JavaScript (metode yang berhasil sebelumnya)
            $browser->script([
                'document.getElementById("createPostForm").submit();'
            ]);
            
            // Tunggu lebih lama untuk memastikan proses submit dan redirect berjalan
            $browser->pause(8000);
            
            // Screenshot hasil akhir
            $browser->screenshot('forum-create-with-attachment-after-submit');
            
            // Tambahkan pengecekan di konsol untuk debugging lebih lanjut
            $browser->script([
                'console.log("Current URL after submission:", window.location.href);',
                'console.log("Current page title:", document.title);'
            ]);
            
            // Assertions untuk memeriksa keberhasilan
            $browser->assertSee('Tips Mengurangi Limbah Makanan dengan Gambar')
                ->assertSee('Berikut adalah beberapa tips dengan gambar ilustrasi')
                // Memeriksa apakah lampiran muncul (biasanya melalui elemen yang mengandung nama file atau teks terkait lampiran)
                ->assertSee('testppl.jpg') // Memeriksa apakah nama file muncul
                ->assertPresent('img'); // Memeriksa apakah ada elemen gambar
        });
    }
}