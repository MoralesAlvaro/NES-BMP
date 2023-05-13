<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\General_expense;

class GeneralExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        General_expense::insert([
            [
                'name'=> 'Agua',
                'total'=>8.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'=> 'Luz',
                'total'=>20.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}
