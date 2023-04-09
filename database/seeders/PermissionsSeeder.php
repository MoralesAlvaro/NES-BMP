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
        $encargado = Role::create(['name' => 'encargado']);
        $empleado = Role::create(['name' => 'empleado']);


        // **** PERMISOS ****

        /* USUARIOS */
        $user_index = Permission::create(['name' => 'user_index', 'descriptions' => 'Vista lista de usuarios']);
        $send_invitation = Permission::create(['name' => 'send_invitation', 'descriptions' => 'Vista enviar invitación']);
        $change_role = Permission::create(['name' => 'change_role', 'descriptions' => 'Cambiar el rol de un usuario']);

        // ----------------------------------------
        // **** ASIGNANDO PERMISOS A LOS ROLES ****

        // ----------------- PERMISOS root -----------------
        $permission_root = [
            $user_index, $send_invitation, $change_role
        ];
        $root->syncPermissions($permission_root);

        // ----------------- PERMISOS ADMINISTRADORES -----------------
        $permission_encargado = [
            $user_index
        ];
        $encargado->syncPermissions($permission_encargado);

        // ----------------- PERMISOS EMPLEADO -----------------
        $permission_empleado = [

        ];
        $empleado->syncPermissions($permission_empleado);

    }
}
