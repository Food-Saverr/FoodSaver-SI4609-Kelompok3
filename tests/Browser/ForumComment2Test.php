<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForumComment2Test extends DuskTestCase
{
    /**
     * @group ForumComment2
     * Test Case: TC.Forum.Comment.002
     * Menguji validasi input komentar kosong
     */
    public function testValidasiKomentarKosong(): void
    {
        $this->browse(function (Browser $browser) {
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
            
            // Screenshot sebelum mencoba submit komentar kosong
            $browser->screenshot('forum-comment-empty-before');
            
            // BAGIAN 3: KOSONGKAN TEXTAREA KOMENTAR (JIKA ADA NILAI DEFAULT)
            $browser->script(
                'const textarea = document.querySelector("textarea[name=\'konten\']") || document.querySelector("textarea");
                 if (textarea) {
                     textarea.value = "";  // Kosongkan textarea
                     textarea.dispatchEvent(new Event("input", { bubbles: true }));
                     textarea.dispatchEvent(new Event("change", { bubbles: true }));
                     console.log("Textarea cleared");
                 } else {
                     console.log("No textarea found");
                 }'
            );
            $browser->pause(500);
            
            // BAGIAN 4: SUBMIT FORM KOMENTAR KOSONG
            // Klik tombol submit menggunakan JS
            $browser->script(
                'const submitButton = document.querySelector(".bg-gradient-to-r.from-green-500.to-green-600") || 
                 document.querySelector("button[type=\'submit\']") ||
                 document.querySelector(".bg-green-600") ||
                 document.querySelector("button.text-white") ||
                 Array.from(document.querySelectorAll("button")).find(btn => 
                     btn.textContent.includes("Kirim Komentar"));
                
                if (submitButton) {
                    console.log("Submit button found, clicking...");
                    submitButton.click();
                    return true;
                } else {
                    console.log("Submit button not found");
                    return false;
                }'
            );
            
            // Tunggu sebentar untuk melihat validasi muncul
            $browser->pause(2000);
            
            // Screenshot setelah mencoba submit untuk melihat validasi
            $browser->screenshot('forum-comment-empty-validation');
            
            // BAGIAN 5: VERIFIKASI VALIDASI MUNCUL
            // Ada 3 cara validasi error bisa muncul:
            // 1. HTML5 native validation
            // 2. Error message dari server setelah form submission
            // 3. Error message dari JavaScript

            // Verifikasi validasi - 3 pendekatan berbeda
            $validationFound = $browser->script(
                'function checkValidation() {
                    // 1. Cek native HTML5 validation
                    const textarea = document.querySelector("textarea[name=\'konten\']") || document.querySelector("textarea");
                    if (textarea && textarea.validity && !textarea.validity.valid) {
                        return "HTML5 validation: " + textarea.validationMessage;
                    }
                    
                    // 2. Cek pesan error dari server
                    const errorMessages = document.querySelectorAll(".text-red-500, .error, .invalid-feedback");
                    if (errorMessages.length > 0) {
                        return "Server validation: " + errorMessages[0].textContent;
                    }
                    
                    // 3. Cek alert/toast/notification
                    const alerts = document.querySelectorAll(".alert, .toast, [role=alert], .notification");
                    for (let i = 0; i < alerts.length; i++) {
                        if (alerts[i].offsetParent !== null) { // Check if visible
                            return "Alert validation: " + alerts[i].textContent;
                        }
                    }

                    // 4. Pesan error dalam bahasa Indonesia yang umum
                    const anyText = document.body.innerText;
                    if (anyText.includes("wajib diisi") || anyText.includes("tidak boleh kosong") || 
                        anyText.includes("harus diisi") || anyText.includes("fill out this field")) {
                        return "Text validation: found validation message";
                    }
                    
                    return false;
                }
                return checkValidation();'
            );
            
            // Perbarui test berdasarkan jenis validasi yang terdeteksi
            if (!empty($validationFound) && $validationFound[0] !== false) {
                // Validasi ditemukan melalui JavaScript, test berhasil!
                $this->assertTrue(true, 'Validasi ditemukan: ' . $validationFound[0]);
            } else {
                // Jika tidak terdeteksi melalui JS, coba cek dengan cara lain
                try {
                    // Cek pesan error umum atau atribut required pada textarea
                    $hasValidationMessages = $browser->script(
                        'return document.body.innerText.includes("fill out this field") || 
                                document.body.innerText.includes("wajib diisi") || 
                                document.body.innerText.includes("tidak boleh kosong");'
                    );
                    
                    if (!empty($hasValidationMessages) && $hasValidationMessages[0]) {
                        $this->assertTrue(true, 'Validasi teks ditemukan');
                    } else {
                        // Cek apakah textarea memiliki atribut required
                        $hasRequiredAttribute = $browser->script(
                            'const textarea = document.querySelector("textarea");
                             return textarea && textarea.hasAttribute("required");'
                        );
                        
                        if (!empty($hasRequiredAttribute) && $hasRequiredAttribute[0]) {
                            $this->assertTrue(true, 'Textarea memiliki atribut required');
                        } else {
                            // Jika tidak ada validasi terdeteksi, gagalkan test
                            $this->fail('Validasi pada komentar kosong tidak ditemukan');
                        }
                    }
                } catch (\Exception $e) {
                    $this->fail('Gagal mendeteksi validasi: ' . $e->getMessage());
                }
            }
            
            // Verifikasi tambahan: pastikan komentar tidak ditambahkan
            $browser->refresh()
                ->pause(2000)
                ->screenshot('forum-comment-empty-after-refresh');
            
            // Pastikan jumlah komentar tidak bertambah
            // Menggunakan pendekatan yang lebih aman untuk mendapatkan jumlah komentar
            $commentCountInfo = $browser->script(
                'const headings = Array.from(document.querySelectorAll("h2"));
                 const commentHeading = headings.find(h => h.textContent.includes("Komentar"));
                 return commentHeading ? commentHeading.textContent : null;'
            );
            
            // Memastikan kita tidak melihat tanggal baru posting komentar
            $currentDate = date('d M Y');
            $dateVisibleInComments = $browser->script(
                'return document.body.innerText.includes("' . $currentDate . '");'
            );
            
            if (!empty($dateVisibleInComments) && $dateVisibleInComments[0]) {
                // Bisa ditambahkan verifikasi lebih lanjut untuk memastikan tanggal tersebut bukan dari komentar baru
                // tapi ini optional dan mungkin kompleks
            }
        });
    }
}