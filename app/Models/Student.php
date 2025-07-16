<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'nim',
        'external_id',
        'name',
        'email',
        'phone',
        'address',
        'birth_date',
        'birth_place',
        'gender',
        'class',
        'program_study',
        'academic_year',
        'faculty',
        'department',
        'major_id',
        'academic_year_id',
        'semester_menunggak',
        'cohort_year',
        'current_semester',
        'status',
        'father_name',
        'father_phone',
        'father_occupation',
        'father_address',
        'mother_name',
        'mother_phone',
        'mother_occupation',
        'mother_address',
        'total_fee',
        'paid_amount',
        'outstanding_amount',
        'outstanding_semesters',
        'last_payment_date',
        'is_reminded',
        'last_sync_at',
        'metadata',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'total_fee' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'outstanding_amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    // Relationships
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    // Removed receivables relationship - replaced with debts

    public function studentFees(): HasMany
    {
        return $this->hasMany(StudentFee::class);
    }

    public function fees(): HasManyThrough
    {
        return $this->hasManyThrough(Fee::class, StudentFee::class);
    }

    public function scholarshipApplications(): HasMany
    {
        return $this->hasMany(ScholarshipApplication::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }

    // New relationships
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(ParentModel::class, 'student_parents', 'student_id', 'parent_id')
                    ->withPivot('relationship')
                    ->withTimestamps();
    }

    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
    }

    public function studentParents(): HasMany
    {
        return $this->hasMany(StudentParent::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByClass($query, $class)
    {
        return $query->where('class', $class);
    }

    public function scopeByAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    public function scopeWithOutstandingPayments($query)
    {
        return $query->where('outstanding_amount', '>', 0);
    }

    // Accessors
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function getPaymentStatusAttribute(): string
    {
        if ($this->outstanding_amount == 0) {
            return 'paid';
        } elseif ($this->paid_amount > 0) {
            return 'partial';
        } else {
            return 'pending';
        }
    }

    // Business Logic Methods
    public function updatePaymentSummary(): void
    {
        $this->paid_amount = $this->payments()->where('status', 'completed')->sum('amount');
        $this->outstanding_amount = max(0, $this->total_fee - $this->paid_amount);
        $this->save();
    }

    public function calculateTotalFees(): void
    {
        $this->total_fee = $this->studentFees()->sum('amount');
        $this->updatePaymentSummary();
    }

    public function hasOutstandingPayments(): bool
    {
        return $this->outstanding_amount > 0;
    }

    public function getOverdueReceivables()
    {
        return $this->debts()
            ->where('status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->get();
    }

    public function getOverdueDebts()
    {
        return $this->debts()
            ->where('status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->get();
    }

    public function canApplyForScholarship(Scholarship $scholarship): bool
    {
        // Check if student already has an application for this scholarship
        $existingApplication = $this->scholarshipApplications()
            ->where('scholarship_id', $scholarship->id)
            ->first();

        if ($existingApplication) {
            return false;
        }

        // Check if scholarship is still open
        if ($scholarship->status !== 'open') {
            return false;
        }

        // Check if within application period
        $now = now()->toDateString();
        return $now >= $scholarship->application_start_date && $now <= $scholarship->application_end_date;
    }

    // Boot method for auto-generating student_id
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            if (empty($student->student_id)) {
                $student->student_id = static::generateStudentId();
            }
        });
    }

    public static function generateStudentId(): string
    {
        $year = date('Y');
        $prefix = 'STD' . $year;
        
        // Get the last student ID for this year
        $lastStudent = static::where('student_id', 'like', $prefix . '%')
            ->orderBy('student_id', 'desc')
            ->first();

        if ($lastStudent) {
            $lastNumber = (int) substr($lastStudent->student_id, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
