<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RawMaterial;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // RawMaterial::factory()->count(1)->create();
        RawMaterial::insert([
            [
                "product_id" => 11,
                "total" => 4,
                "quantity" => "2 bandejas",
                "parts" => 8,
                "cost" => 0.50,
                "active" => true,
                'created_at' => now(),
                'updated_at' => now(),

            ]
        ]);
    }
}
