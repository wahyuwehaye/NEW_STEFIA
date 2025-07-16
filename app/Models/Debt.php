<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Debt extends Model
{
    protected $fillable = [
        'debt_code',
        'student_id',
        'fee_id',
        'amount',
        'paid_amount',
        'due_date',
        'semester',
        'academic_year_id',
        'status',
        'priority',
        'description',
        'penalty_amount',
        'penalty_percentage',
        'created_by',
        'last_reminder_sent',
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'penalty_amount' => 'decimal:2',
        'penalty_percentage' => 'decimal:2',
        'last_reminder_sent' => 'datetime',
    ];

    /**
     * Get the student that owns this debt.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the fee that owns this debt.
     */
    public function fee(): BelongsTo
    {
        return $this->belongsTo(Fee::class);
    }

    /**
     * Get the academic year that owns this debt.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the user who created this debt.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the payments for this debt.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the billing actions for this debt.
     */
    public function billingActions(): HasMany
    {
        return $this->hasMany(BillingAction::class);
    }

    /**
     * Get the reminders for this debt.
     */
    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter overdue debts.
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())->where('status', '!=', 'paid');
    }

    /**
     * Scope to filter by semester.
     */
    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    /**
     * Get remaining amount.
     */
    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->paid_amount;
    }

    /**
     * Get total amount with penalty.
     */
    public function getTotalAmountWithPenaltyAttribute()
    {
        return $this->amount + $this->penalty_amount;
    }

    /**
     * Check if debt is overdue.
     */
    public function getIsOverdueAttribute()
    {
        return $this->due_date < now() && $this->status !== 'paid';
    }

    /**
     * Get formatted status.
     */
    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'paid' => 'Lunas',
            'partial' => 'Sebagian',
            'overdue' => 'Terlambat',
            default => $this->status,
        };
    }
}
