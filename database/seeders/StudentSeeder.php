<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $studyPrograms = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Manajemen Informatika',
            'Teknik Komputer',
            'Akuntansi',
            'Manajemen',
            'Administrasi Bisnis',
            'Psikologi',
            'Hukum',
            'Kedokteran'
        ];
        
        $classes = ['X', 'XI', 'XII'];
        $statuses = ['active', 'inactive', 'graduated'];
        
        for ($i = 1; $i <= 50; $i++) {
            Student::updateOrCreate(
                ['student_id' => 'STD' . str_pad($i, 4, '0', STR_PAD_LEFT)],
                [
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'birth_date' => $faker->date('Y-m-d', '2005-01-01'),
                    'gender' => $faker->randomElement(['male', 'female']),
                    'program_study' => $faker->randomElement($studyPrograms),
                    'class' => $faker->randomElement($classes),
                    'academic_year' => '2024/2025',
                    'status' => $faker->randomElement($statuses),
                    'parent_name' => $faker->name,
                    'parent_phone' => $faker->phoneNumber,
                    'total_fee' => $faker->randomFloat(2, 5000000, 20000000),
                    'paid_amount' => $faker->randomFloat(2, 0, 10000000),
                    'outstanding_amount' => $faker->randomFloat(2, 0, 15000000),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
