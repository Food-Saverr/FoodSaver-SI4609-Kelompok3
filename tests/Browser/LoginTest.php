<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Pengguna;

class LoginTest extends DuskTestCase
{
    public function testSuccessfulLogin()
    {
        $user = Pengguna::factory()->create([
            'Email_Pengguna' => 'login@example.com',
            'Password_Pengguna' => bcrypt('Test@1234'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/')
                    ->clickLink('Login')
                    ->type('Email', 'Testuser@example.com')
                    ->type('Password', 'Test@1234')
                    ->check('Ingat saya di perangkat ini')
                    ->press('Masuk')
                    ->assertPathIs('/dashboard-pengguna');
        });
    }

    public function testLoginFailsWithWrongPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->clickLink('Login')
                    ->type('Email', 'login@example.com')
                    ->type('Password', 'WrongPass1!')
                    ->check('Ingat saya di perangkat ini')
                    ->press('Masuk')
                    ->assertSee('Email atau Password salah');
        });
    }
}
