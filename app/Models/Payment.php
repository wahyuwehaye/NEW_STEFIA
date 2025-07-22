<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_code',
        'student_id',
        'user_id',
        'debt_id', // For linking to specific receivables
        'amount',
        'payment_date',
        'payment_method',
        'payment_type',
        'reference_number',
        'status',
        'description',
        'notes',
        'receipt_number',
        'metadata',
        'verified_at',
        'verified_by',
        'source', // 'manual' or 'igracias'
        'igracias_id', // ID from iGracias system
        'igracias_data', // Raw data from iGracias
        'auto_applied', // Whether payment was auto-applied to receivables
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'igracias_data' => 'array',
        'verified_at' => 'datetime',
        'auto_applied' => 'boolean',
    ];

    // Relationships
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function debt(): BelongsTo
    {
        return $this->belongsTo(Debt::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    public function scopeByPaymentType($query, $type)
    {
        return $query->where('payment_type', $type);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('payment_date', Carbon::now()->month)
                    ->whereYear('payment_date', Carbon::now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('payment_date', Carbon::now()->year);
    }

    // Accessors
    public function getIsCompletedAttribute(): bool
    {
        return $this->status === 'completed';
    }

    public function getIsVerifiedAttribute(): bool
    {
        return !is_null($this->verified_at);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 2, ',', '.');
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'cash' => 'Tunai',
            'bank_transfer' => 'Transfer Bank',
            'credit_card' => 'Kartu Kredit',
            'debit_card' => 'Kartu Debit',
            'e_wallet' => 'E-Wallet',
            'other' => 'Lainnya',
            default => 'Tidak Diketahui'
        };
    }

    public function getPaymentTypeLabelAttribute(): string
    {
        return match($this->payment_type) {
            'tuition' => 'SPP',
            'registration' => 'Pendaftaran',
            'exam' => 'Ujian',
            'library' => 'Perpustakaan',
            'laboratory' => 'Laboratorium',
            'other' => 'Lainnya',
            default => 'Tidak Diketahui'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'completed' => 'Selesai',
            'failed' => 'Gagal',
            'cancelled' => 'Dibatalkan',
            default => 'Tidak Diketahui'
        };
    }

    // Business Logic Methods
    public function markAsCompleted(User $verifiedBy = null): bool
    {
        $this->status = 'completed';
        $this->verified_at = now();
        if ($verifiedBy) {
            $this->verified_by = $verifiedBy->id;
        }
        
        $saved = $this->save();
        
        if ($saved) {
            // Update student payment summary
            $this->student->updatePaymentSummary();
            
            // Update related debts
            $this->updateRelatedDebts();
        }
        
        return $saved;
    }

    public function markAsFailed(string $reason = null): bool
    {
        $this->status = 'failed';
        if ($reason) {
            $this->notes = $reason;
        }
        
        return $this->save();
    }

    public function cancel(string $reason = null): bool
    {
        $this->status = 'cancelled';
        if ($reason) {
            $this->notes = $reason;
        }
        
        return $this->save();
    }

    protected function updateRelatedDebts(): void
    {
        // Find and update debts for this student
        $debts = $this->student->debts()
            ->where('status', '!=', 'paid')
            ->orderBy('due_date', 'asc')
            ->get();

        $remainingAmount = $this->amount;

        foreach ($debts as $debt) {
            if ($remainingAmount <= 0) break;

            $outstandingAmount = $debt->outstanding_amount;
            $paymentAmount = min($remainingAmount, $outstandingAmount);

            $debt->paid_amount += $paymentAmount;
            $debt->outstanding_amount -= $paymentAmount;

            if ($debt->outstanding_amount <= 0) {
                $debt->status = 'paid';
            } else {
                $debt->status = 'partial';
            }

            $debt->save();
            $remainingAmount -= $paymentAmount;
        }
    }

    public function generateReceiptNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        $prefix = 'RCP' . $year . $month;
        
        // Get the last receipt number for this month
        $lastPayment = static::where('receipt_number', 'like', $prefix . '%')
            ->orderBy('receipt_number', 'desc')
            ->first();

        if ($lastPayment) {
            $lastNumber = (int) substr($lastPayment->receipt_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Boot method for auto-generating payment_code and receipt_number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->payment_code)) {
                $payment->payment_code = static::generatePaymentCode();
            }
            if (empty($payment->receipt_number)) {
                $payment->receipt_number = $payment->generateReceiptNumber();
            }
        });
    }

    public static function generatePaymentCode(): string
    {
        $year = date('Y');
        $prefix = 'PAY' . $year;
        
        // Get the last payment code for this year
        $lastPayment = static::where('payment_code', 'like', $prefix . '%')
            ->orderBy('payment_code', 'desc')
            ->first();

        if ($lastPayment) {
            $lastNumber = (int) substr($lastPayment->payment_code, -6);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }
}
