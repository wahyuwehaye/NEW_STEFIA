<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillingAction extends Model
{
    protected $fillable = [
        'debt_id',
        'action_type',
        'description',
        'action_date',
        'performed_by',
    ];

    protected $casts = [
        'action_date' => 'date',
    ];

    /**
     * Get the debt that owns this billing action.
     */
    public function debt(): BelongsTo
    {
        return $this->belongsTo(Debt::class);
    }

    /**
     * Get the user who performed this action.
     */
    public function performer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    /**
     * Scope to filter by action type.
     */
    public function scopeByActionType($query, $actionType)
    {
        return $query->where('action_type', $actionType);
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('action_date', [$startDate, $endDate]);
    }

    /**
     * Get formatted action type.
     */
    public function getFormattedActionTypeAttribute()
    {
        return match($this->action_type) {
            'nde_fakultas' => 'NDE Fakultas',
            'dosen_wali' => 'Dosen Wali',
            'surat_orangtua' => 'Surat Orang Tua',
            'telepon' => 'Telepon',
            'home_visit' => 'Kunjungan Rumah',
            default => $this->action_type,
        };
    }
}
