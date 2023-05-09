<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('general_expenses')->insert([
            [
                'name'=> 'Agua',
                'total'=>8.50
            ],
            [
                'name'=> 'Luz',
                'total'=>20.00

            ]

        ]);
    }
}
