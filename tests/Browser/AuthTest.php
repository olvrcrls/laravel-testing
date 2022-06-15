<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_register_correctly()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit("/register")
                    ->type("name", "User")
                    ->type("email", "user@mail.com")
                    ->type("password", "password")
                    ->type("password_confirmation", "password")
                    ->click('button[type="submit"]')
                    ->assertSee("You're logged in!")
                    ->click("#navbarDropdown")
                    ->click("@logout-button")
                    ->assertGuest();
        });
    } // a_user_can_register_correctly

    /** @test */
    public function a_user_can_login_correctly()
    {
        User::create([
            "name" => "User",
            "email" => "user@mail.com",
            "password" => bcrypt("password")
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit("/login")
                    ->type("email", "user@mail.com")
                    ->type("password", "password")
                    ->click('@login-button')
                    ->assertSee("You're logged in!");
        });
    } // a_user_can_login_correctly
}
