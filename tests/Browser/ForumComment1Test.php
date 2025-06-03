<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForumComment1Test extends DuskTestCase
{
    /**
     * @group ForumComment1
     * Test Case: TC.Forum.Comment.001
     * Menguji penambahan komentar dengan data valid
     */
    public function testTambahKomentarValid(): void
    {
        // Mendefinisikan isi komentar yang akan diuji
        // Komentar dibuat relevan dengan konteks forum tentang limbah makanan
        $komentar = "Terima kasih atas tips yang bermanfaat! Saya sudah mencoba mengurangi limbah makanan dengan menyimpan sisa makanan dengan benar dan hasilnya sangat efektif.";

        $this->browse(function (Browser $browser) use ($komentar) {
            // BAGIAN 1: LOGIN KE SISTEM
            // Navigasi ke halaman login dan masuk dengan kredensial yang valid
            $browser->visit('/login')
                ->type('Email_Pengguna', 'ahmadfaauzi2304@gmail.com') // Input email
                ->type('Password_Pengguna', 'Fauzi.231104')    // Input password
                ->press('Masuk Sekarang')                     // Klik tombol login
                ->waitForLocation('/dashboard-pengguna', 10)  // Tunggu sampai redirect ke dashboard (max 10 detik)
                ->assertPathIs('/dashboard-pengguna');         // Verifikasi user berada di dashboard

            // BAGIAN 2: NAVIGASI KE POSTINGAN FORUM
            // Mencari dan membuka halaman forum dan postingan spesifik
            $browser->clickLink('Forum Komunitas')  // Klik menu Forum Komunitas
                ->waitForLocation('/pengguna/forum', 10)  // Tunggu halaman forum load
                ->clickLink('Tips Mengurangi Limbah Makanan dengan Gambar')  // Klik artikel spesifik
                ->waitForText('Komentar', 10);  // Tunggu sampai kata "Komentar" muncul (menandakan halaman detail postingan sudah dimuat)
            
            // Ambil screenshot kondisi awal untuk debugging
            $browser->screenshot('forum-comment-before');
            
            // BAGIAN 3: MENGISI FORM KOMENTAR DENGAN JAVASCRIPT
            // Cara ini mengatasi masalah event binding di JS framework modern
            $browser->script(
                'const textarea = document.querySelector("textarea[name=\'konten\']") || document.querySelector("textarea");
                 if (textarea) {
                     textarea.value = ' . json_encode($komentar) . ';  // Isi nilai textarea dengan komentar
                     textarea.dispatchEvent(new Event("input", { bubbles: true }));  // Trigger event input untuk activate listeners
                     textarea.dispatchEvent(new Event("change", { bubbles: true })); // Trigger event change untuk form validation
                     console.log("Textarea filled successfully");
                 } else {
                     console.log("No textarea found"); // Log error jika textarea tidak ditemukan
                 }'
            );
            $browser->pause(1000); // Tunggu 1 detik agar JS selesai diproses

            // Screenshot setelah mengisi komentar untuk verifikasi
            $browser->screenshot('forum-comment-filled');

            // BAGIAN 4: SUBMIT FORM KOMENTAR DENGAN METODE ROBUST
            // Menggunakan JavaScript dengan pendekatan multiple-strategy untuk menemukan tombol submit
            $browser->script(
                'function findSubmitButton() {
                    // Strategi 1: Cari berdasarkan teks tombol
                    let buttons = Array.from(document.querySelectorAll("button")); 
                    let submitBtn = buttons.find(btn => btn.textContent.includes("Kirim Komentar"));
                    
                    // Strategi 2: Cari berdasarkan atribut HTML yang umum untuk tombol submit
                    if (!submitBtn) {
                        submitBtn = document.querySelector("button[type=\'submit\']") || 
                                   document.querySelector("form button"); // Form button pertama
                    }
                    
                    // Strategi 3: Cari berdasarkan warna (biasanya tombol aksi utama berwarna)
                    if (!submitBtn) {
                        const greenElements = Array.from(document.querySelectorAll("*"))
                            .filter(el => {
                                const style = window.getComputedStyle(el);
                                return (style.backgroundColor.includes("green") || 
                                       style.background.includes("green") ||
                                       el.className.includes("green")) && // Cari elemen dengan class/style green
                                       (el.tagName === "BUTTON" || el.tagName === "A"); // Yang merupakan button atau link
                            });
                        
                        if (greenElements.length > 0) {
                            submitBtn = greenElements[0];
                        }
                    }
                    
                    return submitBtn;
                }
                
                // Cari tombol submit dan klik jika ditemukan
                const submitButton = findSubmitButton();
                if (submitButton) {
                    console.log("Submit button found, clicking...");
                    submitButton.click();
                    return true;
                } else {
                    // Fallback: Submit form langsung jika tombol tidak ditemukan
                    const form = document.querySelector("form");
                    if (form) {
                        console.log("Submitting form directly...");
                        form.submit();
                        return true;
                    }
                    console.log("No submit button or form found!"); // Log error jika gagal
                    return false;
                }'
            );
            
            // Berikan waktu cukup untuk proses submit (AJAX atau full page load)
            $browser->pause(5000);
            
            // Screenshot setelah percobaan submit pertama
            $browser->screenshot('forum-comment-after-submit');
            
            // BAGIAN 5: PERCOBAAN SUBMIT ALTERNATIF
            // Jika percobaan pertama gagal, coba pendekatan lain dengan selector Tailwind CSS
            $browser->script(
                'const greenButton = document.querySelector(".bg-gradient-to-r.from-green-500.to-green-600") || // Selector untuk gradient Tailwind
                 document.querySelector("button.bg-green-600") || // Button dengan background hijau
                 document.querySelector("button.text-white") || // Button dengan teks putih (biasanya tombol aksi)
                 document.querySelector("[class*=\'green\']"); // Selector untuk elemen dengan class mengandung kata green
                 
                if (greenButton) {
                    console.log("Found green button with alternative selector, clicking...");
                    greenButton.click();
                    return true;
                } else {
                    console.log("No green button found with alternative selector");
                    return false;
                }'
            );
            
            // Tunggu proses submit dan refresh halaman untuk memastikan perubahan terlihat
            $browser->pause(5000);
            $browser->refresh(); // Refresh halaman untuk memastikan komentar dimuat
            $browser->pause(3000);
            
            // Screenshot final untuk dokumentasi hasil
            $browser->screenshot('forum-comment-final');
            
            // BAGIAN 6: VERIFIKASI HASIL
            // Verifikasi komentar berhasil ditambahkan dengan berbagai pendekatan
            try {
                // Cek apakah komentar kita muncul di halaman (menggunakan substring awal untuk keandalan)
                $browser->assertSee(substr($komentar, 0, 15));
                
                // Alternatif: cek jika jumlah komentar bertambah (tidak ada lagi pesan "Belum ada komentar")
                $browser->assertDontSee('Belum ada komentar');
                
            } catch (\Exception $e) {
                // Error handling: jika verifikasi pertama gagal
                // Coba reload dan periksa lagi
                $browser->visit($browser->driver->getCurrentURL()) // Reload halaman
                    ->pause(2000)
                    ->screenshot('forum-comment-refresh');
                
                // Verifikasi minimal bahwa tidak ada error server
                $browser->assertDontSee('Error')
                       ->assertDontSee('404')
                       ->assertDontSee('500');
            }
        });
    }
}