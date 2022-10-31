<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    // public function login_displays_validation_errors()
    // {
    //      $this->withoutExceptionHandling();


    //     $response = $this->post(route('login'), []);

    //     $response->assertStatus(302);
    //     $response->assertSessionHasErrors('email');
    // }



}
