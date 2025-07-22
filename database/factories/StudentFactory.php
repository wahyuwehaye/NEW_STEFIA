<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
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
            'email' => fake()->unique()->safeEmail(),
            'student_id' => fake()->unique()->numerify('########'),
            'program_study' => fake()->randomElement(['Teknik Informatika', 'Manajemen', 'Hukum', 'Kedokteran']),
            'class' => fake()->randomElement(['A', 'B', 'C']),
            'academic_year' => fake()->randomElement(['2022/2023', '2023/2024', '2024/2025']),
            'birth_date' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'status' => fake()->randomElement(['active', 'inactive', 'graduated', 'dropped_out']),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'parent_name' => fake()->name(),
            'parent_phone' => fake()->phoneNumber(),
            'total_fee' => fake()->numberBetween(5000000, 15000000),
            'paid_amount' => fake()->numberBetween(1000000, 5000000),
            'outstanding_amount' => fake()->numberBetween(0, 10000000),
            'metadata' => null,
        ];
    }
}
