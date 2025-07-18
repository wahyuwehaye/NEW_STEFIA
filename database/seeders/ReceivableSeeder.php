<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Receivable;
use App\Models\Student;
use App\Models\Fee;
use App\Models\User;
use Carbon\Carbon;

class ReceivableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have students and fees
        if (Student::count() === 0) {
            Student::factory(50)->create();
        }
        
        // Create some basic fees if none exist
        if (Fee::count() === 0) {
            $creator = User::first();
            if (!$creator) {
                $creator = User::factory()->create([
                    'name' => 'Admin',
                    'email' => 'admin@example.com',
                ]);
            }
            
            $basicFees = [
                ['name' => 'Biaya Kuliah Semester 1', 'type' => 'tuition', 'amount' => 2500000],
                ['name' => 'Biaya Laboratorium', 'type' => 'laboratory', 'amount' => 500000],
                ['name' => 'Biaya Perpustakaan', 'type' => 'library', 'amount' => 200000],
                ['name' => 'Biaya Pendaftaran', 'type' => 'registration', 'amount' => 300000],
                ['name' => 'Biaya Ujian', 'type' => 'exam', 'amount' => 150000],
            ];
            
            foreach ($basicFees as $feeData) {
                Fee::create(array_merge($feeData, [
                    'description' => 'Biaya ' . $feeData['name'],
                    'frequency' => 'semester',
                    'academic_year' => '2024/2025',
                    'effective_date' => now(),
                    'status' => 'active',
                    'is_mandatory' => true,
                    'penalty_rate' => 2.5,
                    'grace_period_days' => 7,
                    'created_by' => $creator->id,
                ]));
            }
        }
        
        $students = Student::all();
        $fees = Fee::all();
        $creator = User::first();
        
        if (!$creator) {
            $creator = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
            ]);
        }
        
        $categories = ['tuition', 'lab', 'library', 'dormitory', 'fine', 'other'];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        $statuses = ['pending', 'partial', 'paid', 'overdue'];
        $types = ['manual', 'auto', 'igracias'];
        
        // Create receivables for different scenarios
        foreach ($students as $student) {
            $receivableCount = rand(1, 5);
            
            for ($i = 0; $i < $receivableCount; $i++) {
                $amount = rand(500000, 5000000);
                $paidAmount = 0;
                $status = $statuses[array_rand($statuses)];
                
                // Set paid amount based on status
                if ($status === 'paid') {
                    $paidAmount = $amount;
                } elseif ($status === 'partial') {
                    $paidAmount = rand(100000, $amount - 100000);
                }
                
                $dueDate = Carbon::now()->addDays(rand(-30, 90));
                
                // If overdue, make sure due date is in the past
                if ($status === 'overdue') {
                    $dueDate = Carbon::now()->subDays(rand(1, 30));
                }
                
                $receivableCode = 'RCV' . date('y') . str_pad(($student->id * 1000 + $i), 6, '0', STR_PAD_LEFT);
                
                $receivable = Receivable::create([
                    'receivable_code' => $receivableCode,
                    'student_id' => $student->id,
                    'fee_id' => $fees->random()->id,
                    'type' => $types[array_rand($types)],
                    'category' => $categories[array_rand($categories)],
                    'amount' => $amount,
                    'paid_amount' => $paidAmount,
                    'outstanding_amount' => $amount - $paidAmount,
                    'penalty_amount' => $status === 'overdue' ? rand(50000, 200000) : 0,
                    'penalty_percentage' => 2.5,
                    'due_date' => $dueDate,
                    'penalty_date' => $dueDate->copy()->addDays(7),
                    'status' => $status,
                    'priority' => $priorities[array_rand($priorities)],
                    'academic_year' => '2024/2025',
                    'semester' => rand(1, 8),
                    'description' => 'Pembayaran ' . ucfirst($categories[array_rand($categories)]) . ' semester ' . rand(1, 8),
                    'notes' => 'Catatan untuk receivable ' . $i,
                    'created_by' => $creator->id,
                    'last_reminder_sent' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 10)) : null,
                    'reminder_count' => rand(0, 3),
                    'auto_penalty' => rand(0, 1),
                    'igracias_id' => $types[array_rand($types)] === 'igracias' ? 'IGR' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT) : null,
                    'created_at' => Carbon::now()->subDays(rand(1, 180)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 30)),
                ]);
            }
        }
    }
}
