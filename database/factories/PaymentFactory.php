<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => \App\Models\Student::factory(),
            'amount' => fake()->randomFloat(2, 100, 5000),
            'payment_date' => fake()->dateTimeBetween('-1 years', 'now'),
            'status' => fake()->randomElement(['completed', 'pending', 'failed']),
        ];
    }
}
