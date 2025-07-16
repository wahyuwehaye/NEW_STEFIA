<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            ['code' => 'FTE', 'name' => 'Fakultas Teknik Elektro'],
            ['code' => 'FTI', 'name' => 'Fakultas Teknik Industri'],
            ['code' => 'FIF', 'name' => 'Fakultas Informatika'],
            ['code' => 'FEB', 'name' => 'Fakultas Ekonomi dan Bisnis'],
            ['code' => 'FKB', 'name' => 'Fakultas Komunikasi dan Bisnis'],
            ['code' => 'FIT', 'name' => 'Fakultas Ilmu Terapan'],
            ['code' => 'FRI', 'name' => 'Fakultas Rekayasa Industri'],
        ];

        foreach ($faculties as $faculty) {
            \App\Models\Faculty::create($faculty);
        }
    }
}
