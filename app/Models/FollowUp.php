<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class FollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'debt_id',
        'action_type',
        'title',
        'description',
        'action_date',
        'performed_by',
        'status',
        'result',
        'notes',
        'metadata',
    ];

    protected $casts = [
        'action_date' => 'date',
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

    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByActionType($query, $actionType)
    {
        return $query->where('action_type', $actionType);
    }

    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('action_date', [$startDate, $endDate]);
    }

    // Accessors
    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'pending';
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->status === 'completed';
    }

    public function getActionTypeNameAttribute(): string
    {
        $actionTypes = [
            'nde_fakultas' => 'NDE Fakultas',
            'dosen_wali' => 'Bekerjasama dengan Dosen Wali',
            'surat_orangtua' => 'Mengirimkan Surat kepada Orangtua',
            'telepon' => 'Melakukan Kontak via Telepon',
            'home_visit' => 'Home Visit',
            'other' => 'Lainnya',
        ];

        return $actionTypes[$this->action_type] ?? 'Unknown';
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    // Business Logic
    public function markAsCompleted(string $result = null, string $notes = null): void
    {
        $this->update([
            'status' => 'completed',
            'result' => $result,
            'notes' => $notes,
        ]);
    }

    public function markAsCancelled(string $reason = null): void
    {
        $this->update([
            'status' => 'cancelled',
            'notes' => $reason,
        ]);
    }

    public function reschedule(Carbon $newActionDate): void
    {
        $this->update([
            'action_date' => $newActionDate,
            'status' => 'pending',
        ]);
    }
}
