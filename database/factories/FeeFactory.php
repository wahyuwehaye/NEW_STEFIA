<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fee>
 */
class FeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Tuition Fee', 'Library Fee', 'Laboratory Fee', 'Sports Fee', 'Examination Fee']),
            'amount' => fake()->randomFloat(2, 100, 2000),
            'type' => fake()->randomElement(['tuition', 'library', 'laboratory', 'sports', 'examination']),
            'status' => fake()->randomElement(['active', 'inactive']),
            'description' => fake()->sentence(),
        ];
    }
}
