<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receivable extends Model
{
    use HasFactory;

    protected $fillable = [
        'receivable_code',
        'student_id',
        'fee_id',
        'amount',
        'due_date',
        'status',
        'description',
        'notes',
        'paid_amount',
        'outstanding_amount',
        'priority',
        'penalty_amount',
        'penalty_date',
        'metadata',
        'created_by',
        'last_reminder_sent',
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'outstanding_amount' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function fee(): BelongsTo
    {
        return $this->belongsTo(Fee::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())->where('status', '!=', 'paid');
    }

    /**
     * Generate a unique receivable code.
     */
    public static function generateReceivableCode()
    {
        $lastReceivable = self::orderBy('id', 'desc')->first();
        $nextId = $lastReceivable ? $lastReceivable->id + 1 : 1;
        return 'RCV-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->receivable_code)) {
                $model->receivable_code = self::generateReceivableCode();
            }
            if (empty($model->created_by)) {
                $model->created_by = auth()->id() ?? 1;
            }
            if (empty($model->outstanding_amount)) {
                $model->outstanding_amount = $model->amount;
            }
        });
    }

    // Accessors for dashboard view

    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case 'paid':
                return 'success';
            case 'overdue':
                return 'danger';
            case 'pending':
                return 'warning';
            default:
                return 'secondary';
        }
    }

    public function getFormattedStatusAttribute()
    {
        switch ($this->status) {
            case 'paid':
                return 'Lunas';
            case 'overdue':
                return 'Terlambat';
            case 'pending':
                return 'Pending';
            default:
                return ucfirst($this->status);
        }
    }

    public function getOutstandingAmountAttribute()
    {
        return $this->amount - ($this->paid_amount ?? 0);
    }
}
