<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * @group ArtikelUser
 */
class ArtikelUserTest extends DuskTestCase
{
    /**
     * @group ArtikelUser
     * Test TC.ArtikelUser.001: Mengakses Artikel (Positif) dari sisi Pengguna
     *
     * @return void
     */
    public function test_TC_ArtikelUser_001_UserAksesArtikel_Positive()
    {
        $this->browse(function (Browser $browser) {
            // LOGIN sebagai pengguna
            $browser->visit('/login')
                    ->waitForLocation('/login')
                    ->assertPresent('#Email_Pengguna')
                    ->assertPresent('#Password_Pengguna')
                    ->type('Email_Pengguna', 'tugus@pengguna.com')
                    ->type('Password_Pengguna', '@12Maret2003')
                    ->press('Masuk Sekarang')
                    ->waitForLocation('/dashboard-pengguna')
                    ->assertPathIs('/dashboard-pengguna');

            $browser->visit('/Artikel')
                    ->assertPathIs('/Artikel');

            $browser->visit('/Artikels/artikel-testing')
                    ->assertPathIs('/Artikels/artikel-testing');
            $browser->driver->manage()->deleteAllCookies();
        });
    }

    /**
     * @group ArtikelUser
     * Test TC.ArtikelUser.002: Mengakses Artikel (Negatif – Cancel) dari sisi Pengguna
     *
     * @return void
     */
    public function test_TC_ArtikelUser_002_UserCancelAksesArtikel()
    {
        $this->browse(function (Browser $browser) {
            // LOGIN sebagai pengguna
            $browser->visit('/login')
                    ->waitForLocation('/login')
                    ->assertPresent('#Email_Pengguna')
                    ->assertPresent('#Password_Pengguna')
                    ->type('Email_Pengguna', 'tugus@pengguna.com')
                    ->type('Password_Pengguna', '@12Maret2003')
                    ->press('Masuk Sekarang')
                    ->waitForLocation('/dashboard-pengguna')
                    ->assertPathIs('/dashboard-pengguna');

            $browser->visit('/Artikels/artikel-testing')
                    ->assertPathIs('/Artikels/artikel-testing')
                    ->back()
                    ->waitForLocation('/dashboard-pengguna')
                    ->assertPathIs('/dashboard-pengguna')
                    ->assertDontSee('artikel-testing');
            $browser->driver->manage()->deleteAllCookies();
        });
    }

    /**
     * @group ArtikelUser
     * Test TC.ArtikelUser.003: Mengakses Artikel (Positif) dari sisi Donatur
     *
     * @return void
     */
    public function test_TC_ArtikelUser_003_DonaturAksesArtikel_Positive()
    {
        $this->browse(function (Browser $browser) {
            // LOGIN sebagai donatur
            $browser->visit('/login')
                    ->waitForLocation('/login')
                    ->assertPresent('#Email_Pengguna')
                    ->assertPresent('#Password_Pengguna')
                    ->type('Email_Pengguna', 'tugus@donatur.com')
                    ->type('Password_Pengguna', '@12Maret2003')
                    ->press('Masuk Sekarang')
                    ->waitForLocation('/dashboard-donatur')
                    ->assertPathIs('/dashboard-donatur');

            $browser->visit('/Artikel')
                    ->assertPathIs('/Artikel');

            // Akses halaman detail artikel "artikel-testing"
            $browser->visit('/Artikels/artikel-testing')
                    ->assertPathIs('/Artikels/artikel-testing');
            $browser->driver->manage()->deleteAllCookies();
        });
    }

    /**
     * @group ArtikelUser
     * Test TC.ArtikelUser.004: Mengakses Artikel (Negatif – Cancel) dari sisi Donatur
     *
     * @return void
     */
    public function test_TC_ArtikelUser_004_DonaturCancelAksesArtikel()
    {
        $this->browse(function (Browser $browser) {
            // LOGIN sebagai donatur
            $browser->visit('/login')
                    ->waitForLocation('/login')
                    ->assertPresent('#Email_Pengguna')
                    ->assertPresent('#Password_Pengguna')
                    ->type('Email_Pengguna', 'tugus@donatur.com')
                    ->type('Password_Pengguna', '@12Maret2003')
                    ->press('Masuk Sekarang')
                    ->waitForLocation('/dashboard-donatur')
                    ->assertPathIs('/dashboard-donatur');

            $browser->visit('/Artikels/artikel-testing')
                    ->assertPathIs('/Artikels/artikel-testing')
                    ->back()
                    ->waitForLocation('/dashboard-donatur')
                    ->assertPathIs('/dashboard-donatur')
                    ->assertDontSee('artikel-testing');
            $browser->driver->manage()->deleteAllCookies();
        });
    }
}