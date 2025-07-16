<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentParent extends Model
{
    protected $table = 'student_parents';
    
    protected $fillable = [
        'student_id',
        'parent_id',
        'relationship',
    ];

    /**
     * Get the student that owns this relationship.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the parent that owns this relationship.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }

    /**
     * Scope to filter by relationship type.
     */
    public function scopeByRelationship($query, $relationship)
    {
        return $query->where('relationship', $relationship);
    }

    /**
     * Get formatted relationship.
     */
    public function getFormattedRelationshipAttribute()
    {
        return match($this->relationship) {
            'ayah' => 'Ayah',
            'ibu' => 'Ibu',
            'wali' => 'Wali',
            default => $this->relationship,
        };
    }
}
