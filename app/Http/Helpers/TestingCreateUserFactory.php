<?php

namespace App\Http\Helpers;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TestingCreateUserFactory
{

    public static function userCreate(){

        $rolCliente              = Role::create(['name' => 'Cliente']);

        Permission::create(['name' => '/blog', 'grupo' => 'Informacion-Facturas', 'description' => 'Seguimiento Facturas'])
        ->syncRoles([
          $rolCliente
        ]);

        $user = User::factory()->create([
        ])->assignRole('Cliente');

        return $user;
    }
}

?>
