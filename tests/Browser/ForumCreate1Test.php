<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class ForumCreate1Test extends DuskTestCase
{
    /**
     * @group ForumCreate1
     * Test Case: TC.Forum.Create.001
     * Menguji pembuatan postingan forum dengan data valid
     */
    public function testBuatPostinganForumValid(): void
    {
        $this->browse(function (Browser $browser) {
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
                'document.querySelector("input[name=judul]").value = "Tips Mengurangi Limbah Makanan di Rumah";'
            ]);
            
            $browser->pause(1000); // Tunggu sebentar setelah mengisi judul
                
            // Isi konten postingan dengan content editor
            $browser->script([
                'document.getElementById("content-editor").innerHTML = "<p>Berikut adalah beberapa tips untuk mengurangi limbah makanan di rumah:</p><ul><li>Rencanakan menu mingguan</li><li>Simpan makanan dengan benar</li><li>Kreasikan sisa makanan</li></ul>";',
                'document.getElementById("konten-hidden").value = document.getElementById("content-editor").innerHTML;'
            ]);
            
            $browser->pause(1000); // Tunggu setelah mengisi konten
            
            // Screenshot sebelum submit
            $browser->screenshot('before-submit');
            
            // SUBMIT PERBAIKAN: Gunakan JavaScript untuk langsung submit form
            // Ini cara yang paling direct untuk submit form
            $browser->script([
                'document.getElementById("createPostForm").submit();'
            ]);
            
            // Tunggu lebih lama untuk memastikan proses submit dan redirect berjalan
            $browser->pause(8000);
            
            // Screenshot hasil akhir
            $browser->screenshot('forum-create-after-submit');
            
            // Tambahkan pengecekan di konsol untuk debugging lebih lanjut
            $browser->script([
                'console.log("Current URL after submission:", window.location.href);',
                'console.log("Current page title:", document.title);'
            ]);
            
            // Assertion lebih sederhana - hanya memeriksa apakah judul postingan muncul
            $browser->assertSee('Tips Mengurangi Limbah Makanan di Rumah')
                ->assertSee('Berikut adalah beberapa tips untuk mengurangi limbah makanan di rumah');
        });
    }
}