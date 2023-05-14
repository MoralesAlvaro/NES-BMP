<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeProduct;

class TypeProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeProduct::insert([
            [
                'name' => 'A la plancha',
                'cost' => '0.40',
                'description' => 'Preparado a la plancha',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Al carbón',
                'cost' => '0.50',
                'description' => 'Preparado al carbón',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sin cargo',
                'cost' => '0.00',
                'description' => 'Para bebidas, licores, antojitos u otro tipo que no requiere cargo adicional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
