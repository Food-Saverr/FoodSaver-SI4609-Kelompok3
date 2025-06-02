<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Group;

#[Group('ArtikelAdmin')]
class AdminArtikelTest extends DuskTestCase
{
    #[Group('ArtikelAdmin')]
    public function test_TC_AdminArtikel_001_BuatArtikel()
    {
        $this->browse(function (Browser $browser) {
            // LANGKAH LOGIN
            $browser->visit('/login')
                ->type('Email_Pengguna', 'tugus@admin.com')
                ->type('Password_Pengguna', '@12Maret2003')
                ->press('Masuk Sekarang')
                ->waitForLocation('/dashboard-admin')
                ->assertPathIs('/dashboard-admin');

            // LANGKAH BUAT ARTIKEL
            $browser->visit('/artikels')
                ->assertSee('Kelola Artikel')
                ->clickLink('Tambah Artikel')
                ->waitForText('Tambah Artikel Baru')
                ->type('judul', 'Artikel testing')
                ->type('konten', 'Lorem Ipsum Dolor')
                ->press('Simpan')
                ->assertSee('Artikel testing');
            $browser->driver->manage()->deleteAllCookies();
        });
    }

    public function test_TC_AdminArtikel_002_CancelBuatArtikel()
    {
        $this->browse(function (Browser $browser) {
            // LANGKAH LOGIN
            $browser->visit('/login')
                ->type('Email_Pengguna', 'tugus@admin.com')
                ->type('Password_Pengguna', '@12Maret2003')
                ->press('Masuk Sekarang')
                ->waitForLocation('/dashboard-admin');

            // BUKA FORM CREATE, LALU BATAL
            $browser->visit('/artikels')
                ->assertSee('Kelola Artikel')
                ->clickLink('Tambah Artikel')
                ->waitForText('Tambah Artikel Baru')
                ->clickLink('Batal');
            $browser->driver->manage()->deleteAllCookies();
        });
    }

    public function test_TC_AdminArtikel_003_EditArtikel()
    {
        $this->browse(function (Browser $browser) {
            // LANGKAH LOGIN & BUAT ARTIKEL AWAL
            $browser->visit('/login')
                ->type('Email_Pengguna', 'tugus@admin.com')
                ->type('Password_Pengguna', '@12Maret2003')
                ->press('Masuk Sekarang')
                ->waitForLocation('/dashboard-admin');

            $browser->visit('/artikels')
                ->assertSee('Kelola Artikel')
                ->clickLink('Tambah Artikel')
                ->waitForText('Tambah Artikel Baru')
                ->type('judul', 'Artikel untuk Edit')
                ->type('konten', 'Konten awal')
                ->press('Simpan')
                ->assertSee('Artikel untuk Edit');

            // Akses HALAMAN EDIT
            $browser->visit('/artikels')
                ->clickLink('Artikel untuk Edit')
                ->waitForText('Edit Artikel')
                ->assertInputValue('judul', 'Artikel untuk Edit')
                ->type('judul', 'Artikel setelah Edit')
                ->type('konten', 'Konten telah diubah')
                ->press('Update Artikel')
                ->assertSee('Artikel setelah Edit');
            $browser->driver->manage()->deleteAllCookies();
        });
    }

    public function test_TC_AdminArtikel_004_CancelEditArtikel()
    {
        $this->browse(function (Browser $browser) {
            // LANGKAH LOGIN & BUAT ARTIKEL AWAL
            $browser->visit('/login')
                ->type('Email_Pengguna', 'tugus@admin.com')
                ->type('Password_Pengguna', '@12Maret2003')
                ->press('Masuk Sekarang')
                ->waitForLocation('/dashboard-admin');

            $browser->visit('/artikels')
                ->assertSee('Kelola Artikel')
                ->clickLink('Tambah Artikel')
                ->waitForText('Tambah Artikel Baru')
                ->type('judul', 'Artikel untuk CancelEdit')
                ->type('konten', 'Konten sebelum di-cancel')
                ->press('Simpan')
                ->assertSee('Artikel untuk CancelEdit');

            // BUKA EDIT, GANTI ISI, LALU BATAL
            $browser->visit('/artikels')
                ->clickLink('Artikel untuk CancelEdit')
                ->waitForText('Edit Artikel')
                ->type('judul', 'Judul yang Diubah')
                ->type('konten', 'Konten yang Diubah')
                ->clickLink('Batal')
                ->assertSee('Artikel untuk CancelEdit')
                ->assertDontSee('Judul yang Diubah');
            $browser->driver->manage()->deleteAllCookies();
        });
    }

    public function test_TC_AdminArtikel_005_DeleteArtikel()
    {
        $this->browse(function (Browser $browser) {
            // LANGKAH LOGIN & BUAT ARTIKEL AWAL
            $browser->visit('/login')
                ->type('Email_Pengguna', 'tugus@admin.com')
                ->type('Password_Pengguna', '@12Maret2003')
                ->press('Masuk Sekarang')
                ->waitForLocation('/dashboard-admin');

            $browser->visit('/artikels')
                ->assertSee('Kelola Artikel')
                ->clickLink('Tambah Artikel')
                ->waitForText('Tambah Artikel Baru')
                ->type('judul', 'Artikel untuk Delete')
                ->type('konten', 'Konten yang akan dihapus')
                ->press('Simpan')
                ->assertSee('Artikel untuk Delete');

            // HAPUS ARTIKEL DENGAN KONFIRMASI OK
            $browser->visit('/artikels')
                ->assertSee('Artikel untuk Delete')
                ->script("window.confirm = function() { return true; };");
            $browser->press('Hapus');
            $browser->pause(500)
                ->assertDontSee('Artikel untuk Delete');
            $browser->driver->manage()->deleteAllCookies();
        });
    }

    public function test_TC_AdminArtikel_006_CancelDeleteArtikel()
    {
        $this->browse(function (Browser $browser) {
            // LANGKAH LOGIN & BUAT ARTIKEL AWAL
            $browser->visit('/login')
                ->type('Email_Pengguna', 'tugus@admin.com')
                ->type('Password_Pengguna', '@12Maret2003')
                ->press('Masuk Sekarang')
                ->waitForLocation('/dashboard-admin');

            $browser->visit('/artikels')
                ->assertSee('Kelola Artikel')
                ->clickLink('Tambah Artikel')
                ->waitForText('Tambah Artikel Baru')
                ->type('judul', 'Artikel untuk Cancel Delete')
                ->type('konten', 'Konten yang tidak jadi dihapus')
                ->press('Simpan')
                ->assertSee('Artikel untuk Cancel Delete');

            // HAPUS ARTIKEL DENGAN MENOLAK KONFIRMASI
            $browser->visit('/artikels')
                ->assertSee('Artikel untuk Cancel Delete')
                ->script("window.confirm = function() { return false; };");
            $browser->press('Hapus');
            $browser->pause(500)
                ->assertSee('Artikel untuk Cancel Delete');
            $browser->driver->manage()->deleteAllCookies();
        });
    }
}
