<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserNotificationTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login ke Akun Anda')
                    ->type('Email_Pengguna', 'pengguna@example.com')
                    ->type('Password_Pengguna', 'pengguna123')
                    ->click('@submit-login')
                    ->waitForLocation('/dashboard-pengguna') // Increased to 15s for safety
                    ->assertPathIs('/dashboard-pengguna');
            $browser->visit('/pengguna/notifications')
                    ->assertPathIs('/pengguna/notifications');

        });
    }
}
