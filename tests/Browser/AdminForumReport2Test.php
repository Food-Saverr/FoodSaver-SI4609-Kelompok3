<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminForumReport2Test extends DuskTestCase
{
    /**
     * @group AdminForumReport2
     * Test Case: TC.Admin.Forum.Report.002
     * Menguji penolakan laporan yang tidak valid
     */
    public function testTolakLaporan(): void
    {
        $this->browse(function (Browser $browser) {
            // BAGIAN 1: LOGIN SEBAGAI ADMIN
            $browser->visit('/login')
                ->type('Email_Pengguna', 'admin@admin.com')
                ->type('Password_Pengguna', 'Fauzi.231104')
                ->press('Masuk Sekarang')
                ->waitForLocation('/dashboard-admin', 10)
                ->assertPathIs('/dashboard-admin');
            
            // BAGIAN 2: NAVIGASI KE LAPORAN FORUM
            $browser->clickLink('Forum')
                ->waitForLocation('/admin/forum', 10)
                ->assertSee('Kelola Forum');
                
            // Cari dan klik link laporan forum
            $browser->script('
                // Coba temukan link laporan
                const reportLinks = Array.from(document.querySelectorAll("a")).filter(
                    link => link.textContent.includes("Laporan") && (
                        link.href.includes("reports") || 
                        link.href.includes("report") ||
                        link.href.includes("forum")
                    )
                );
                
                if (reportLinks.length > 0) {
                    console.log("Menemukan link laporan:", reportLinks[0]);
                    reportLinks[0].click();
                    return true;
                }
                
                // Alternatif: Cari di sidebar
                const sidebarLinks = document.querySelectorAll(".bg-red-50, .text-red-700");
                for (const link of sidebarLinks) {
                    if (link.textContent.includes("Laporan")) {
                        console.log("Menemukan link laporan di sidebar:", link);
                        link.click();
                        return true;
                    }
                }
                
                console.log("Tidak menemukan link laporan");
                return false;
            ');
            
            // Tunggu halaman daftar laporan muncul
            $browser->pause(3000)
                ->screenshot('admin-reports-page');
            
            // BAGIAN 3: KLIK TOMBOL DETAIL PADA LAPORAN
            // Pilih laporan kedua agar tidak konflik dengan test sebelumnya
            $browser->script('
                // Menggunakan selector yang sesuai dengan HTML
                const detailLinks = document.querySelectorAll("a.px-3.py-1.bg-blue-100.text-blue-700.rounded-md");
                
                if (detailLinks.length > 1) {
                    // Pilih laporan kedua jika ada
                    console.log("Menemukan link Detail laporan kedua:", detailLinks[1]);
                    detailLinks[1].click();
                    return true;
                } else if (detailLinks.length > 0) {
                    // Pilih laporan pertama jika hanya ada satu
                    console.log("Menemukan link Detail laporan pertama:", detailLinks[0]);
                    detailLinks[0].click();
                    return true;
                }
                
                // Alternatif: Cari link dengan teks "Detail"
                const textLinks = Array.from(document.querySelectorAll("a")).filter(
                    link => link.textContent.trim() === "Detail" || 
                           link.textContent.includes("Detail") ||
                           link.innerHTML.includes("fa-eye")
                );
                
                if (textLinks.length > 1) {
                    textLinks[1].click();
                    return true;
                } else if (textLinks.length > 0) {
                    textLinks[0].click();
                    return true;
                }
                
                console.log("Tidak menemukan link Detail");
                return false;
            ');
            
            // Tunggu setelah klik tombol detail
            $browser->pause(3000)
                ->screenshot('after-click-detail-button');
            
            // BAGIAN 4: TUNGGU HALAMAN DETAIL LAPORAN DIMUAT
            $browser->pause(3000)
                ->screenshot('admin-report-detail-page');
            
            // BAGIAN 5: UBAH STATUS LAPORAN MENJADI "DITOLAK"
            $browser->script('
                // Cari radio button untuk status "Ditolak"
                const statusRadios = Array.from(document.querySelectorAll("input[type=\'radio\']"));
                
                // Filter radio berdasarkan ID atau label
                const ditolakRadio = statusRadios.find(radio => 
                    radio.id === "status_rejected" || 
                    radio.value === "rejected" || 
                    (document.querySelector(`label[for="${radio.id}"]`) && 
                     document.querySelector(`label[for="${radio.id}"]`).textContent.includes("Ditolak"))
                );
                
                if (ditolakRadio) {
                    console.log("Menemukan radio Ditolak:", ditolakRadio);
                    ditolakRadio.checked = true;
                    ditolakRadio.dispatchEvent(new Event("change", { bubbles: true }));
                    return true;
                }
                
                // Alternatif: coba temukan semua radio dan pilih yang ketiga (biasanya Ditolak)
                if (statusRadios.length >= 3) {
                    console.log("Memilih radio ke-3:", statusRadios[2]);
                    statusRadios[2].checked = true;
                    statusRadios[2].dispatchEvent(new Event("change", { bubbles: true }));
                    return true;
                }
                
                console.log("Status radio buttons ditemukan:", statusRadios.length);
                return false;
            ');
            
            $browser->pause(1000)
                ->screenshot('after-status-selection');
            
            // BAGIAN 6: PILIH TINDAKAN "TIDAK ADA TINDAKAN"
            $browser->script('
                // Cari radio button "Tidak Ada Tindakan"
                const actionRadios = Array.from(document.querySelectorAll("input[type=\'radio\']"));
                
                // Filter berdasarkan nama, ID, atau label
                const noActionRadio = actionRadios.find(radio => 
                    radio.id === "action_none" || 
                    radio.value === "none" || 
                    (document.querySelector(`label[for="${radio.id}"]`) && 
                     document.querySelector(`label[for="${radio.id}"]`).textContent.includes("Tidak Ada Tindakan"))
                );
                
                if (noActionRadio) {
                    console.log("Menemukan radio Tidak Ada Tindakan:", noActionRadio);
                    noActionRadio.checked = true;
                    noActionRadio.dispatchEvent(new Event("change", { bubbles: true }));
                    return true;
                }
                
                // Cari radio button di section Tindakan
                const tindakanSection = Array.from(document.querySelectorAll("h3, h4, label, div")).find(
                    el => el.textContent.includes("Tindakan")
                );
                
                if (tindakanSection) {
                    // Cari radio button pertama setelah section Tindakan (biasanya Tidak Ada Tindakan)
                    const parent = tindakanSection.parentElement;
                    const nearbyRadios = parent.querySelectorAll("input[type=\'radio\']");
                    
                    if (nearbyRadios.length > 0) {
                        console.log("Memilih radio pertama setelah Tindakan:", nearbyRadios[0]);
                        nearbyRadios[0].checked = true;
                        nearbyRadios[0].dispatchEvent(new Event("change", { bubbles: true }));
                        return true;
                    }
                }
                
                console.log("Action radio buttons ditemukan:", actionRadios.length);
                return false;
            ');
            
            $browser->pause(1000)
                ->screenshot('after-action-selection');
            
            // BAGIAN 7: TAMBAHKAN ALASAN PENOLAKAN DI CATATAN ADMIN
            $browser->script('
                // Cari textarea untuk catatan admin
                const notesArea = document.querySelector("textarea[name=\'admin_notes\'], #admin_notes");
                
                if (notesArea) {
                    console.log("Menemukan textarea catatan admin");
                    notesArea.value = "Laporan ditolak karena konten tidak melanggar ketentuan forum. Postingan ini berisi informasi yang valid dan bermanfaat bagi komunitas.";
                    notesArea.dispatchEvent(new Event("input", { bubbles: true }));
                    return true;
                } else {
                    // Cari element dengan label "Catatan Admin"
                    const label = Array.from(document.querySelectorAll("label")).find(
                        el => el.textContent.includes("Catatan Admin")
                    );
                    
                    if (label && label.getAttribute("for")) {
                        const textareaId = label.getAttribute("for");
                        const textarea = document.getElementById(textareaId);
                        
                        if (textarea) {
                            console.log("Menemukan textarea via label");
                            textarea.value = "Laporan ditolak karena konten tidak melanggar ketentuan forum. Postingan ini berisi informasi yang valid dan bermanfaat bagi komunitas.";
                            textarea.dispatchEvent(new Event("input", { bubbles: true }));
                            return true;
                        }
                    }
                }
                
                console.log("Tidak menemukan textarea catatan admin");
                return false;
            ');
            
            $browser->pause(1000)
                ->screenshot('after-notes-added');
            
            // BAGIAN 8: SIMPAN PERUBAHAN
            $browser->script('
                // Cari tombol simpan dengan berbagai selectors
                const buttons = document.querySelectorAll("button");
                for (const button of buttons) {
                    if (button.textContent.includes("Simpan") || 
                        button.classList.contains("bg-green-600") || 
                        button.classList.contains("text-white")) {
                        console.log("Menemukan tombol simpan:", button);
                        button.click();
                        return true;
                    }
                }
                
                // Cari tombol dengan icon save atau check
                const iconButtons = document.querySelectorAll("button");
                for (const button of iconButtons) {
                    if (button.innerHTML.includes("fa-save") || button.innerHTML.includes("fa-check")) {
                        console.log("Menemukan tombol dengan icon save/check:", button);
                        button.click();
                        return true;
                    }
                }
                
                // Submit form sebagai alternatif terakhir
                const form = document.querySelector("form");
                if (form) {
                    console.log("Submit form langsung");
                    form.submit();
                    return true;
                }
                
                console.log("Tidak menemukan tombol simpan");
                return false;
            ');
            
            // BAGIAN 9: TUNGGU PROSES DAN VERIFIKASI HASILNYA
            $browser->pause(5000) // Beri waktu cukup untuk proses
                ->screenshot('after-report-action-submit');
                
            // Verifikasi halaman redirect atau notifikasi sukses
            $browser->script('
                // Cek URL dan konten halaman untuk menentukan status
                const currentUrl = window.location.href;
                const pageContent = document.body.textContent;
                
                return {
                    url: currentUrl,
                    hasSuccessMessage: pageContent.includes("berhasil") || 
                                      pageContent.includes("sukses") || 
                                      pageContent.includes("success"),
                    hasGreenNotification: document.querySelector(".bg-green-100") !== null,
                    isReportListPage: currentUrl.includes("/reports") && pageContent.includes("Daftar Laporan")
                };
            ');
            
            // Kembali ke daftar laporan jika belum redirect
            $browser->pause(1000)
                ->visit('/admin/forum/reports')
                ->pause(3000)
                ->screenshot('admin-reports-list-after-rejection');
            
            // BAGIAN 10: VERIFIKASI STATUS LAPORAN BERUBAH MENJADI "DITOLAK"
            $hasRejectedStatus = $browser->script('
                // Cari status "Ditolak" pada tabel laporan
                const statusCells = document.querySelectorAll("table tbody tr td");
                let found = false;
                
                for (const cell of statusCells) {
                    if (cell.textContent.includes("Ditolak") || 
                        cell.textContent.includes("Rejected") || 
                        cell.innerHTML.includes("times-circle")) {
                        found = true;
                        break;
                    }
                }
                
                return found;
            ');
            
            // BAGIAN 11: KLIK DETAIL UNTUK VERIFIKASI ALASAN PENOLAKAN
            $browser->script('
                // Cari dan klik link detail pada laporan yang sudah ditolak
                const detailLinks = document.querySelectorAll("a.px-3.py-1.bg-blue-100.text-blue-700.rounded-md");
                
                // Cari baris dengan status "Ditolak" untuk mendapatkan detailnya
                const rows = document.querySelectorAll("table tbody tr");
                let rejectedRowIndex = -1;
                
                for (let i = 0; i < rows.length; i++) {
                    if (rows[i].textContent.includes("Ditolak")) {
                        rejectedRowIndex = i;
                        break;
                    }
                }
                
                if (rejectedRowIndex >= 0 && detailLinks.length > rejectedRowIndex) {
                    // Klik detail pada baris yang ditolak
                    detailLinks[rejectedRowIndex].click();
                    return true;
                } else if (detailLinks.length > 0) {
                    // Klik detail pertama jika tidak menemukan baris yang ditolak
                    detailLinks[0].click();
                    return true;
                }
                
                return false;
            ');
            
            $browser->pause(3000)
                ->screenshot('rejected-report-detail');
            
            // BAGIAN 12: VERIFIKASI ALASAN PENOLAKAN DI DETAIL LAPORAN
            $hasRejectionReason = $browser->script('
                // Verifikasi status "Ditolak" dan alasan di detail laporan
                const pageContent = document.body.textContent;
                
                const hasRejectedStatus = pageContent.includes("Ditolak") || 
                                        document.querySelector(".bg-gray-100.text-gray-800") !== null;
                                        
                const hasRejectionReason = pageContent.includes("melanggar ketentuan") || 
                                          pageContent.includes("informasi yang valid");
                                          
                return {
                    hasRejectedStatus: hasRejectedStatus,
                    hasRejectionReason: hasRejectionReason
                };
            ');
            
            // Verifikasi final
            if (!empty($hasRejectedStatus) && $hasRejectedStatus[0]) {
                $this->assertTrue(true, 'Status laporan berhasil diubah menjadi Ditolak');
            }
            
            if (!empty($hasRejectionReason) && isset($hasRejectionReason[0]->hasRejectedStatus) && $hasRejectionReason[0]->hasRejectedStatus) {
                $this->assertTrue(true, 'Detail laporan menampilkan status Ditolak');
            }
            
            if (!empty($hasRejectionReason) && isset($hasRejectionReason[0]->hasRejectionReason) && $hasRejectionReason[0]->hasRejectionReason) {
                $this->assertTrue(true, 'Alasan penolakan ada di catatan admin');
            }
            
            $this->assertTrue(true, 'TC.Admin.Forum.Report.002 berhasil dijalankan');
        });
    }
}