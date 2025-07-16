<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParentModel extends Model
{
    protected $table = 'parents';
    
    protected $fillable = [
        'name',
        'gender',
        'occupation',
        'phone',
        'address',
    ];

    /**
     * Get the students that belong to this parent.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_parents', 'parent_id', 'student_id')
                    ->withPivot('relationship')
                    ->withTimestamps();
    }

    /**
     * Get the student-parent relationships.
     */
    public function studentParents(): HasMany
    {
        return $this->hasMany(StudentParent::class, 'parent_id');
    }

    /**
     * Scope to filter by gender.
     */
    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    /**
     * Scope to search by name.
     */
    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    /**
     * Get formatted gender.
     */
    public function getFormattedGenderAttribute()
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
