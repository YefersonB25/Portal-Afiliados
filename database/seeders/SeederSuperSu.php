<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Faker\Generator as Faker;

class SeederSuperSu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');



        $Admin               = Role::create(['name' => 'Administrador']);
        $Cliente             = Role::create(['name' => 'Cliente']);
        $ClienteHijo         = Role::create(['name' => 'ClienteHijo']);
        $Consultor           = Role::create(['name' => 'Consultor']);
        // $roleAdmin->syncPermissions($permisos);

        Permission::create(['name' => '/usuario.index', 'grupo' => 'proveedores-Usuarios', 'description' => 'Seguimiento solicitudes, modificar informacion de usuarios, consultar usuarios en OTM/ERP '])
            ->syncRoles([
                $Admin,
            ]);
        Permission::create(['name' => '/roles', 'grupo' => 'Roles', 'description' => 'Crear, editar, eliminar roles, asignar permisos a roles'])
            ->syncRoles([
                $Admin,
            ]);
        Permission::create(['name' => '/facturas', 'grupo' => 'Informacion-Facturas', 'description' => 'Consultar/ver seguimiento facturas'])
            ->syncRoles([
                $ClienteHijo,
                $Cliente,
            ]);
        Permission::create(['name' => '/profile', 'grupo' => 'Informacion-Personal', 'description' => 'Cunsultar/editar informacion, creacion de usuarios hijos'])
            ->syncRoles([
                $ClienteHijo,
                $Consultor,
                $Cliente,
                $Admin,
            ]);
        Permission::create(['name' => '/facturasGeneral', 'grupo' => 'Informacion-Facturas', 'description' => 'Consultar/ver seguimiento facturas'])
            ->syncRoles([
                $Consultor,
            ]);


            User::create([
                'name'          => 'Yeferson Bolaños Cardales',
                'number_id'     => '1002249426',
                'document_type' => 'CC',
                'email'         => 'ybolanos@tractocar.com',
                'phone'         => '3022360722',
                'status'        => 'CONFIRMADO',
                'password'      => bcrypt('123456')
            ])->assignRole('Administrador');
            User::create([
                'name'          => 'Elkin Moreno',
                'number_id'     => '1143413441',
                'document_type' => 'CC',
                'email'         => 'emoreno@tractocar.com',
                'phone'         => '3162543022',
                'status'        => 'CONFIRMADO',
                'password'      => bcrypt('123456')
            ])->assignRole('Administrador');

    }
}
