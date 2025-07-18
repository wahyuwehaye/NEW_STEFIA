<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receivable extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'fee_id',
        'amount',
        'due_date',
        'status',
        'description',
        'notes',
        'paid_amount',
        'outstanding_amount',
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

    // Accessors for dashboard view
    public function getReceivableCodeAttribute()
    {
        return 'RCV-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

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
