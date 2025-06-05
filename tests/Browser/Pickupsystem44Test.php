<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Pickupsystem44Test extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
         $browser->visit('/login')
                ->assertSee('Login ke Akun Anda')
                ->type('[name="Email_Pengguna"]', 'pengguna@example.com')
                ->type('[name="Password_Pengguna"]', 'pengguna123')
                ->click('[dusk="submit-login"]')
                ->waitForLocation('/dashboard-pengguna', 15)
                ->assertPathIs('/dashboard-pengguna');
        $browser->visit('/pengguna/request/1')
            ->assertSee('Status Permintaan')
            ->script('window.scrollTo(0, 500);')
            ->click('button[onclick*="openEditPickupModal"]') // Click the "Pickup" button
            ->screenshot('pickupsystem44'); // Capture screenshot for debugging
        });
    }
}
