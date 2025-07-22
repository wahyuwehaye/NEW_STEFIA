<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Payment;
use Carbon\Carbon;

class ManualPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'email' => 'dummyuser@stefia.com',
            'password' => bcrypt('password'),
        ]);
        $student = Student::factory()->create([
            'email' => 'dummystudent@stefia.com',
        ]);
        for ($i = 1; $i <= 10; $i++) {
            Payment::create([
                'student_id' => $student->id,
                'user_id' => $user->id,
                'amount' => rand(100000, 2000000),
                'payment_date' => Carbon::now()->subDays(rand(0, 28)),
                'status' => ['completed', 'pending', 'failed'][rand(0,2)],
                'payment_method' => ['cash', 'bank_transfer', 'e_wallet'][rand(0,2)],
                'payment_type' => ['tuition', 'registration', 'exam', 'library'][rand(0,3)],
                'reference_number' => 'REF' . rand(1000,9999),
                'description' => 'Dummy payment ' . $i,
            ]);
        }
    }
} 