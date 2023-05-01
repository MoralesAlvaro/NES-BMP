<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::insert([
            [
                'status_sale_id' => 1,
                'user_id' => 1,
                'type_doc_id' => 1,
                'sup_total' => 23.45,
                'discount' => 0,
                'total' => 23.45
            ]
        ]);

    }
}
