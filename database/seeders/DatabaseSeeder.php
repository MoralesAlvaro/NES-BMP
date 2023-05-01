<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\RawMaterialSeeder;
use Database\Seeders\StockSeeder;
use Database\Seeders\StatusSaleSeeder;
use Database\Seeders\TypeDocSeeder;
use Database\Seeders\SaleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Reseteando tablas
        $this->truncateTables([
            'roles',
            'permissions',
            'model_has_permissions',
            'model_has_roles',
            'role_has_permissions',
            'users',
            'categories',
            'products',
            'raw_materials',
            'stocks',
            'status_sales',
            'type_docs',
            'sales'
        ]);
        // $this->call(UserSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(RawMaterialSeeder::class);
        $this->call(StockSeeder::class);
        $this->call(StatusSaleSeeder::class);
        $this->call(TypeDocSeeder::class);
        $this->call(SaleSeeder::class);

    }

    // Método para resetear tablas
    public function truncateTables(array $tables)
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
