<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusSale;

class StatusSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusSale::insert([
            [
                'name' => 'Pendiente',
                'description' => 'Pendiente de pago',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pagada',
                'description' => 'La factura ya fue pagada',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
