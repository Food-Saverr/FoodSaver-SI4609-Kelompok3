<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Group;

#[Group('Logout')]
class LogoutTest extends DuskTestCase
{
    /**
     * TC.Logout.001: Login & Logout berhasil
     */
    public function test_TC_logout_001_logout_setelah_login_berhasil()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('Email_Pengguna', 'pengguna@example.com')
                    ->type('Password_Pengguna', 'Abcd1234!')
                    ->click('@submit-login')
                    ->waitForLocation('/dashboard-pengguna', 5);
            $browser->driver->manage()->deleteAllCookies();
            $browser->visit('/dashboard-pengguna')
                    ->waitForLocation('/login', 5)
                    ->assertPathIs('/login');
        });
    }

    /**
     * TC.Logout.002: Akses halaman dashboard setelah logout
     */
    public function test_TC_logout_002_akses_dashboard_setelah_logout()
    {
        $this->browse(function (Browser $browser) {
            // Log in normally
            $browser->visit('/login')
                    ->type('Email_Pengguna', 'pengguna@example.com')
                    ->type('Password_Pengguna', 'Abcd1234!')
                    ->click('@submit-login')
                    ->waitForLocation('/dashboard-pengguna', 5);
            $browser->driver->manage()->deleteAllCookies();
            $browser->visit('/dashboard-pengguna')
                    ->waitForLocation('/login', 5)
                    ->assertPathIs('/login');
        });
    }

    /**
     * TC.Logout.003: Logout tanpa login (akses dashboard langsung)
     */
    public function test_TC_logout_003_logout_tanpa_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/dashboard-pengguna')
                    ->waitForLocation('/login', 5)
                    ->assertPathIs('/login')
                    ->assertMissing('@logout-button');
        });
    }
}
