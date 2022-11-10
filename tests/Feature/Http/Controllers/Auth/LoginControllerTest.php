<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    // use DatabaseMigrations;

    /** @test */
    public function login_displays_validation_errors()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');

    }

    /** @test */
    public function it_visit_page_of_login()
    {
        $this->get('/login')
        ->assertStatus(200)
        ->assertSee('Login');
    }

    /** @test */
    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }

    /** @test */
    public function test_user_can_login_with_correct_credentials()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'password' => bcrypt($password = '123456'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('1234567'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function test_remember_me_functionality()
    {
        $user = User::factory()->create([
            'id' => random_int(1, 100),
            'password' => bcrypt($password = '123456'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);

        $response->assertRedirect('/home');
        // cookie assertion goes here
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_user_receives_an_email_with_a_password_reset_link()
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->post('/password/email', [
            'email' => $user->email,
        ]);
        $response->assertStatus(302);
        // assertions go here
    }

    public function test_an_action_that_requires_authentication()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/login');
        $response->assertRedirect('/home');

    }

}
