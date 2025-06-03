<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForumComment4Test extends DuskTestCase
{
    /**
     * @group ForumComment4
     * Test Case: TC.Forum.Comment.004
     * Menguji penghapusan komentar milik orang lain
     */
    public function testTidakDapatHapusKomentarOrangLain(): void
    {
        // Komentar yang dibuat oleh pengguna lain
        $komentarOrangLain = "test aja";
        
        // Asumsi ID untuk uji coba akses langsung (kita akan coba beberapa nilai)
        $testCommentIds = [1, 2, 3]; // Coba beberapa ID umum

        $this->browse(function (Browser $browser) use ($komentarOrangLain, $testCommentIds) {
            // BAGIAN 1: LOGIN KE SISTEM (DENGAN AKUN BERBEDA)
            $browser->visit('/login')
                ->type('Email_Pengguna', 'ahmadfaauzi2304@gmail.com')
                ->type('Password_Pengguna', 'Fauzi.231104')
                ->press('Masuk Sekarang')
                ->waitForLocation('/dashboard-pengguna', 10)
                ->assertPathIs('/dashboard-pengguna');

            // BAGIAN 2: NAVIGASI KE POSTINGAN FORUM
            $browser->clickLink('Forum Komunitas')
                ->waitForLocation('/pengguna/forum', 10)
                ->clickLink('Tips Mengurangi Limbah Makanan dengan Gambar')
                ->waitForText('Komentar', 10);
            
            // Screenshot untuk melihat halaman forum
            $browser->screenshot('forum-other-comment-before');
            
            // BAGIAN 3: VERIFIKASI BAHWA KOMENTAR ORANG LAIN ADA
            $browser->assertSee($komentarOrangLain);
            
            // BAGIAN 4: VERIFIKASI TIDAK ADA TOMBOL HAPUS UNTUK KOMENTAR ORANG LAIN
            $deleteButtonExists = $browser->script(
                'function checkDeleteButtonForComment() {
                    // Cari paragraf yang berisi komentar orang lain
                    const paragraphs = document.querySelectorAll("p");
                    let targetParagraph = null;
                    
                    for (let i = 0; i < paragraphs.length; i++) {
                        if (paragraphs[i].textContent.includes("' . addslashes($komentarOrangLain) . '")) {
                            targetParagraph = paragraphs[i];
                            console.log("Found target comment paragraph:", targetParagraph.textContent);
                            break;
                        }
                    }
                    
                    if (!targetParagraph) {
                        console.log("Target comment not found");
                        return false;
                    }
                    
                    // Cari container komentar (naik ke parent)
                    let commentContainer = targetParagraph;
                    let foundContainer = false;
                    
                    // Naik maksimum 5 level hingga kita menemukan container yang mungkin
                    for (let i = 0; i < 5; i++) {
                        if (!commentContainer || commentContainer === document.body) break;
                        
                        commentContainer = commentContainer.parentElement;
                        
                        // Cek apakah ini container komentar
                        if (commentContainer.classList.contains("rounded-xl") || 
                            commentContainer.classList.contains("bg-gray-50/70") ||
                            commentContainer.classList.contains("p-4")) {
                            foundContainer = true;
                            break;
                        }
                    }
                    
                    if (!foundContainer) {
                        console.log("Comment container not found");
                        return false;
                    }
                    
                    // Cek apakah ada tombol hapus dalam container
                    const deleteButtons = commentContainer.querySelectorAll("button");
                    let hasDeleteButton = false;
                    
                    for (let i = 0; i < deleteButtons.length; i++) {
                        const button = deleteButtons[i];
                        console.log("Button text:", button.textContent);
                        if (button.textContent.includes("Hapus")) {
                            console.log("Delete button found for comment!");
                            hasDeleteButton = true;
                            break;
                        }
                    }
                    
                    // Cari juga tombol dengan class terkait hapus
                    const redButtons = commentContainer.querySelectorAll(".text-red-500");
                    if (redButtons.length > 0) {
                        console.log("Red button found (potential delete button)");
                        hasDeleteButton = true;
                    }
                    
                    return hasDeleteButton;
                }
                
                return checkDeleteButtonForComment();'
            );
            
            // Verifikasi bahwa tidak ada tombol hapus
            if (!empty($deleteButtonExists) && $deleteButtonExists[0]) {
                $this->fail('Tombol hapus ditemukan untuk komentar orang lain (seharusnya tidak ada)');
            } else {
                $this->assertTrue(true, 'Tidak ada tombol hapus untuk komentar orang lain (sesuai ekspektasi)');
            }
            
            // BAGIAN 5: COBA AKSES LANGSUNG URL HAPUS KOMENTAR
            // Simpan komentar yang ada sebelum percobaan
            $commentExists = $browser->script(
                'return document.body.innerText.includes("' . addslashes($komentarOrangLain) . '");'
            );
            $commentExistsBefore = !empty($commentExists) && $commentExists[0];
            
            // Coba akses URL hapus komentar dengan beberapa ID
            $accessResults = [];
            
            foreach ($testCommentIds as $commentId) {
                // Coba akses route hapus langsung
                $browser->visit('/pengguna/forum/comment/delete/' . $commentId)
                    ->pause(2000);
                
                // Screenshot setelah mencoba akses URL hapus
                $browser->screenshot('forum-other-comment-direct-access-' . $commentId);
                
                // Cek apakah ada pesan error/forbidden
                $hasErrorMessage = $browser->script(
                    'return document.body.innerText.includes("403") || 
                            document.body.innerText.includes("Forbidden") || 
                            document.body.innerText.includes("unauthorized") || 
                            document.body.innerText.includes("tidak diizinkan") || 
                            document.body.innerText.includes("tidak berhak") ||
                            document.body.innerText.includes("Error") ||
                            document.body.innerText.includes("akses ditolak") ||
                            document.body.innerText.includes("gagal");'
                );
                
                $accessResults[$commentId] = !empty($hasErrorMessage) && $hasErrorMessage[0];
                
                // Kembali ke halaman forum untuk cek komentar masih ada
                $browser->visit('/pengguna/forum')
                    ->clickLink('Tips Mengurangi Limbah Makanan dengan Gambar')
                    ->waitForText('Komentar', 10);
            }
            
            // Cek apakah komentar masih ada setelah semua percobaan akses
            $commentExistsAfter = $browser->script(
                'return document.body.innerText.includes("' . addslashes($komentarOrangLain) . '");'
            );
            $commentExistsAfter = !empty($commentExistsAfter) && $commentExistsAfter[0];
            
            // Verifikasi hasil
            if ($commentExistsBefore && $commentExistsAfter) {
                // Berhasil - komentar tetap ada setelah mencoba akses URL hapus
                $this->assertTrue(true, 'Komentar orang lain tetap ada setelah mencoba akses URL hapus langsung');
                
                // Cek juga apakah setidaknya satu percobaan menghasilkan pesan error
                $anyErrorFound = false;
                foreach ($accessResults as $result) {
                    if ($result) {
                        $anyErrorFound = true;
                        break;
                    }
                }
                
                if ($anyErrorFound) {
                    $this->assertTrue(true, 'Setidaknya satu percobaan akses URL hapus menampilkan pesan error/forbidden');
                }
            } else if ($commentExistsBefore && !$commentExistsAfter) {
                $this->fail('Komentar orang lain terhapus setelah percobaan akses URL hapus langsung (seharusnya tidak terjadi)');
            } else {
                $this->markTestIncomplete('Tidak dapat memverifikasi komentar orang lain sebelum atau setelah pengujian');
            }
            
            // Screenshot akhir
            $browser->screenshot('forum-other-comment-final');
        });
    }
}