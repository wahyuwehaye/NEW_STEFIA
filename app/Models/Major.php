<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    protected $fillable = [
        'name',
        'code',
        'faculty_id',
    ];

    /**
     * Get the faculty that owns this major.
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get the students for this major.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the department through faculty.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'faculty_id', 'id');
    }

    /**
     * Scope to filter by faculty.
     */
    public function scopeByFaculty($query, $facultyId)
    {
        return $query->where('faculty_id', $facultyId);
    }
}
