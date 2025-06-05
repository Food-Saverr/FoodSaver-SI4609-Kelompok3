<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DonaturNotificationTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login ke Akun Anda')
                    ->type('Email_Pengguna', 'donatur@example.com')
                    ->type('Password_Pengguna', 'donatur123')
                    ->click('@submit-login')
                    ->waitForLocation('/dashboard-donatur') // Increased to 15s for safety
                    ->assertPathIs('/dashboard-donatur');
            $browser->visit('/donatur/notifications')
                    ->assertPathIs('/donatur/notifications');

        });
    }
}
