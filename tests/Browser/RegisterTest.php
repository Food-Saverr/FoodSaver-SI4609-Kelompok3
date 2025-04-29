<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * @group Register
     */
    public function testSuccessfulRegistrationAsPengguna()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->waitFor('form', 5)
                    ->type('input[name="Email_Pengguna"]', 'testuser@example.com')
                    ->type('input[name="Nama_Pengguna"]', 'Deva')
                    ->type('input[name="Password_Pengguna"]', 'Test@1234')
                    ->type('textarea[name="Alamat_Pengguna"]', 'Jl. Contoh 123')
                    ->select('select[name="Role_Pengguna"]', 'Pengguna')
                    ->check('input[name="terms"]')
                    ->press('Daftar Sekarang')
                    ->assertPathIs('/dashboard-pengguna');
        });
    }

    /**
     * @group Register
     */
    public function testFailedRegistrationDueToWeakPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->waitFor('form', 5)
                    ->type('input[name="Email_Pengguna"]', 'weakpass@example.com')
                    ->type('input[name="Nama_Pengguna"]', 'Deva')
                    ->type('input[name="Password_Pengguna"]', '1234')
                    ->type('textarea[name="Alamat_Pengguna"]', 'Jl. Contoh 123')
                    ->select('select[name="Role_Pengguna"]', 'Pengguna')
                    ->check('input[name="terms"]')
                    ->press('Daftar Sekarang')
                    ->assertSee('Mohon periksa kembali detail pendaftaran Anda');
        });
    }
}
