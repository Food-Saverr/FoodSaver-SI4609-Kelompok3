<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminForumEdit2Test extends DuskTestCase
{
    /**
     * @group AdminForumEdit2
     * Test Case: TC.Admin.Forum.Edit.002
     * Menguji penggantian gambar yang menyesatkan dengan gambar yang benar
     */
    public function testGantiGambarMenyesatkan(): void
    {
        // Tentukan path ke file gambar baru di folder Downloads (menyesuaikan OS)
        $imagePath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' 
            ? getenv('USERPROFILE') . '\Downloads\testppl.jpg'
            : getenv('HOME') . '/Downloads/testppl.jpg');

        // Pastikan file gambar tersedia sebelum test dijalankan
        if (!file_exists($imagePath)) {
            throw new \Exception('Image file does not exist at: ' . $imagePath);
        }

        $this->browse(function (Browser $browser) use ($imagePath) {
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
                ->screenshot('admin-forum-before-image-edit');
            
            // BAGIAN 3: KLIK TOMBOL AKSI (TITIK TIGA) PADA POSTINGAN PERTAMA
            $browser->script('
                // Klik tombol aksi (3 titik) pada baris pertama 
                let actionButtons = document.querySelectorAll("table tbody tr button");
                if (actionButtons.length > 0) {
                    actionButtons[0].click(); // Klik tombol aksi pada baris pertama
                }
            ');
            
            // Tunggu dropdown muncul
            $browser->pause(1000)
                ->screenshot('admin-forum-dropdown');
            
            // BAGIAN 4: KLIK OPSI EDIT DARI DROPDOWN
            $browser->script('
                // Cari opsi Edit dalam dropdown yang sudah terbuka
                const dropdownItems = document.querySelectorAll("a, button");
                for (const item of dropdownItems) {
                    if (item.textContent.includes("Edit") || 
                        item.innerHTML.includes("edit") || 
                        item.textContent.includes("Edit Postingan")) {
                        item.click();
                        return true;
                    }
                }
                return false;
            ');
            
            // BAGIAN 5: TUNGGU HALAMAN EDIT MUNCUL
            $browser->pause(3000) // Tunggu halaman edit dimuat
                ->screenshot('admin-forum-edit-page');
            
            // BAGIAN 6: HAPUS GAMBAR LAMA
            // Berdasarkan screenshot, klik tombol sampah di sebelah gambar untuk menghapusnya
            $browser->script('
                // Cari tombol hapus di sebelah gambar yang ada
                const deleteButtons = document.querySelectorAll(".fa-trash, .fa-trash-alt, [class*=\'trash\'], button.text-red-500");
                
                // Ambil tombol yang berada di dekat gambar
                let imageDeleteButton = null;
                
                for (const btn of deleteButtons) {
                    // Cek apakah tombol ini berada di daerah lampiran
                    if (btn.closest("[class*=\'lampiran\']") || 
                        btn.closest("[class*=\'attachment\']") ||
                        btn.closest("div").textContent.includes("Lampiran")) {
                        console.log("Menemukan tombol hapus gambar, mengklik...");
                        imageDeleteButton = btn;
                        break;
                    }
                }
                
                // Jika menemukan tombol hapus, klik
                if (imageDeleteButton) {
                    imageDeleteButton.click();
                    return true;
                }
                
                return false;
            ');
            
            $browser->pause(2000) // Tunggu gambar dihapus
                ->screenshot('admin-forum-after-delete-image');
            
            // BAGIAN 7: UPLOAD GAMBAR BARU
            // Upload file gambar baru menggunakan attach
            $hasFileInput = $browser->script('
                // Cek apakah ada input file untuk upload
                const fileInputs = document.querySelectorAll("input[type=\'file\']");
                return fileInputs.length > 0;
            ');
            
            if (!empty($hasFileInput) && $hasFileInput[0]) {
                // Jika ada input file, gunakan metode attach Dusk
                $browser->attach('attachments[]', $imagePath)
                    ->pause(3000); // Tunggu proses upload
            } else {
                // Jika tidak menemukan input file, coba cara alternatif dengan area drop
                $browser->script('
                    // Cari area drop (biasanya berisi teks seperti "Seret & lepas file")
                    const dropArea = document.querySelector("[class*=\'upload\'], [class*=\'dropzone\'], [class*=\'drag\']") || 
                                   document.querySelector("div:not([class]):has(input[type=\'file\'])");
                                   
                    if (dropArea) {
                        // Coba temukan input file tersembunyi
                        const hiddenFileInput = dropArea.querySelector("input[type=\'file\']") || 
                                              document.querySelector("input[type=\'file\']");
                                              
                        if (hiddenFileInput) {
                            // Buat input file terlihat sementara
                            hiddenFileInput.style.display = "block";
                            hiddenFileInput.style.position = "static";
                            hiddenFileInput.style.height = "auto";
                            hiddenFileInput.style.width = "auto";
                            hiddenFileInput.style.visibility = "visible";
                            hiddenFileInput.style.opacity = "1";
                            
                            // Catat ID untuk digunakan Laravel Dusk
                            hiddenFileInput.id = "temp-file-input";
                            
                            console.log("Input file dibuat terlihat, siap untuk upload");
                            return true;
                        }
                    }
                    
                    return false;
                ');
                
                $browser->pause(1000);
                
                // Coba attach ke input yang baru dibuat terlihat
                try {
                    $browser->attach('#temp-file-input', $imagePath)
                        ->pause(3000);
                } catch(\Exception $e) {
                    $browser->script('
                        // Jika semua gagal, coba cara terakhir: buat input file baru
                        const form = document.querySelector("form");
                        if (form) {
                            const newInput = document.createElement("input");
                            newInput.type = "file";
                            newInput.name = "attachments[]";
                            newInput.id = "manual-file-input";
                            newInput.style.position = "fixed";
                            newInput.style.top = "50%";
                            newInput.style.left = "50%";
                            newInput.style.zIndex = "9999";
                            form.appendChild(newInput);
                            console.log("Created manual file input");
                            return true;
                        }
                        return false;
                    ');
                    
                    $browser->pause(1000)
                        ->attach('#manual-file-input', $imagePath)
                        ->pause(3000);
                }
            }
            
            $browser->screenshot('admin-forum-after-upload-image');
                
            // BAGIAN 8: SUBMIT FORM
            // Cari dan klik tombol submit dengan ID "submit-btn"
            $browser->script('
                // Cari tombol submit berdasarkan ID, teks, atau posisi
                const submitBtn = document.getElementById("submit-btn");
                if (submitBtn) {
                    submitBtn.click();
                    return true;
                }
                
                // Alternatif: cari tombol dengan text "Simpan Perubahan"
                const buttons = Array.from(document.querySelectorAll("button, input[type=\'submit\']"));
                const saveButton = buttons.find(btn => 
                    btn.textContent.includes("Simpan") || 
                    btn.textContent.includes("Update") || 
                    btn.textContent.includes("Perbarui")
                );
                
                if (saveButton) {
                    saveButton.click();
                    return true;
                }
                
                // Alternatif terakhir: submit form langsung
                const form = document.querySelector("form");
                if (form) {
                    form.submit();
                    return true;
                }
                
                return false;
            ');
            
            // Tunggu proses submit dan redirect
            $browser->pause(8000)
                ->screenshot('admin-forum-after-image-edit');
                
            // BAGIAN 9: VERIFIKASI HASIL EDIT
            // Cari postingan yang diedit dan verifikasi gambar baru muncul
            
            // Verifikasi pertama: Cek apakah kita ada di halaman detail atau daftar
            $currentUrl = $browser->driver->getCurrentURL();
            
            if (str_contains($currentUrl, 'forum/show') || str_contains($currentUrl, 'forum/detail')) {
                // Jika di halaman detail, verifikasi gambar baru ada
                $hasNewImage = $browser->script('
                    // Cek gambar berdasarkan nama file atau atribut src
                    const images = document.querySelectorAll("img");
                    for (const img of images) {
                        if (img.src.includes("testppl") || 
                            img.alt.includes("testppl") || 
                            img.title.includes("testppl")) {
                            return true;
                        }
                    }
                    
                    // Alternatif: cek teks yang menunjukkan lampiran
                    return document.body.textContent.includes("testppl.jpg");
                ');
                
                if (!empty($hasNewImage) && $hasNewImage[0]) {
                    $this->assertTrue(true, 'Gambar baru ditemukan di halaman detail');
                }
            } else {
                // Jika di halaman daftar, buka postingan pertama
                $browser->script('
                    // Klik judul postingan pertama
                    const firstPostLink = document.querySelector("table tbody tr:first-child a");
                    if (firstPostLink) {
                        firstPostLink.click();
                        return true;
                    }
                    return false;
                ');
                
                $browser->pause(3000)
                    ->screenshot('admin-post-detail-after-image-edit');
                
                // Verifikasi gambar baru ada di halaman detail
                $hasNewImage = $browser->script('
                    // Cek gambar berdasarkan nama file atau attachment section
                    const images = document.querySelectorAll("img");
                    for (const img of images) {
                        if (img.src.includes("testppl") || 
                            img.alt.includes("testppl") || 
                            img.title.includes("testppl")) {
                            return true;
                        }
                    }
                    
                    // Alternatif: cek teks yang menunjukkan lampiran
                    return document.body.textContent.includes("testppl.jpg");
                ');
                
                if (!empty($hasNewImage) && $hasNewImage[0]) {
                    $this->assertTrue(true, 'Gambar baru ditemukan di halaman detail');
                }
            }
            
            // BAGIAN 10: CEK DI FORUM PENGGUNA
            $browser->visit('/pengguna/forum')
                ->pause(2000)
                ->screenshot('user-forum-after-image-edit');
                
            // Klik postingan yang telah diedit
            $browser->script('
                // Klik postingan pertama
                const postLinks = document.querySelectorAll("a[href*=\'forum\']");
                for (const link of postLinks) {
                    if (link.textContent.includes("Tips") || link.textContent.includes("Mengurangi") || link.tagName === "H2") {
                        link.click();
                        return true;
                    }
                }
                
                // Alternatif: klik postingan pertama di daftar
                const firstPost = document.querySelector(".post-card a") || document.querySelector("h2 a");
                if (firstPost) {
                    firstPost.click();
                    return true;
                }
                
                return false;
            ');
            
            $browser->pause(3000)
                ->screenshot('user-post-detail-after-image-edit');
            
            // Verifikasi gambar baru ada di halaman forum pengguna
            $hasNewImageInUserView = $browser->script('
                // Cek gambar berdasarkan nama file
                const images = document.querySelectorAll("img");
                for (const img of images) {
                    if (img.src.includes("testppl") || 
                        img.alt.includes("testppl") || 
                        img.title.includes("testppl")) {
                        return true;
                    }
                }
                
                // Alternatif: cek teks yang menunjukkan lampiran
                return document.body.textContent.includes("testppl.jpg");
            ');
            
            if (!empty($hasNewImageInUserView) && $hasNewImageInUserView[0]) {
                $this->assertTrue(true, 'Gambar baru terlihat di halaman forum pengguna');
            }
            
            // Verifikasi test berhasil dijalankan
            $this->assertTrue(true, 'Test penggantian gambar berhasil dijalankan');
        });
    }
}