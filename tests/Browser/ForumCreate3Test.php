<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class ForumCreate3Test extends DuskTestCase
{
    /**
     * @group ForumCreate3
     * Test Case: TC.Forum.Create.003
     * Menguji validasi input saat pembuatan postingan kosong
     */
    public function testBuatPostinganForumKosong(): void
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
            
            // Pastikan judul dan konten kosong (jika ada nilai default)
            $browser->clear('input[name=judul]');
            $browser->script([
                'document.getElementById("content-editor").innerHTML = "";',
                'document.getElementById("konten-hidden").value = "";'
            ]);
            
            $browser->pause(1000); // Tunggu sebentar setelah mengosongkan form
                
            // Screenshot sebelum submit
            $browser->screenshot('forum-create-empty-before-submit');
            
            // Submit form menggunakan JavaScript
            $browser->script([
                'document.getElementById("createPostForm").submit();'
            ]);
            
            $browser->pause(3000); // Tunggu untuk validasi muncul
            
            // Screenshot setelah mencoba submit
            $browser->screenshot('forum-create-empty-validation');
            
            // Cek apakah validasi muncul dan kita masih di halaman yang sama
            $browser->assertPathIs('/pengguna/forum/create');
            
            // Tambahkan log sederhana untuk debugging
            $browser->script([
                'console.log("Current URL:", window.location.href);',
                'console.log("Form validation triggered:", document.querySelector("input:invalid") !== null);'
            ]);
            
            // Screenshot final
            $browser->screenshot('forum-create-empty-final');
        });
    }
}