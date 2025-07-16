<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicYear;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = [
            ['year' => '2021/2022', 'is_active' => false],
            ['year' => '2022/2023', 'is_active' => false],
            ['year' => '2023/2024', 'is_active' => true],
            ['year' => '2024/2025', 'is_active' => false],
            ['year' => '2025/2026', 'is_active' => false],
        ];

        foreach ($academicYears as $academicYear) {
            AcademicYear::create($academicYear);
        }
    }
}
