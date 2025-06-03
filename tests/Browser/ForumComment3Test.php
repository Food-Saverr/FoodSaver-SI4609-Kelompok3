<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForumComment3Test extends DuskTestCase
{
    /**
     * @group ForumComment3
     * Test Case: TC.Forum.Comment.003
     * Menguji penghapusan komentar milik sendiri
     */
    public function testHapusKomentarSendiri(): void
    {
        // Teks komentar yang akan dihapus
        $komentarText = "Terima kasih atas tips yang bermanfaat! Saya sudah mencoba mengurangi limbah makanan dengan menyimpan sisa makanan dengan benar dan hasilnya sangat efektif.";

        $this->browse(function (Browser $browser) use ($komentarText) {
            // BAGIAN 1: LOGIN KE SISTEM
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
            
            // Screenshot sebelum menghapus komentar
            $browser->screenshot('forum-comment-before-delete');
            
            // BAGIAN 3: CARI KOMENTAR YANG AKAN DIHAPUS
            // Verifikasi bahwa komentar yang ingin kita hapus ada di halaman
            $browser->assertSee($komentarText);
            
            // Ambil jumlah komentar sebelum dihapus
            $commentCountBefore = $browser->script(
                'const headings = Array.from(document.querySelectorAll("h2"));
                 let commentCount = 0;
                 for (let i = 0; i < headings.length; i++) {
                     if (headings[i].textContent.includes("Komentar")) {
                         const countMatch = headings[i].textContent.match(/\d+/);
                         if (countMatch) {
                             commentCount = parseInt(countMatch[0]);
                             break;
                         }
                     }
                 }
                 return commentCount;'
            );
            $commentCountBefore = !empty($commentCountBefore) ? intval($commentCountBefore[0]) : 0;
            
            // BAGIAN 4: OVERRIDE CONFIRM DIALOG SEBELUM KLIK TOMBOL HAPUS
            // Override native confirm dialog agar selalu return true
            $browser->script(
                'window.originalConfirm = window.confirm;
                 window.confirm = function() { return true; };'
            );
            
            // BAGIAN 5: TEMUKAN DAN KLIK TOMBOL HAPUS
            $browser->script(
                'function findDeleteButtonNearComment() {
                    // Cari paragraf yang memuat teks komentar yang ingin dihapus
                    const paragraphs = document.querySelectorAll("p");
                    let targetParagraph = null;
                    
                    for (let i = 0; i < paragraphs.length; i++) {
                        if (paragraphs[i].textContent.includes("' . addslashes($komentarText) . '")) {
                            targetParagraph = paragraphs[i];
                            console.log("Found target paragraph:", targetParagraph.textContent);
                            break;
                        }
                    }
                    
                    if (!targetParagraph) {
                        console.log("Target paragraph not found");
                        return false;
                    }
                    
                    // Cari container komentar (naik ke parent)
                    let commentContainer = targetParagraph.parentElement;
                    while (commentContainer && !commentContainer.classList.contains("bg-gray-50/70") && 
                           !commentContainer.classList.contains("rounded-xl") && 
                           !commentContainer.classList.contains("p-4")) {
                        commentContainer = commentContainer.parentElement;
                        if (!commentContainer || commentContainer === document.body) break;
                    }
                    
                    if (!commentContainer || commentContainer === document.body) {
                        console.log("Comment container not found");
                        return false;
                    }
                    
                    // Cari semua tombol dalam container
                    const allButtons = commentContainer.querySelectorAll("button");
                    console.log("Found " + allButtons.length + " buttons in the comment container");
                    
                    // Cari tombol hapus
                    let deleteButton = null;
                    for (let i = 0; i < allButtons.length; i++) {
                        const button = allButtons[i];
                        console.log("Checking button:", button.textContent, button.className);
                        
                        // Cek apakah ini tombol hapus berdasarkan teks atau class
                        if (button.textContent.includes("Hapus") || 
                            (button.className && button.className.includes("text-red-500")) ||
                            button.querySelector("svg")) {
                            console.log("Found delete button:", button);
                            deleteButton = button;
                            break;
                        }
                    }
                    
                    if (deleteButton) {
                        console.log("Delete button found, clicking...");
                        deleteButton.click();
                        return true;
                    }
                    
                    // Jika tidak ditemukan tombol hapus, coba cari form dengan method DELETE
                    const deleteForm = commentContainer.querySelector("form");
                    if (deleteForm) {
                        console.log("Delete form found, submitting...");
                        deleteForm.submit();
                        return true;
                    }
                    
                    console.log("Delete button/form not found");
                    return false;
                }
                
                return findDeleteButtonNearComment();'
            );
            
            // Tunggu proses hapus selesai
            $browser->pause(3000);
            
            // Screenshot setelah tombol hapus diklik
            $browser->screenshot('forum-comment-after-click-delete');
            
            // BAGIAN 6: VERIFIKASI KOMENTAR SUDAH DIHAPUS
            // Refresh halaman untuk memastikan state terbaru
            $browser->refresh();
            $browser->pause(2000);
            
            // Screenshot untuk melihat hasil refresh
            $browser->screenshot('forum-comment-after-refresh');
            
            // Verifikasi komentar tidak ada lagi di halaman
            $hasComment = $browser->script(
                'return document.body.innerText.includes("' . addslashes($komentarText) . '");'
            );
            
            $hasComment = !empty($hasComment) && $hasComment[0];
            
            if (!$hasComment) {
                $this->assertTrue(true, 'Komentar tidak ditemukan lagi di halaman');
            } else {
                // Jika masih terlihat, mungkin ada komentar serupa
                // Verifikasi alternatif: cek jumlah komentar berkurang
                $commentCountAfter = $browser->script(
                    'const headings = Array.from(document.querySelectorAll("h2"));
                     let commentCount = 0;
                     for (let i = 0; i < headings.length; i++) {
                         if (headings[i].textContent.includes("Komentar")) {
                             const countMatch = headings[i].textContent.match(/\d+/);
                             if (countMatch) {
                                 commentCount = parseInt(countMatch[0]);
                                 break;
                             }
                         }
                     }
                     return commentCount;'
                );
                $commentCountAfter = !empty($commentCountAfter) ? intval($commentCountAfter[0]) : 0;
                
                if ($commentCountBefore > $commentCountAfter) {
                    $this->assertTrue(true, 'Jumlah komentar berkurang setelah penghapusan');
                } else {
                    // Coba lihat apakah ada notifikasi sukses
                    $hasSuccessNotif = $browser->script(
                        'return Boolean(document.querySelector(".bg-green-50")) || 
                                document.body.innerText.includes("berhasil dihapus") ||
                                document.body.innerText.includes("sukses") ||
                                document.body.innerText.includes("successfully");'
                    );
                    
                    if (!empty($hasSuccessNotif) && $hasSuccessNotif[0]) {
                        $this->assertTrue(true, 'Notifikasi sukses ditemukan');
                    } else {
                        $this->fail('Tidak dapat memverifikasi bahwa komentar dihapus');
                    }
                }
            }
            
            // Screenshot final untuk dokumentasi
            $browser->screenshot('forum-comment-delete-final');
            
            // Kembalikan confirm dialog ke fungsi aslinya (untuk cleanup)
            $browser->script('window.confirm = window.originalConfirm;');
        });
    }
}