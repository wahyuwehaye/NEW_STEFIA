<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'last_login_at',
        'is_active',
        'is_approved',
        'employee_id',
        'department',
        'position',
        'avatar',
        'approved_by',
        'approved_at',
        'login_attempts',
        'locked_until',
        'password_changed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'is_approved' => 'boolean',
            'approved_at' => 'datetime',
            'locked_until' => 'datetime',
            'password_changed_at' => 'datetime',
            'login_attempts' => 'integer',
        ];
    }

    // Role constants
    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_FINANCE = 'finance';
    const ROLE_STAFF = 'staff';
    const ROLE_STUDENT = 'student';

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_LOCKED = 'locked';

    /**
     * Check if user has permission
     */
    public function hasPermission(string $permission): bool
    {
        $permissions = [
            self::ROLE_SUPER_ADMIN => ['*'], // All permissions
            self::ROLE_ADMIN => [
                'users.view', 'users.create', 'users.edit', 'users.delete',
                'students.view', 'students.create', 'students.edit', 'students.delete',
                'payments.view', 'payments.create', 'payments.edit', 'payments.delete',
                'receivables.view', 'receivables.create', 'receivables.edit', 'receivables.delete',
                'reports.view', 'reports.export',
                'sync.manage',
            ],
            self::ROLE_FINANCE => [
                'students.view',
                'payments.view', 'payments.create', 'payments.edit',
                'receivables.view', 'receivables.create', 'receivables.edit',
                'reports.view', 'reports.export',
            ],
            self::ROLE_STAFF => [
                'students.view',
                'payments.view',
                'receivables.view',
                'reports.view',
            ],
        ];

        $rolePermissions = $permissions[$this->role] ?? [];
        return in_array('*', $rolePermissions) || in_array($permission, $rolePermissions);
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    /**
     * Check if user is staff
     */
    public function isStaff(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'staff', 'finance']);
    }

    /**
     * Check if user is student
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Get user's full role name
     */
    public function getRoleNameAttribute(): string
    {
        return match($this->role) {
            'super_admin' => 'Super Administrator',
            'admin' => 'Administrator',
            'finance' => 'Finance Officer',
            'staff' => 'Staff Member',
            'student' => 'Student',
            'user' => 'Regular User',
            default => 'Unknown',
        };
    }

    /**
     * User activity logs
     */
    public function activityLogs()
    {
        return $this->hasMany(UserActivityLog::class);
    }

    /**
     * User approval requests
     */
    public function approvalRequests()
    {
        return $this->hasMany(UserApprovalRequest::class);
    }

    /**
     * Approved requests by this user
     */
    public function approvedRequests()
    {
        return $this->hasMany(UserApprovalRequest::class, 'approved_by');
    }

    /**
     * Check if user has Super Admin role
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user has Finance role
     */
    public function isFinance(): bool
    {
        return $this->role === 'finance';
    }

    /**
     * Check if user can manage other users
     */
    public function canManageUsers(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    /**
     * Status checking methods
     */
    public function isPending(): bool
    {
        return !$this->is_approved;
    }

    public function isApproved(): bool
    {
        // Super admins are always approved
        if ($this->role === 'super_admin') {
            return true;
        }
        
        return $this->is_approved;
    }

    public function isActive(): bool
    {
        return $this->is_active && $this->isApproved();
    }

    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function canLogin(): bool
    {
        return $this->isActive() && !$this->isLocked();
    }

    /**
     * Account management methods
     */
    public function approve($approvedBy = null)
    {
        $this->update([
            'is_approved' => true,
            'is_active' => true,
            'approved_by' => $approvedBy,
            'approved_at' => now(),
        ]);
        
        $this->logActivity('approved', 'user', $this->id, ['approved_by' => $approvedBy]);
    }

    public function suspend($reason = null)
    {
        $this->update(['is_active' => false]);
        $this->logActivity('suspended', 'user', $this->id, ['reason' => $reason]);
    }

    public function activate()
    {
        $this->update([
            'is_active' => true,
            'login_attempts' => 0,
            'locked_until' => null,
        ]);
        
        $this->logActivity('activated', 'user', $this->id);
    }

    public function incrementLoginAttempts()
    {
        $this->increment('login_attempts');
        
        if ($this->login_attempts >= 5) {
            $this->update(['locked_until' => now()->addMinutes(30)]);
            $this->logActivity('locked', 'user', $this->id, ['reason' => 'too_many_attempts']);
        }
    }

    public function resetLoginAttempts()
    {
        $this->update([
            'login_attempts' => 0,
            'locked_until' => null,
            'last_login_at' => now(),
        ]);
    }

    /**
     * Activity logging method
     */
    public function logActivity($action, $resource = null, $resourceId = null, $data = [])
    {
        return $this->activityLogs()->create([
            'action' => $action,
            'resource' => $resource,
            'resource_id' => $resourceId,
            'new_data' => $data,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Scope methods
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Additional relationships
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Accessors
     */
    public function getStatusAttribute()
    {
        if (!$this->is_approved) {
            return self::STATUS_PENDING;
        }
        
        if (!$this->is_active) {
            return self::STATUS_INACTIVE;
        }
        
        if ($this->isLocked()) {
            return self::STATUS_LOCKED;
        }
        
        return self::STATUS_ACTIVE;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            self::STATUS_PENDING => 'Menunggu Persetujuan',
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_INACTIVE => 'Tidak Aktif',
            self::STATUS_SUSPENDED => 'Ditangguhkan',
            self::STATUS_LOCKED => 'Dikunci',
        ];
        
        return $labels[$this->status] ?? 'Tidak Diketahui';
    }

    /**
     * Static methods
     */
    public static function getRoles()
    {
        return [
            self::ROLE_SUPER_ADMIN => 'Super Administrator',
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_FINANCE => 'Finance Officer',
            self::ROLE_STAFF => 'Staff Member',
            self::ROLE_STUDENT => 'Student',
        ];
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Menunggu Persetujuan',
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_INACTIVE => 'Tidak Aktif',
            self::STATUS_SUSPENDED => 'Ditangguhkan',
            self::STATUS_LOCKED => 'Dikunci',
        ];
    }

    /**
     * Boot method to add model events
     */
    protected static function boot()
    {
        parent::boot();

        // Log user creation
        static::created(function ($user) {
            $user->logActivity('created', 'user', $user->id);
        });

        // Log user updates
        static::updated(function ($user) {
            if ($user->isDirty('last_login_at')) {
                $user->logActivity('login', 'user', $user->id);
            }
        });
    }
}
