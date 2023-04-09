<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Comida',
                'description' => 'Todos los platillos ...',
                'active' => true
            ],
            [
                'name' => 'Antojito',
                'description' => 'Antojitos: Empanadas, Pastelitos, Enchiladas ...',
                'active' => true
            ],
            [
                'name' => 'Bebida',
                'description' => 'Bebidas: Sodas, Frescos, Jugos, licuados ...',
                'active' => true
            ],
            [
                'name' => 'Licores',
                'description' => 'Mojitos, Margaritas, Chots ...',
                'active' => true
            ],
        ]);
    }
}
