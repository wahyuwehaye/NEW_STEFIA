<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Major;
use App\Models\Faculty;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample majors for different faculties
        $majors = [
            // Fakultas Teknik
            ['name' => 'Teknik Informatika', 'code' => 'TI', 'faculty_id' => 1],
            ['name' => 'Teknik Sipil', 'code' => 'TS', 'faculty_id' => 1],
            ['name' => 'Teknik Elektro', 'code' => 'TE', 'faculty_id' => 1],
            ['name' => 'Teknik Mesin', 'code' => 'TM', 'faculty_id' => 1],
            
            // Fakultas Ekonomi
            ['name' => 'Manajemen', 'code' => 'MJ', 'faculty_id' => 2],
            ['name' => 'Akuntansi', 'code' => 'AK', 'faculty_id' => 2],
            ['name' => 'Ekonomi Pembangunan', 'code' => 'EP', 'faculty_id' => 2],
            
            // Fakultas Hukum
            ['name' => 'Ilmu Hukum', 'code' => 'IH', 'faculty_id' => 3],
            
            // Fakultas Sastra
            ['name' => 'Sastra Indonesia', 'code' => 'SI', 'faculty_id' => 4],
            ['name' => 'Sastra Inggris', 'code' => 'SG', 'faculty_id' => 4],
            
            // Fakultas MIPA
            ['name' => 'Matematika', 'code' => 'MT', 'faculty_id' => 5],
            ['name' => 'Fisika', 'code' => 'FI', 'faculty_id' => 5],
            ['name' => 'Kimia', 'code' => 'KI', 'faculty_id' => 5],
            ['name' => 'Biologi', 'code' => 'BI', 'faculty_id' => 5],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }
    }
}
