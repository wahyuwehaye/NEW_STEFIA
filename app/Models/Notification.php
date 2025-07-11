<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'message',
        'data',
        'user_id',
        'status',
        'read_at',
        'sent_at',
        'priority',
        'category',
        'error_message',
        'retry_count',
        'scheduled_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'sent_at' => 'datetime',
        'scheduled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

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

    public function markAsRead()
    {
        $this->update([
            'read_at' => now(),
            'status' => 'read'
        ]);
    }

    public function markAsSent()
    {
        $this->update([
            'sent_at' => now(),
            'status' => 'sent'
        ]);
    }

    public function markAsFailed($errorMessage = null)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
            'retry_count' => $this->retry_count + 1
        ]);
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'urgent' => 'danger',
            'high' => 'warning',
            'normal' => 'info',
            'low' => 'secondary',
            default => 'info'
        };
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'email' => 'ni-emails',
            'whatsapp' => 'ni-whatsapp',
            'system' => 'ni-bell',
            default => 'ni-bell'
        };
    }

    public function getCategoryIconAttribute()
    {
        return match($this->category) {
            'payment_reminder' => 'ni-money',
            'overdue_notice' => 'ni-alert-circle',
            'system_alert' => 'ni-info',
            'collection_action' => 'ni-user-check',
            default => 'ni-bell'
        };
    }
}
