<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class SyncLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'sync_id',
        'sync_type',
        'status',
        'progress',
        'total_records',
        'processed_records',
        'failed_records',
        'started_at',
        'completed_at',
        'filters',
        'errors',
        'notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'filters' => 'array',
        'errors' => 'array',
    ];

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeBySyncType($query, $syncType)
    {
        return $query->where('sync_type', $syncType);
    }

    // Accessors
    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'pending';
    }

    public function getIsProcessingAttribute(): bool
    {
        return $this->status === 'processing';
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->status === 'completed';
    }

    public function getIsFailedAttribute(): bool
    {
        return $this->status === 'failed';
    }

    public function getProgressPercentageAttribute(): float
    {
        if ($this->total_records == 0) {
            return 0;
        }

        return round(($this->processed_records / $this->total_records) * 100, 2);
    }

    public function getDurationAttribute(): ?string
    {
        if (!$this->started_at) {
            return null;
        }

        $endTime = $this->completed_at ?? now();
        $duration = $this->started_at->diffInSeconds($endTime);

        return $this->formatDuration($duration);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'failed' => 'danger',
            default => 'secondary',
        };
    }

    // Business Logic
    public function markAsProcessing(): void
    {
        $this->update([
            'status' => 'processing',
            'started_at' => now(),
        ]);
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress' => 100,
        ]);
    }

    public function markAsFailed(array $errors = []): void
    {
        $this->update([
            'status' => 'failed',
            'completed_at' => now(),
            'errors' => $errors,
        ]);
    }

    public function updateProgress(int $processedRecords, int $totalRecords = null): void
    {
        $data = [
            'processed_records' => $processedRecords,
        ];

        if ($totalRecords !== null) {
            $data['total_records'] = $totalRecords;
        }

        if ($this->total_records > 0) {
            $data['progress'] = round(($processedRecords / $this->total_records) * 100);
        }

        $this->update($data);
    }

    public function incrementFailedRecords(int $count = 1): void
    {
        $this->increment('failed_records', $count);
    }

    public function addError(string $error, array $context = []): void
    {
        $errors = $this->errors ?? [];
        $errors[] = [
            'message' => $error,
            'context' => $context,
            'timestamp' => now()->toISOString(),
        ];

        $this->update(['errors' => $errors]);
    }

    // Helper Methods
    private function formatDuration(int $seconds): string
    {
        if ($seconds < 60) {
            return $seconds . 's';
        } elseif ($seconds < 3600) {
            return round($seconds / 60, 1) . 'm';
        } else {
            return round($seconds / 3600, 1) . 'h';
        }
    }

    // Static Methods
    public static function generateSyncId(): string
    {
        return 'SYNC_' . now()->format('Y_m_d_His') . '_' . Str::random(6);
    }

    public static function createNew(string $syncType, array $filters = []): self
    {
        return static::create([
            'sync_id' => static::generateSyncId(),
            'sync_type' => $syncType,
            'status' => 'pending',
            'filters' => $filters,
        ]);
    }
}
