<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForumSearch1Test extends DuskTestCase
{
    /**
     * @group ForumSearch1
     * Test Case: TC.Forum.Search.001
     * Menguji pencarian dengan kata kunci yang ada
     */
    public function testPencarianDenganKataKunciYangAda(): void
    {
        $this->browse(function (Browser $browser) {
            // Kata kunci yang akan dicari yang terdapat dalam judul postingan
            $keyword = 'Tips Mengurangi';
            
            // BAGIAN 1: LOGIN KE SISTEM
            $browser->visit('/login')
                ->type('Email_Pengguna', 'ahmadfaauzi2304@gmail.com')
                ->type('Password_Pengguna', 'Fauzi.231104')
                ->press('Masuk Sekarang')
                ->waitForLocation('/dashboard-pengguna', 10)
                ->assertPathIs('/dashboard-pengguna');

            // BAGIAN 2: NAVIGASI KE HALAMAN FORUM
            $browser->clickLink('Forum Komunitas')
                ->waitForLocation('/pengguna/forum', 10)
                ->assertPathIs('/pengguna/forum');
            
            // Screenshot kondisi awal sebelum pencarian
            $browser->screenshot('forum-search-before');
            
            // BAGIAN 3: LAKUKAN PENCARIAN
            // Clear search field terlebih dahulu lalu ketik keyword
            $browser->script("document.getElementById('quickSearch').value = ''");
            $browser->pause(1000);
            $browser->script("document.getElementById('quickSearch').value = '$keyword'");

            // Submit form pencarian
            $browser->script('document.getElementById("quickSearchForm").submit();');
            
            // Tunggu hasil pencarian dimuat
            $browser->pause(3000);
            
            // Screenshot hasil pencarian
            $browser->screenshot('forum-search-results');
            
            // BAGIAN 4: VERIFIKASI HASIL PENCARIAN SEDERHANA
            // Verifikasi halaman berisi text hasil pencarian
            $browser->assertSee('Hasil pencarian untuk:');
            
            // Verifikasi hasil pencarian menampilkan forum yang diharapkan
            $browser->assertSee('Tips Mengurangi Limbah Makanan dengan Gambar');
            
            // Verifikasi URL mengandung parameter pencarian
            $currentUrl = $browser->driver->getCurrentURL();
            $this->assertTrue(
                strpos($currentUrl, 'search=') !== false,
                'URL mengandung parameter pencarian'
            );
        });
    }
}