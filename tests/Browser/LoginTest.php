<?php
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Group;

#[Group('Login')]
class LoginTest extends DuskTestCase
{
    /**
     * TC.Login.001: Login berhasil (email & password benar)
     */
    public function test_TC_Login_001_successfulLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertPathIs('/login')
                    ->assertPresent('input[name="Email_Pengguna"]')
                    ->assertPresent('input[name="Password_Pengguna"]')
                    ->type('Email_Pengguna', 'pengguna@example.com')
                    ->type('Password_Pengguna', 'Abcd1234!')
                    ->click('@submit-login')
                    ->waitForLocation('/dashboard-pengguna')
                    ->assertPathIs('/dashboard-pengguna');
        });
    }

    /**
     * TC.Login.002: Email benar, password salah
     */
    public function test_TC_Login_002_failedWrongPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->driver->manage()->deleteAllCookies();
            $browser->visit('/login')
                    ->type('Email_Pengguna', 'pengguna@example.com')
                    ->type('Password_Pengguna', 'WrongPass!')
                    ->click('@submit-login')
                    ->pause(1000)
                    ->assertPathIs('/login')
                    ->pause(1000)
                    ->assertSee('Email atau Password salah');
        });
    }

    /**
     * TC.Login.003: Email tidak terdaftar
     */
    public function test_TC_Login_003_emailNotRegistered()
    {
        $this->browse(function (Browser $browser) {
            $browser->driver->manage()->deleteAllCookies();
            $browser->visit('/login')
                    ->type('Email_Pengguna', 'notfound@example.com')
                    ->type('Password_Pengguna', 'SomePass123!')
                    ->click('@submit-login')
                    ->pause(1000)
                    ->assertPathIs('/login')
                    ->pause(1000)
                    ->assertSee('Email atau Password salah');
        });
    }

    /**
     * TC.Login.004: Email kosong
     */
    public function test_TC_Login_004_emailEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->driver->manage()->deleteAllCookies();
            $browser->visit('/login')
                    ->type('Email_Pengguna', '')
                    ->type('Password_Pengguna', 'Pass1234!')
                    ->click('@submit-login')
                    ->assertPathIs('/login');
        });
    }

    /**
     * TC.Login.005: Password kosong
     */
    public function test_TC_Login_005_passwordEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->driver->manage()->deleteAllCookies();
            $browser->visit('/login')
                    ->type('Email_Pengguna', 'login@example.com')
                    ->type('Password_Pengguna', '')
                    ->click('@submit-login')
                    ->assertPathIs('/login');
        });
    }
}