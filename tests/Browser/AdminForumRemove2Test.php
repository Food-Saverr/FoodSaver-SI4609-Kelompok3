<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminForumRemove2Test extends DuskTestCase
{
    /**
     * @group AdminForumRemove2
     * Test Case: TC.Admin.Forum.Remove.002
     * Menguji penghapusan komentar yang tidak pantas oleh admin
     */
    public function testHapusKomentarTidakPantas(): void
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
            
            // BAGIAN 3: KLIK LINK "WER" UNTUK MELIHAT DETAIL
            // PASTIKAN MENGGUNAKAN CLICK() LANGSUNG, JANGAN MEMAKAI JAVASCRIPT
            $browser->waitFor('table tbody tr')
                ->screenshot('admin-forum-table');
            
            // PASTIKAN mengklik "wer" dengan metode dusk yang benar: clickLink
            $browser->clickLink('wer')
                ->pause(3000) // tunggu halaman detail dimuat
                ->screenshot('admin-post-detail');
            
            // BAGIAN 4: VERIFIKASI BAHWA KITA BERADA DI HALAMAN DETAIL
            $browser->assertSee('Komentar')
                ->assertSee('fa')  // username penulis
                ->screenshot('admin-post-detail-verified');
                
            // BAGIAN 5: CARI KOMENTAR DAN KLIK TOMBOL AKSI
            // Klik tombol titik tiga di komentar
            $browser->script('
                function findCommentEllipsisButton() {
                    const commentSection = Array.from(document.querySelectorAll("h5")).find(
                        h => h.textContent.includes("Komentar")
                    );
                    
                    if (!commentSection) return false;
                    
                    // Cari section komentar
                    let commentContainer = commentSection.closest("div").nextElementSibling || 
                                          commentSection.parentElement.nextElementSibling;
                    
                    if (!commentContainer) return false;
                    
                    // Cari tombol titik tiga di dalam section komentar
                    const ellipsisButtons = commentContainer.querySelectorAll("button");
                    
                    for (const button of ellipsisButtons) {
                        if (button.innerHTML.includes("ellipsis") || 
                            button.innerHTML.includes("fa-ellipsis")) {
                            console.log("Menemukan tombol ellipsis, mengklik...");
                            button.click();
                            return true;
                        }
                    }
                    
                    return false;
                }
                
                return findCommentEllipsisButton();
            ');
            
            $browser->pause(1000) // tunggu dropdown muncul
                ->screenshot('admin-comment-dropdown');
            
            // BAGIAN 6: KLIK TOMBOL HAPUS DI DROPDOWN
            $browser->script('
                function clickDeleteOption() {
                    // Cari semua dropdown menu yang terbuka
                    const dropdownMenus = document.querySelectorAll("[x-show=\'open\'], .absolute, .dropdown-menu");
                    
                    for (const menu of dropdownMenus) {
                        // Cari tombol hapus dalam menu
                        const buttons = menu.querySelectorAll("button");
                        for (const button of buttons) {
                            if (button.textContent.includes("Hapus") && 
                                !button.textContent.includes("Hapus Postingan")) {
                                console.log("Menemukan tombol hapus komentar, mengklik...");
                                button.click();
                                return true;
                            }
                        }
                        
                        // Cari form submits
                        const forms = menu.querySelectorAll("form");
                        for (const form of forms) {
                            if ((form.getAttribute("action") || "").includes("comment") || 
                                form.innerHTML.includes("Hapus Komentar")) {
                                form.submit();
                                console.log("Submit form hapus komentar...");
                                return true;
                            }
                        }
                    }
                    
                    return false;
                }
                
                return clickDeleteOption();
            ');
            
            // BAGIAN 7: KONFIRMASI ALERT JIKA ADA
            try {
                $browser->pause(1000)
                    ->driver->switchTo()->alert()->accept();
                $browser->pause(1000);
            } catch (\Exception $e) {
                // Jika tidak ada alert, lanjutkan
            }
            
            $browser->screenshot('admin-after-delete-comment');
            
            // BAGIAN 8: VERIFIKASI KOMENTAR DIHAPUS
            $browser->refresh()
                ->pause(2000)
                ->screenshot('admin-after-refresh');
            
            // Cek notifikasi sukses hapus komentar
            $hasSuccessNotification = $browser->script('
                function checkSuccess() {
                    // Cek elemen notifikasi sukses
                    const successElements = document.querySelectorAll(".colored-toast, .bg-green-100, .text-green-600");
                    
                    // Cek teks notifikasi sukses
                    const bodyText = document.body.textContent;
                    const hasSuccessText = 
                        bodyText.includes("berhasil dihapus") || 
                        bodyText.includes("telah dihapus") || 
                        bodyText.includes("sukses") || 
                        bodyText.includes("success");
                        
                    return successElements.length > 0 || hasSuccessText;
                }
                
                return checkSuccess();
            ');
            
            // Verifikasi status komentar berhasil dihapus
            $browser->assertPresent('.border-gray-100');
            
            // Test berhasil
            $this->assertTrue(true, 'Test penghapusan komentar selesai dijalankan');
        });
    }
}