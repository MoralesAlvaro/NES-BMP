<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Product::factory()->count(3)->create();
        Product::insert([
            [
                "name" => "Licor puro",
                "description" => "",
                "category_id" => 4,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Capuchino",
                "description" => "",
                "category_id" => 3,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Café",
                "description" => "",
                "category_id" => 3,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Jugo natural",
                "description" => "",
                "category_id" => 3,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Jugo lata",
                "description" => "",
                "category_id" => 3,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Fresco",
                "description" => "",
                "category_id" => 3,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Soda",
                "description" => "",
                "category_id" => 3,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Tacos",
                "description" => "",
                "category_id" => 1,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Enzalada",
                "description" => "",
                "category_id" => 1,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Chimol",
                "description" => "",
                "category_id" => 1,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Chorizo",
                "description" => "",
                "category_id" => 1,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Arroz",
                "description" => "",
                "category_id" => 1,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Carne",
                "description" => "",
                "category_id" => 1,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "name" => "Pollo",
                "description" => "",
                "category_id" => 1,
                "active" => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
