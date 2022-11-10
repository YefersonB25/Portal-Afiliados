<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class Validacion_Rutas_GeneralesTest extends TestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;


    public function test_rutas_user()
    {
        $this->withoutExceptionHandling();

        $roleAdmin              = Role::create(['name' => 'Administrador']);

        Permission::create(['name' => '/usuario.index', 'grupo' => 'proveedores-Usuarios', 'description' => 'Seguimiento Solicitudes'])
        ->syncRoles([
        $roleAdmin,
        ]);

        $user = User::factory()->create([
        'email' => 'ybolanos@tractocar.com',
        'password' => bcrypt($password = '123456'),
        'estado' => '2'
        ])->assignRole('Administrador');

        $response = $this->actingAs($user)->get('/usuarios')->assertStatus(200);

        $response->assertOk();
    }

    public function test_rutas_profile(){
        $this->withoutExceptionHandling();

        $rolCliente             = Role::create(['name' => 'Cliente']);

        Permission::create(['name' => '/profile', 'grupo' => 'Informacion-Personal', 'description' => 'informacion'])
        ->syncRoles([
            $rolCliente,
        ]);

        $user = User::factory()->create([
        ])->assignRole('Cliente');

        $response = $this->actingAs($user)->get('/profile')->assertStatus(200);

        $response->assertOk();
    }

}
