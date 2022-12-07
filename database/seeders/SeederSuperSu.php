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
        // Estado::create(['descripcion' => 'Nuevo']);
        // Estado::create(['descripcion' => 'Confirmado']);
        // Estado::create(['descripcion' => 'Rechazado']);
        // Estado::create(['descripcion' => 'Asociado']);


        $roleAdmin              = Role::create(['name' => 'Administrador']);
        $rolCliente             = Role::create(['name' => 'Cliente']);
        $rolClienteHijo         = Role::create(['name' => 'ClienteHijo']);
        // $roleAdmin->syncPermissions($permisos);

        Permission::create(['name' => '/usuario.index', 'grupo' => 'proveedores-Usuarios', 'description' => 'Seguimiento Solicitudes'])
            ->syncRoles([
                $roleAdmin,
            ]);
        Permission::create(['name' => '/blog', 'grupo' => 'Informacion-Facturas', 'description' => 'Seguimiento Facturas'])
            ->syncRoles([
                $rolClienteHijo,
                $rolCliente,
            ]);
        Permission::create(['name' => '/profile', 'grupo' => 'Informacion-Personal', 'description' => 'informacion'])
            ->syncRoles([
                $rolClienteHijo,
                $rolCliente,
                $roleAdmin,
            ]);


            //!estos datos son para pruebas de rendimiento con muchos usuarios en el sistema
        // $status = [
        //     1 => 'NUEVO',
        //     2 => 'CONFIRMADO',
        //     3 => 'RECHAZADO'
        // ];
        // for ($i = 0; $i < 500; $i++) {
        //     $faker          = Factory::create();
        //     User::create([
        //         'name'           => $faker->firstName(),
        //         'identification' => random_int(900, 900000),
        //         'email'          => $faker->email(),
        //         'telefono'       => random_int(1, 9000000),
        //         'seleccion_nit'  => '',
        //         'estado'         => $status[random_int(1, 3)],
        //         'password'       => bcrypt('123456')
        //     ])->assignRole('Administrador');
        // }


        $userSu = User::where('email', '=', 'ybolanos@tractocar.com')->first();
        if ($userSu) {
            $userSu->assignRole('Administrador');
        } else {
            User::create([
                'name'           => 'Yeferson Bolaños Cardales',
                'identification' => '2342432',
                'email'          => 'ybolanos@tractocar.com',
                'telefono'       => '3162543022',
                'seleccion_nit'  => '',
                'estado'         => 'CONFIRMADO',
                'password'       => bcrypt('123456')
            ])->assignRole('Administrador');
            User::create([
                'name'           => 'Testing',
                'identification' => '2342432',
                'email'          => 'test@test.com',
                'telefono'       => '',
                'seleccion_nit'  => '',
                'estado'         => 'NUEVO',
                'password'       => bcrypt('123456')
            ])->assignRole('Cliente');
        }
    }
}
