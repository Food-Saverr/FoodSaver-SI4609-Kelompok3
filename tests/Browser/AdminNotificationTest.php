<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User; // Adjust based on your User model location

class AdminNotificationTest extends DuskTestCase
{
    /**
     * @group test1
     */
    public function test_TC_Notification_001(): void
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
                    ->select('target', 'all')
                    ->select('type', 'maintenance')
                    ->type('title', 'Maintenance Notification')
                    ->type('message', 'This is a test notification for maintenance.')
                    ->click('@submit-notification');
        });
    }
}