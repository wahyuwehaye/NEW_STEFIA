<?php

use App\Models\Student;
use App\Models\Payment;
use App\Models\Receivable;
use App\Models\Fee;
use App\Models\StudentFee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
    ]);
    
    $this->student = Student::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'student_id' => 'STD20240001',
        'class' => '12A',
        'academic_year' => '2024/2025',
        'status' => 'active',
        'total_fee' => 1000000,
        'paid_amount' => 0,
        'outstanding_amount' => 1000000,
    ]);
});

test('student can be created with valid data', function () {
    expect($this->student)->toBeInstanceOf(Student::class);
    expect($this->student->name)->toBe('John Doe');
    expect($this->student->student_id)->toBe('STD20240001');
    expect($this->student->status)->toBe('active');
});

test('student generates auto student_id when not provided', function () {
    $student = Student::factory()->create(['student_id' => null]);
    
    expect($student->student_id)->toStartWith('STD');
    expect($student->student_id)->toHaveLength(11); // STD + year (4) + number (4)
});

test('student can calculate payment status correctly', function () {
    // Test pending status
    expect($this->student->payment_status)->toBe('pending');
    
    // Test partial status
    $this->student->update(['paid_amount' => 500000, 'outstanding_amount' => 500000]);
    expect($this->student->payment_status)->toBe('partial');
    
    // Test paid status
    $this->student->update(['paid_amount' => 1000000, 'outstanding_amount' => 0]);
    expect($this->student->payment_status)->toBe('paid');
});

test('student can update payment summary', function () {
    // Create completed payments
    Payment::factory()->create([
        'student_id' => $this->student->id,
        'amount' => 300000,
        'status' => 'completed',
    ]);
    
    Payment::factory()->create([
        'student_id' => $this->student->id,
        'amount' => 200000,
        'status' => 'completed',
    ]);
    
    // Create pending payment (should not be included)
    Payment::factory()->create([
        'student_id' => $this->student->id,
        'amount' => 100000,
        'status' => 'pending',
    ]);
    
    $this->student->updatePaymentSummary();
    
    expect($this->student->paid_amount)->toBe(500000.0);
    expect($this->student->outstanding_amount)->toBe(500000.0);
});

test('student can check if has outstanding payments', function () {
    expect($this->student->hasOutstandingPayments())->toBeTrue();
    
    $this->student->update(['outstanding_amount' => 0]);
    expect($this->student->hasOutstandingPayments())->toBeFalse();
});

test('student can get overdue receivables', function () {
    // Create overdue receivable
    Receivable::factory()->create([
        'student_id' => $this->student->id,
        'due_date' => now()->subDays(10),
        'status' => 'pending',
        'outstanding_amount' => 100000,
    ]);
    
    // Create current receivable
    Receivable::factory()->create([
        'student_id' => $this->student->id,
        'due_date' => now()->addDays(10),
        'status' => 'pending',
        'outstanding_amount' => 200000,
    ]);
    
    // Create paid receivable (should not be included)
    Receivable::factory()->create([
        'student_id' => $this->student->id,
        'due_date' => now()->subDays(5),
        'status' => 'paid',
        'outstanding_amount' => 0,
    ]);
    
    $overdueReceivables = $this->student->getOverdueReceivables();
    
    expect($overdueReceivables)->toHaveCount(1);
    expect($overdueReceivables->first()->outstanding_amount)->toBe(100000.0);
});

test('student can calculate total fees from student fees', function () {
    $fee1 = Fee::factory()->create(['amount' => 500000]);
    $fee2 = Fee::factory()->create(['amount' => 300000]);
    
    StudentFee::factory()->create([
        'student_id' => $this->student->id,
        'fee_id' => $fee1->id,
        'amount' => 500000,
    ]);
    
    StudentFee::factory()->create([
        'student_id' => $this->student->id,
        'fee_id' => $fee2->id,
        'amount' => 300000,
    ]);
    
    $this->student->calculateTotalFees();
    
    expect($this->student->total_fee)->toBe(800000.0);
});

test('student scopes work correctly', function () {
    Student::factory()->create(['status' => 'inactive']);
    Student::factory()->create(['status' => 'graduated']);
    Student::factory()->create(['class' => '11A']);
    Student::factory()->create(['academic_year' => '2023/2024']);
    Student::factory()->create(['outstanding_amount' => 0]);
    
    expect(Student::active()->count())->toBe(1); // Only our main student
    expect(Student::byClass('12A')->count())->toBe(1);
    expect(Student::byAcademicYear('2024/2025')->count())->toBe(1);
    expect(Student::withOutstandingPayments()->count())->toBe(1);
});

test('student is_active accessor works correctly', function () {
    expect($this->student->is_active)->toBeTrue();
    
    $this->student->update(['status' => 'inactive']);
    expect($this->student->is_active)->toBeFalse();
});

test('student full_name accessor returns name', function () {
    expect($this->student->full_name)->toBe('John Doe');
});
