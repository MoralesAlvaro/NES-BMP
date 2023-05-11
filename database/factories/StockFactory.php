<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'raw_material_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'name' => $this->faker->name(),
            'cost' => $this->faker->numberBetween($min = 1, $max = 50),
            'mount' => $this->faker->numberBetween($min = 1, $max = 50),
            'gain' => $this->faker->numberBetween($min = 1, $max = 20),
            'active' => $this->faker->randomElement(['1', '0']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
