<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    // Relationships
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    // Scopes
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->code . ' - ' . $this->name;
    }
}
