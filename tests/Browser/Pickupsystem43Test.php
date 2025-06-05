<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Pickupsystem43Test extends DuskTestCase
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
                ->assertPathIs('/dashboard-pengguna')
                ->clickLink('Food Listing')
                ->assertPathIs('/pengguna/food-listing')
                ->pause(5000) // Allow time for dynamic content
                ->screenshot('food-listing-page') // Debug screenshot
                ->script('console.log("JS Errors: ", window.console.errors || [])') // Log JS errors
                // Try Dusk selector first
                ->try(function (Browser $browser) {
                    $browser->assertPresent('[dusk="riwayat-permintaan"]')
                            ->waitFor('[dusk="riwayat-permintaan"]', 10)
                            ->click('[dusk="riwayat-permintaan"]');
                })
                // Fallback to coordinate-based click if selector fails
                ->catch(function (Browser $browser, NoSuchElementException $e) {
                    $browser->screenshot('before-coordinate-click');
                    $browser->driver->getMouse()->mouseMove(
                        new WebDriverPoint(94.39, 12.28) // Coordinates from JSON
                    );
                    $browser->driver->getMouse()->click();
                    $browser->screenshot('after-coordinate-click');
                })
                ->waitForLocation('/pengguna/request/index', 15)
                ->assertPathIs('/pengguna/request/index')
                ->waitFor('button:contains("Pickup")', 10)
                ->click('button:contains("Pickup")')
                ->pause(1000)
                ->screenshot('pickupsystem43');
        });
    }
}