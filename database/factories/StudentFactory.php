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
            'study_program' => fake()->randomElement(['Computer Science', 'Business Administration', 'Engineering', 'Medicine', 'Law']),
            'status' => fake()->randomElement(['active', 'inactive', 'graduated']),
            'date_of_birth' => fake()->date(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'admission_date' => fake()->dateTimeBetween('-3 years', 'now'),
        ];
    }
}
