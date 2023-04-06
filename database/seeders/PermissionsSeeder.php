<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // ----------------------------------------
        // ROLES
        $root = Role::create(['name' => 'root']);
        $administrador = Role::create(['name' => 'administrador']);
        $encargado = Role::create(['name' => 'encargado']);


        // **** PERMISOS ****

        /* USUARIOS */
        $user_index = Permission::create(['name' => 'user_index', 'descriptions' => 'Vista lista de usuarios']);

        // ----------------------------------------
        // **** ASIGNANDO PERMISOS A LOS ROLES ****

        // ----------------- PERMISOS root -----------------
        $permission_root = [
            $user_index
        ];
        $root->syncPermissions($permission_root);

        // ----------------- PERMISOS ADMINISTRADORES -----------------
        $permission_administrador = [
            $user_index
        ];
        $administrador->syncPermissions($permission_administrador);

        // ----------------- PERMISOS ENCARGADOS -----------------
        $permission_encargado = [
            
        ];
        $encargado->syncPermissions($permission_encargado);

    }
}
