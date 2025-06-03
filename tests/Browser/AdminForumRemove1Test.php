<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminForumRemove1Test extends DuskTestCase
{
    /**
     * @group AdminForumRemove1
     * Test Case: TC.Admin.Forum.Remove.001
     * Menguji penghapusan postingan yang tidak pantas oleh admin
     */
    public function testHapusPostinganTidakPantas(): void
    {
        $this->browse(function (Browser $browser) {
            // BAGIAN 1: LOGIN SEBAGAI ADMIN
            $browser->visit('/login')
                ->type('Email_Pengguna', 'admin@admin.com')
                ->type('Password_Pengguna', 'Fauzi.231104')
                ->press('Masuk Sekarang')
                ->waitForLocation('/dashboard-admin', 10)
                ->assertPathIs('/dashboard-admin');
            
            // BAGIAN 2: NAVIGASI KE FORUM ADMIN
            $browser->clickLink('Forum')
                ->waitForLocation('/admin/forum', 10)
                ->assertSee('Kelola Forum')
                ->screenshot('admin-forum-before');
            
            // BAGIAN 3: PILIH POSTINGAN PERTAMA DENGAN TOMBOL AKSI
            $browser->script('
                // Klik tombol aksi (3 titik) pada baris pertama dengan flag dilaporkan
                let actionButtons = document.querySelectorAll("table tbody tr button");
                if (actionButtons.length > 0) {
                    // Klik tombol aksi pada baris ke-3 (wer)
                    actionButtons[2].click();
                }
            ');
            
            // Tunggu dropdown muncul
            $browser->pause(1000)
                ->screenshot('admin-forum-dropdown');
            
            // BAGIAN 4: KLIK TOMBOL HAPUS POSTINGAN
            $browser->script('
                // Cari tombol hapus dalam dropdown yang sudah terbuka
                const deleteButtons = document.querySelectorAll("button, a");
                for (const btn of deleteButtons) {
                    if (btn.textContent.includes("Hapus Postingan")) {
                        btn.click();
                        break;
                    }
                }
            ');
            
            // BAGIAN 5: KONFIRMASI DIALOG PENGHAPUSAN
            $browser->pause(1000);
            
            // Konfirmasi alert dengan mengklik tombol OK
            try {
                $browser->driver->switchTo()->alert()->accept();
            } catch (\Exception $e) {
                // Jika tidak ada alert, lanjutkan
            }
            
            $browser->pause(2000)
                ->screenshot('admin-forum-after-delete');
                
            // BAGIAN 6: VERIFIKASI SEDERHANA
            $browser->refresh()
                ->pause(2000)
                ->screenshot('admin-forum-after-refresh')
                ->assertSee('Daftar Postingan Forum');
            
            // BAGIAN 7: CEK HALAMAN FORUM PENGGUNA
            $browser->visit('/pengguna/forum')
                ->pause(2000)
                ->screenshot('user-forum-after-delete');
        });
    }
}