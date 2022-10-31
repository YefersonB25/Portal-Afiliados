<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class Validacion_Rutas_GeneralesTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_rutas_user()
    {
         $this->withoutExceptionHandling();


        $response = $this->get('/home');

        $response->assertOk();
    }
}
