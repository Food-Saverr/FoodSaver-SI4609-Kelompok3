<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminFailNotificationTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login ke Akun Anda')
                    ->type('Email_Pengguna', 'admin@example.com')
                    ->type('Password_Pengguna', 'admin123')
                    ->click('@submit-login')
                    ->waitForLocation('/dashboard-admin') // Increased to 15s for safety
                    ->assertPathIs('/dashboard-admin');
            $browser->visit('/admin/notifications/send')
                    ->assertPathIs('/admin/notifications/send')
                    ->click('@submit-notification');
        });
    }
}
