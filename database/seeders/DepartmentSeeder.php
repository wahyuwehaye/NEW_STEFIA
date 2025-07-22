<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            // Fakultas Teknik Elektro (FTE)
            ['code' => 'TE', 'name' => 'Teknik Elektro', 'faculty_id' => 1],
            ['code' => 'TT', 'name' => 'Teknik Telekomunikasi', 'faculty_id' => 1],
            ['code' => 'TF', 'name' => 'Teknik Fisika', 'faculty_id' => 1],
            
            // Fakultas Teknik Industri (FTI)
            ['code' => 'TI', 'name' => 'Teknik Industri', 'faculty_id' => 2],
            ['code' => 'TS', 'name' => 'Teknik Sistem Energi', 'faculty_id' => 2],
            
            // Fakultas Informatika (FIF)
            ['code' => 'IF', 'name' => 'Teknik Informatika', 'faculty_id' => 3],
            ['code' => 'SI', 'name' => 'Sistem Informasi', 'faculty_id' => 3],
            ['code' => 'TK', 'name' => 'Teknik Komputer', 'faculty_id' => 3],
            
            // Fakultas Ekonomi dan Bisnis (FEB)
            ['code' => 'MN', 'name' => 'Manajemen', 'faculty_id' => 4],
            ['code' => 'AK', 'name' => 'Akuntansi', 'faculty_id' => 4],
            ['code' => 'EP', 'name' => 'Ekonomi Pembangunan', 'faculty_id' => 4],
            
            // Fakultas Komunikasi dan Bisnis (FKB)
            ['code' => 'IK', 'name' => 'Ilmu Komunikasi', 'faculty_id' => 5],
            ['code' => 'DK', 'name' => 'Desain Komunikasi Visual', 'faculty_id' => 5],
            ['code' => 'AB', 'name' => 'Administrasi Bisnis', 'faculty_id' => 5],
            
            // Fakultas Ilmu Terapan (FIT)
            ['code' => 'TL', 'name' => 'Teknik Logistik', 'faculty_id' => 6],
            ['code' => 'KV', 'name' => 'Kewirausahaan', 'faculty_id' => 6],
            
            // Fakultas Rekayasa Industri (FRI)
            ['code' => 'RI', 'name' => 'Rekayasa Industri', 'faculty_id' => 7],
            ['code' => 'RT', 'name' => 'Rekayasa Tekstil', 'faculty_id' => 7],
        ];

        foreach ($departments as $department) {
            \App\Models\Department::updateOrCreate(
                ['code' => $department['code']],
                [
                    'name' => $department['name'],
                    'faculty_id' => $department['faculty_id']
                ]
            );
        }
    }
}
