<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TunggakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create sample data if no students exist
        if (DB::table('students')->count() === 0) {
            for ($i = 1; $i <= 50; $i++) {
                $studentId = DB::table('students')->insertGetId([
                    'name' => 'Student ' . $i,
                    'nim' => 'NIM' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'faculty' => 'Fakultas ' . ($i % 3 + 1),
                    'major' => 'Major ' . ($i % 4 + 1),
                    'academic_year' => 2018 + ($i % 4),
                    'current_semester' => ($i % 8) + 1,
                    'status' => 'active',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                DB::table('receivables')->insert([
                    'receivable_code' => Str::random(10),
                    'student_id' => $studentId,
                    'amount' => rand(5, 20) * 1000000,
                    'paid_amount' => rand(1, 4) * 1000000,
                    'outstanding_amount' => rand(5, 10) * 1000000,
                    'due_date' => Carbon::now()->addDays(rand(-365, 0)),
                    'status' => 'pending',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                if ($i % 3 === 0) {
                    DB::table('payments')->insert([
                        'student_id' => $studentId,
                        'amount' => rand(1, 3) * 1000000,
                        'payment_date' => Carbon::now()->subDays(rand(1, 90)),
                        'status' => 'verified',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }
}
