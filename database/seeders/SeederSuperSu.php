<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


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


        $permisos = [
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',
        ];

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }

        $roleAdmin              = Role::create(['name' => 'Administrador']);
        $rolCliente             = Role::create(['name' => 'Cliente']);
        $roleAdmin->syncPermissions($permisos);


        $userSu = User::where('email', '=', 'ybolanos@tractocar.com')->first();
        if ($userSu) {
            $userSu->assignRole('Administrador');
        } else {
            User::create([
                'name' => 'Yeferson Bolaños Cardales',
                'email' => 'ybolanos@tractocar.com',
                'password' => bcrypt('123456')
            ])->assignRole('Administrador');
        }
    }
}
