<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForumSearch2Test extends DuskTestCase
{
    /**
     * @group ForumSearch2
     * Test Case: TC.Forum.Search.002
     * Menguji pencarian dengan kata kunci yang tidak ada
     */
    public function testPencarianDenganKataKunciYangTidakAda(): void
    {
        $this->browse(function (Browser $browser) {
            // Kata kunci yang tidak terdapat dalam judul atau konten postingan
            $keyword = 'xxx999';
            
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
            $browser->screenshot('forum-search-not-found-before');
            
            // BAGIAN 3: LAKUKAN PENCARIAN DENGAN KATA KUNCI YANG TIDAK ADA
            // Clear search field terlebih dahulu lalu ketik keyword
            $browser->script("document.getElementById('quickSearch').value = ''");
            $browser->pause(1000);
            $browser->script("document.getElementById('quickSearch').value = '$keyword'");

            // Submit form pencarian
            $browser->script('document.getElementById("quickSearchForm").submit();');
            
            // Tunggu hasil pencarian dimuat
            $browser->pause(3000);
            
            // Screenshot hasil pencarian
            $browser->screenshot('forum-search-not-found-results');
            
            // BAGIAN 4: VERIFIKASI HASIL PENCARIAN KOSONG
            // Verifikasi bahwa halaman menampilkan pesan tidak ditemukan hasil
            $expectedText = "Tidak ditemukan hasil pencarian untuk \"$keyword\"";
            
            // Opsi 1: Menggunakan assertSee langsung
            $browser->assertSee($expectedText);
            
            // Opsi 2: Verifikasi dengan JavaScript sebagai backup
            $textExists = $browser->script(
                'function checkForText() {
                    const pageText = document.body.innerText;
                    return pageText.includes("Tidak ditemukan hasil pencarian untuk \"' . $keyword . '\"");
                }
                return checkForText();'
            );
            
            // Pastikan teks ditemukan dalam DOM
            if (!empty($textExists)) {
                $this->assertTrue(
                    $textExists[0], 
                    'Teks "Tidak ditemukan hasil pencarian untuk "' . $keyword . '"" ditampilkan'
                );
            }
        });
    }
}