<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    // use RefreshDatabase;
    use DatabaseMigrations;

    /** @test */
    public function it_visit_page_of_register()
    {
        $this->get('/register')
            ->assertStatus(200)
            ->assertSee('Register');
    }

    /** @test */
    public function register_displays_validation_errors()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');

    }

    /** @test */
    // public function users_can_be_created()
    // {
    //     $this->withoutExceptionHandling();

    //     $response = $this->post('/register', [
    //         'name' => 'Test',
    //         'identification' => '2353252',
    //         'email' => 'r@rr.b',
    //         'telefono' => '123123123',
    //         'estado' => '2',
    //         'password' => '123456'
    //     ]);

    //     $response->assertOk();

    // }


}
