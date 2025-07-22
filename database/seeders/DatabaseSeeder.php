<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FacultySeeder::class,
            DepartmentSeeder::class,
            AcademicYearSeeder::class,
            MajorSeeder::class,
            UserSeeder::class,
            StudentSeeder::class,
            StudentsSeeder::class,
            SuperAdminSeeder::class,
            NotificationSeeder::class,
            ReceivableSeeder::class,
            TunggakanSeeder::class,
        ]);
    }
}
