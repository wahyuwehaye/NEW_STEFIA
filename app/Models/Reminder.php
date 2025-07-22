<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'debt_id',
        'type',
        'recipient',
        'subject',
        'message',
        'scheduled_at',
        'sent_at',
        'status',
        'error_message',
        'metadata',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'metadata' => 'array',
    ];

    // Relationships
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function debt(): BelongsTo
    {
        return $this->belongsTo(Debt::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeScheduledBefore($query, $datetime)
    {
        return $query->where('scheduled_at', '<=', $datetime);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'pending';
    }

    public function getIsSentAttribute(): bool
    {
        return $this->status === 'sent';
    }

    public function getIsFailedAttribute(): bool
    {
        return $this->status === 'failed';
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->status === 'pending' && $this->scheduled_at < now();
    }

    // Business Logic
    public function markAsSent(): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'error_message' => null,
        ]);
    }

    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
        ]);
    }

    public function reschedule(Carbon $newScheduledAt): void
    {
        $this->update([
            'scheduled_at' => $newScheduledAt,
            'status' => 'pending',
            'error_message' => null,
        ]);
    }
}
