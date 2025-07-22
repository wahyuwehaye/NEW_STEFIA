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
            'user_id' => \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory(),
            'amount' => fake()->randomFloat(2, 100, 5000),
            'payment_date' => fake()->dateTimeBetween('first day of this month', 'last day of this month'),
            'status' => fake()->randomElement(['completed', 'pending', 'failed']),
        ];
    }
}
