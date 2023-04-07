<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'surname' => $this->faker->lastname(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('12345678'),
            'telephone' => $this->faker->numerify(),
            'email_verified_at' => now(),
            'profile_photo_path' => $this->faker->imageUrl($width = 1024, $height = 1024),
            'active' => $this->faker->randomElement(['1', '0']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
