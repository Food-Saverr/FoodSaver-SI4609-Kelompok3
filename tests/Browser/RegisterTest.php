<?php
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Group;

#[Group('Register')]
class RegisterTest extends DuskTestCase
{
    /**
     * TC.Register.001: Semua data valid, role Pengguna -> sukses
     */
    public function test_TC_Register_001_successfulRegistrationAsPengguna()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/registrasi')
                    ->assertPathIs('/registrasi')
                    ->type('Email_Pengguna', 'pengguna@example.com')
                    ->type('Nama_Pengguna', 'Pengguna Test')
                    ->type('Password_Pengguna', 'Abcd1234!')
                    ->type('Alamat_Pengguna', 'Jl. Contoh 1')
                    ->select('Role_Pengguna', 'Pengguna')
                    ->scrollTo('@terms-checkbox')
                    ->check('@terms-checkbox')
                    ->scrollTo('@submit-register')
                    ->click('@submit-register')
                    ->pause(2000)
                    ->assertPathIs('/login')
                    ->assertSee('Registrasi berhasil');
        });
    }

    /**
     * TC.Register.002: Semua data valid, role Donatur -> sukses
     */
    public function test_TC_Register_002_successfulRegistrationAsDonatur()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/registrasi')
                    ->assertPresent('@terms-checkbox')
                    ->type('Email_Pengguna', 'donatur@example.com')
                    ->type('Nama_Pengguna', 'Donatur Test')
                    ->type('Password_Pengguna', 'Xyz1234!')
                    ->type('Alamat_Pengguna', 'Jl. Contoh 2')
                    ->select('Role_Pengguna', 'Donatur')
                    ->scrollTo('@terms-checkbox')
                    ->check('@terms-checkbox')
                    ->scrollTo('@submit-register')
                    ->click('@submit-register')
                    ->pause(2000)
                    ->assertPathIs('/login')
                    ->assertSee('Registrasi berhasil');
        });
    }

    /**
     * TC.Register.003: Password < 8 -> error
     */
    public function test_TC_Register_003_passwordTooShort()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/registrasi')
                    ->type('Email_Pengguna', 'shortpass@example.com')
                    ->type('Nama_Pengguna', 'Short Pass')
                    ->type('Password_Pengguna', 'Ab1@f')
                    ->type('Alamat_Pengguna', 'Jl. Contoh 3')
                    ->select('Role_Pengguna', 'Pengguna')
                    ->scrollTo('@terms-checkbox')
                    ->check('@terms-checkbox')
                    ->scrollTo('@submit-register')
                    ->click('@submit-register')
                    ->pause(2000)
                    ->assertPathIs('/registrasi')
                    ->assertSee('The password pengguna field must be at least 8 characters');
        });
    }

    /**
     * TC.Register.004: Password > 12 -> error
     */
    public function test_TC_Register_004_passwordTooLong()
    {
        $this->browse(function (Browser $browser) {
            $long = 'Abcdefghijk1@';
            $browser->visit('/registrasi')
                    ->type('Email_Pengguna', 'longpass@example.com')
                    ->type('Nama_Pengguna', 'Long Pass')
                    ->type('Password_Pengguna', $long)
                    ->type('Alamat_Pengguna', 'Jl. Contoh 4')
                    ->select('Role_Pengguna', 'Pengguna')
                    ->scrollTo('@terms-checkbox')
                    ->check('@terms-checkbox')
                    ->scrollTo('@submit-register')
                    ->click('@submit-register')
                    ->pause(2000)
                    ->assertPathIs('/registrasi')
                    ->assertSee('The password pengguna field must not be greater than 12 characters');
        });
    }

    /**
     * TC.Register.005: Missing lowercase -> error
     */
    public function test_TC_Register_005_passwordMissingLowercase()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/registrasi')
                    ->type('Email_Pengguna', 'nolower@example.com')
                    ->type('Nama_Pengguna', 'No Lower')
                    ->type('Password_Pengguna', 'ABCDEFG1!')
                    ->type('Alamat_Pengguna', 'Jl. Contoh 5')
                    ->select('Role_Pengguna', 'Pengguna')
                    ->scrollTo('@terms-checkbox')
                    ->check('@terms-checkbox')
                    ->scrollTo('@submit-register')
                    ->click('@submit-register')
                    ->pause(2000)
                    ->assertPathIs('/registrasi')
                    ->assertSee('The password pengguna field format is invalid');
        });
    }

    /**
     * TC.Register.006: Missing uppercase -> error
     */
    public function test_TC_Register_006_passwordMissingUppercase()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/registrasi')
                    ->type('Email_Pengguna', 'noupper@example.com')
                    ->type('Nama_Pengguna', 'No Upper')
                    ->type('Password_Pengguna', 'abcdef12!')
                    ->type('Alamat_Pengguna', 'Jl. Contoh 6')
                    ->select('Role_Pengguna', 'Pengguna')
                    ->scrollTo('@terms-checkbox')
                    ->check('@terms-checkbox')
                    ->scrollTo('@submit-register')
                    ->click('@submit-register')
                    ->pause(2000)
                    ->assertPathIs('/registrasi')
                    ->assertSee('The password pengguna field format is invalid');
        });
    }

    /**
     * TC.Register.007: Missing number -> error
     */
    public function test_TC_Register_007_passwordMissingNumber()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/registrasi')
                    ->type('Email_Pengguna', 'nonumber@example.com')
                    ->type('Nama_Pengguna', 'No Number')
                    ->type('Password_Pengguna', 'Abcdefgh!')
                    ->type('Alamat_Pengguna', 'Jl. Contoh 7')
                    ->select('Role_Pengguna', 'Pengguna')
                    ->scrollTo('@terms-checkbox')
                    ->check('@terms-checkbox')
                    ->scrollTo('@submit-register')
                    ->click('@submit-register')
                    ->pause(2000)
                    ->assertPathIs('/registrasi')
                    ->assertSee('The password pengguna field format is invalid');
        });
    }

    /**
     * TC.Register.008: Missing symbol -> error
     */
    public function test_TC_Register_008_passwordMissingSymbol()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/registrasi')
                    ->type('Email_Pengguna', 'nosymbol@example.com')
                    ->type('Nama_Pengguna', 'No Symbol')
                    ->type('Password_Pengguna', 'Abcdefgh1')
                    ->type('Alamat_Pengguna', 'Jl. Contoh 8')
                    ->select('Role_Pengguna', 'Pengguna')
                    ->scrollTo('@terms-checkbox')
                    ->check('@terms-checkbox')
                    ->scrollTo('@submit-register')
                    ->click('@submit-register')
                    ->pause(2000)
                    ->assertPathIs('/registrasi')
                    ->assertSee('The password pengguna field format is invalid');
        });
    }

    /**
     * TC.Register.009: Empty address -> error
     */
    public function test_TC_Register_009_addressEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/registrasi')
                    ->type('Email_Pengguna', 'emptyaddr@example.com')
                    ->type('Nama_Pengguna', 'Empty Addr')
                    ->type('Password_Pengguna', 'Abcd1234!')
                    ->type('Alamat_Pengguna', '')
                    ->select('Role_Pengguna', 'Pengguna')
                    ->scrollTo('@terms-checkbox')
                    ->check('@terms-checkbox')
                    ->scrollTo('@submit-register')
                    ->click('@submit-register')
                    ->pause(2000)
                    ->assertPathIs('/registrasi');
        });
    }

    /**
     * TC.Register.010: Role not selected -> error
     */
    public function test_TC_Register_010_roleNotSelected()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/registrasi')
                    ->type('Email_Pengguna', 'norole@example.com')
                    ->type('Nama_Pengguna', 'No Role')
                    ->type('Password_Pengguna', 'Abcd1234!')
                    ->type('Alamat_Pengguna', 'Jl. Contoh 9')
                    // no role selected
                    ->scrollTo('@terms-checkbox')
                    ->check('@terms-checkbox')
                    ->scrollTo('@submit-register')
                    ->click('@submit-register')
                    ->pause(2000)
                    ->assertPathIs('/registrasi');
        });
    }

    /**
     * TC.Register.011: Invalid email format -> error
     */
    public function test_TC_Register_011_invalidEmail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/registrasi')
                    ->type('Email_Pengguna', 'useratexample.com')
                    ->type('Nama_Pengguna', 'Invalid Email')
                    ->type('Password_Pengguna', 'Abcd1234!')
                    ->type('Alamat_Pengguna', 'Jl. Contoh 10')
                    ->select('Role_Pengguna', 'Pengguna')
                    ->scrollTo('@terms-checkbox')
                    ->check('@terms-checkbox')
                    ->scrollTo('@submit-register')
                    ->click('@submit-register')
                    ->pause(2000)
                    ->assertPathIs('/registrasi');
        });
    }

    /**
     * TC.Register.012: Email already registered -> error
     */
    public function test_TC_Register_012_emailAlreadyRegistered()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/registrasi')
                    ->type('Email_Pengguna', 'pengguna@example.com')
                    ->type('Nama_Pengguna', 'Existing')
                    ->type('Password_Pengguna', 'Abcd1234!')
                    ->type('Alamat_Pengguna', 'Jl. Contoh 11')
                    ->select('Role_Pengguna', 'Pengguna')
                    ->scrollTo('@terms-checkbox')
                    ->check('@terms-checkbox')
                    ->scrollTo('@submit-register')
                    ->click('@submit-register')
                    ->pause(2000)
                    ->assertPathIs('/registrasi')
                    ->assertSee('The email pengguna has already been taken.');
        });
    }
}