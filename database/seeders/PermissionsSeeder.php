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
        $master = Role::create(['name' => 'master']);
        $encargado = Role::create(['name' => 'encargado']);
        $empleado = Role::create(['name' => 'empleado']);


        // **** PERMISOS ****

        /* USUARIOS */
        $user_list = Permission::create(['name' => 'user_list', 'descriptions' => 'Vista lista de usuarios']);
        $send_invitation = Permission::create(['name' => 'send_invitation', 'descriptions' => 'Vista enviar invitación']);
        $change_role = Permission::create(['name' => 'change_role', 'descriptions' => 'Cambiar el rol de un usuario']);
        $user_destroy = Permission::create(['name' => 'user_destroy', 'descriptions' => 'Eliminar usuario']);

        /* CATEGORÍAS */
        $category_list = Permission::create(['name' => 'category_list', 'descriptions' => 'Vista lista de categorías']);
        $category_store = Permission::create(['name' => 'category_store', 'descriptions' => 'Vista y acción crear categoría']);
        $category_update = Permission::create(['name' => 'category_update', 'descriptions' => 'Vista y acción editar categoría']);
        $category_destroy = Permission::create(['name' => 'category_destroy', 'descriptions' => 'Vista y acción eliminar categoría']);

        /* PRODUCTOS */
        $product_list = Permission::create(['name' => 'product_list', 'descriptions' => 'Vista lista de productos']);
        $product_store = Permission::create(['name' => 'product_store', 'descriptions' => 'Vista y acción crear producto']);
        $product_update = Permission::create(['name' => 'product_update', 'descriptions' => 'Vista y acción editar producto']);
        $product_destroy = Permission::create(['name' => 'product_destroy', 'descriptions' => 'Vista y acción eliminar producto']);

        /* PRODUCTOS */
        $rawMaterial_list = Permission::create(['name' => 'rawMaterial_list', 'descriptions' => 'Vista lista de Materia Prima']);
        $rawMaterial_store = Permission::create(['name' => 'rawMaterial_store', 'descriptions' => 'Vista y acción crear Materia Prima']);
        $rawMaterial_update = Permission::create(['name' => 'rawMaterial_update', 'descriptions' => 'Vista y acción editar Materia Prima']);
        $rawMaterial_destroy = Permission::create(['name' => 'rawMaterial_destroy', 'descriptions' => 'Vista y acción eliminar Materia Prima']);

        /* STOCK */
        $stock_list = Permission::create(['name' => 'stock_list', 'descriptions' => 'Vista lista de stock']);
        $stock_store = Permission::create(['name' => 'stock_store', 'descriptions' => 'Vista y acción crear stock']);
        $stock_update = Permission::create(['name' => 'stock_update', 'descriptions' => 'Vista y acción editar stock']);
        $stock_destroy = Permission::create(['name' => 'stock_destroy', 'descriptions' => 'Vista y acción eliminar stock']);

        /* SALE */
        $sale_list = Permission::create(['name' => 'sale_list', 'descriptions' => 'Vista lista de ventas']);
        $sale_store = Permission::create(['name' => 'sale_store', 'descriptions' => 'Vista y acción crear ventas']);
        $sale_update = Permission::create(['name' => 'sale_update', 'descriptions' => 'Vista y acción editar ventas']);
        $sale_destroy = Permission::create(['name' => 'sale_destroy', 'descriptions' => 'Vista y acción eliminar ventas']);

        /* DETAIL SALE */
        $detailSale_list = Permission::create(['name' => 'detailSale_list', 'descriptions' => 'Vista lista de ventas']);
        $detailSale_store = Permission::create(['name' => 'detailSale_store', 'descriptions' => 'Vista y acción crear ventas']);
        $detailSale_update = Permission::create(['name' => 'detailSale_update', 'descriptions' => 'Vista y acción editar ventas']);
        $detailSale_destroy = Permission::create(['name' => 'detailSale_destroy', 'descriptions' => 'Vista y acción eliminar ventas']);



        // ----------------------------------------
        // **** ASIGNANDO PERMISOS A LOS ROLES ****

        // ----------------- PERMISOS master -----------------
        $permission_master = [
            $user_list, $send_invitation, $change_role, $user_destroy,
            $category_list, $category_store, $category_update, $category_destroy,
            $product_list, $product_store, $product_update, $product_destroy,
            $rawMaterial_list, $rawMaterial_store, $rawMaterial_update, $rawMaterial_destroy,
            $stock_list, $stock_store, $stock_update, $stock_destroy,
            $sale_list, $sale_store, $sale_update, $sale_destroy,
            $detailSale_list, $detailSale_store, $detailSale_update, $detailSale_destroy,
        ];
        $master->syncPermissions($permission_master);

        // ----------------- PERMISOS ADMINISTRADORES -----------------
        $permission_encargado = [
            $user_list, $send_invitation, $change_role, $user_destroy,
            $category_list, $category_store, $category_update, $category_destroy,
            $product_list, $product_store, $product_update, $product_destroy,

            $rawMaterial_list, $rawMaterial_store, $rawMaterial_update, $rawMaterial_destroy,
            $stock_list, $stock_store, $stock_update, $stock_destroy,
            $sale_list, $sale_store, $sale_update, $sale_destroy,
            $detailSale_list, $detailSale_store, $detailSale_update, $detailSale_destroy,
        ];
        $encargado->syncPermissions($permission_encargado);

        // ----------------- PERMISOS EMPLEADO -----------------
        $permission_empleado = [

        ];
        $empleado->syncPermissions($permission_empleado);

    }
}
