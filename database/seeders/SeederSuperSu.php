<?php

namespace Database\Seeders;

use App\Models\Estado;
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


        // $permisos = [
        //     'ver-rol',
        //     'crear-rol',
        //     'editar-rol',
        //     'borrar-rol',
        //     'ver-usuarios',
        //     'crear-usuarios',
        //     'editar-usuarios',
        //     'borrar-usuarios',
        // ];


        // foreach ($permisos as $permiso) {
        //     Permission::create(['name' => $permiso]);
        // }


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
                $Cliente,
                $Admin,
            ]);
        Permission::create(['name' => '/facturasGeneral', 'grupo' => 'Informacion-Facturas', 'description' => 'Consultar/ver seguimiento facturas'])
            ->syncRoles([
                $Consultor,
            ]);


        //!estos datos son para pruebas de rendimiento con muchos usuarios en el sistema
        $status = [
            1 => 'NUEVO',
            2 => 'CONFIRMADO',
            3 => 'RECHAZADO',
            4 => 'ASOCIADO'
        ];
        $document = [
            1 => 'CC',
            2 => 'NIT',
        ];
        for ($i = 0; $i < 500; $i++) {
            $faker          = Factory::create();
            User::create([
                'name'          => $faker->firstName(),
                'number_id'     => random_int(900, 900000),
                'document_type' => $document[random_int(1, 2)],
                'email'         => $faker->email(),
                'phone'         => random_int(1, 9000000),
                'status'        => $status[random_int(1, 3)],
                'password'      => bcrypt('123456')
            ])->assignRole('Administrador');
        }

        $userSu = User::where('email', '=', 'ybolanos@tractocar.com')->first();
        if ($userSu) {
            $userSu->assignRole('Administrador');
        } else {
            User::create([
                'name'          => 'Yeferson Bolaños Cardales',
                'number_id'     => '2342432',
                'document_type' => 'CC',
                'email'         => 'ybolanos@tractocar.com',
                'phone'         => '3162543022',
                'status'        => 'CONFIRMADO',
                'password'      => bcrypt('123456')
            ])->assignRole('Administrador');
            User::create([
                'name'          => 'Elkin Moreno',
                'number_id'     => '79108317',
                'document_type' => 'CC',
                'email'         => 'emoreno@tractocar.com',
                'phone'         => '3162543022',
                'status'        => 'CONFIRMADO',
                'password'      => bcrypt('123456')
            ])->assignRole('Cliente');
            User::create([
                'name'          => 'Consultor',
                'number_id'     => '24624662',
                'document_type' => 'CC',
                'email'         => 'consultor@gmail.com',
                'phone'         => '3162543022',
                'status'        => 'CONFIRMADO',
                'password'      => bcrypt('123456')
            ])->assignRole('Consultor');
        }
    }
}
