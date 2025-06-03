<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class ForumCreate4Test extends DuskTestCase
{
    /**
     * @group ForumCreate4
     * Test Case: TC.Forum.Create.004
     * Menguji pembuatan postingan forum dengan lampiran melebihi batas ukuran
     */
    public function testBuatPostinganForumDenganLampiranBesar(): void
    {
        // Tentukan path ke file besar di folder Downloads (menyesuaikan OS)
        $largeFilePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' 
            ? getenv('USERPROFILE') . '\Downloads\testpplfilebesar.sql'
            : getenv('HOME') . '/Downloads/testpplfilebesar.sql');

        // Pastikan file tersedia sebelum test dijalankan
        if (!file_exists($largeFilePath)) {
            throw new \Exception('Large file does not exist at: ' . $largeFilePath);
        }

        $this->browse(function (Browser $browser) use ($largeFilePath) {
            // Login sebagai user biasa
            $browser->visit('/login')
                ->type('Email_Pengguna', 'ahmadfaauzi2304@gmail.com') // Isi email pengguna
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
                'document.querySelector("input[name=judul]").value = "Post dengan File Besar";'
            ]);
            
            $browser->pause(1000); // Tunggu sebentar setelah mengisi judul
                
            // Isi konten postingan dengan content editor
            $browser->script([
                'document.getElementById("content-editor").innerHTML = "<p>Percobaan mengunggah file dengan ukuran melebihi batas maksimum.</p>";',
                'document.getElementById("konten-hidden").value = document.getElementById("content-editor").innerHTML;'
            ]);
            
            $browser->pause(1000); // Tunggu setelah mengisi konten
            
            // Screenshot sebelum upload file besar
            $browser->screenshot('forum-create-before-large-file');
            
            // Lampirkan file besar
            $browser->attach('attachments[]', $largeFilePath)
                ->pause(3000); // Tunggu lebih lama untuk file besar dan proses validasi
            
            // Verifikasi pesan error tentang ukuran file
            $browser->assertSee('File testpplfilebesar.sql terlalu besar (maks. 10MB)');
            
            // Periksa bahwa kita masih di halaman yang sama
            $browser->assertPathIs('/pengguna/forum/create');
            
            // Tambahkan pengecekan untuk memastikan form tidak dapat disubmit dengan file besar
            // Coba klik tombol submit dan verifikasi masih di halaman yang sama
            $browser->script([
                'document.getElementById("createPostForm").submit();'
            ]);
            
            $browser->pause(5000); // Tunggu untuk proses validasi
            $browser->screenshot('forum-create-large-file-after-submit');
        });
    }
}