<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Pengguna;

class LogoutTest extends DuskTestCase
{
    public function testSuccessfulLogout()
    {
        $user = Pengguna::factory()->create([
            'Email_Pengguna' => 'logout@example.com',
            'Password_Pengguna' => bcrypt('Test@1234'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/dashboard')
                    ->press('Logout')
                    ->assertPathIs('/login')
                    ->assertSee('Anda telah logout');
        });
    }
}