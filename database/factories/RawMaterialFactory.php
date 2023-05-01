<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RawMaterial>
 */
class RawMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'total' => $this->faker->numberBetween($min = 1, $max = 100),
            'quantity' => $this->faker->text(20),
            'parts' => $this->faker->numberBetween($min = 1, $max = 50),
            'cost' => $this->faker->numberBetween($min = 1, $max = 20),
            'active' => $this->faker->randomElement(['1', '0']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
