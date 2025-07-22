<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserActivityLog;
use App\Models\UserApprovalRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserManagementService
{
    /**
     * Create a new user
     */
    public function createUser(array $data): User
    {
        DB::beginTransaction();
        
        try {
            $isSuperAdmin = \Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user() && \Illuminate\Support\Facades\Auth::user()->role === 'super_admin');
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'] ?? 'user',
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
                'is_active' => $isSuperAdmin ? true : ($data['is_active'] ?? false),
                'is_approved' => $isSuperAdmin ? true : false,
                'approved_by' => $isSuperAdmin ? (\Illuminate\Support\Facades\Auth::user() ? \Illuminate\Support\Facades\Auth::user()->id : null) : null,
                'approved_at' => $isSuperAdmin ? now() : null,
            ]);

            // Create approval request for new user (if not auto-approved)
            if (!$user->is_approved) {
                $this->createApprovalRequest($user, 'registration', [
                    'user_data' => $data,
                    'requested_role' => $data['role'] ?? 'user',
                ]);
            }

            // Log activity
            if (\Illuminate\Support\Facades\Auth::check()) {
                $this->logActivity(\Illuminate\Support\Facades\Auth::user(), 'create', 'User', $user->id, null, $user->toArray(), 'Created new user: ' . $user->name);
            }

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update user
     */
    public function updateUser(User $user, array $data): User
    {
        DB::beginTransaction();
        
        try {
            $oldData = $user->toArray();
            
            // Check if role is being changed
            if (isset($data['role']) && $data['role'] !== $user->role) {
                // Create approval request for role change
                $this->createApprovalRequest($user, 'role_change', [
                    'old_role' => $user->role,
                    'new_role' => $data['role'],
                ]);
                
                // Don't update role immediately, needs approval
                unset($data['role']);
            }

            $user->update($data);

            // Log activity
            if (\Illuminate\Support\Facades\Auth::check()) {
                $this->logActivity(\Illuminate\Support\Facades\Auth::user(), 'update', 'User', $user->id, $oldData, $user->toArray(), 'Updated user: ' . $user->name);
            }

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user): bool
    {
        DB::beginTransaction();
        
        try {
            $userData = $user->toArray();
            $userName = $user->name;
            
            $user->delete();

            // Log activity
            if (\Illuminate\Support\Facades\Auth::check()) {
                $this->logActivity(\Illuminate\Support\Facades\Auth::user(), 'delete', 'User', $user->id, $userData, null, 'Deleted user: ' . $userName);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Approve user
     */
    public function approveUser(User $user, string $notes = null): bool
    {
        DB::beginTransaction();
        
        try {
            $user->update(['is_active' => true, 'is_approved' => true, 'approved_by' => (\Illuminate\Support\Facades\Auth::user() ? \Illuminate\Support\Facades\Auth::user()->id : null), 'approved_at' => now()]);

            // Find and update approval request
            $approvalRequest = UserApprovalRequest::where('user_id', $user->id)
                ->where('status', 'pending')
                ->first();

            if ($approvalRequest) {
                $approvalRequest->update([
                    'status' => 'approved',
                    'approved_by' => (\Illuminate\Support\Facades\Auth::user() ? \Illuminate\Support\Facades\Auth::user()->id : null),
                    'approval_notes' => $notes,
                    'approved_at' => now(),
                ]);
            }

            // Log activity
            $this->logActivity(\Illuminate\Support\Facades\Auth::user(), 'approve', 'User', $user->id, null, null, 'Approved user: ' . $user->name);

            // Send notification to user
            if (class_exists('App\\Services\\NotificationService')) {
                try {
                    app(\App\Services\NotificationService::class)->createNotification([
                        'type' => 'system',
                        'title' => 'Akun Anda telah disetujui',
                        'message' => 'Akun Anda telah diapprove dan sekarang dapat login ke sistem.',
                        'user_id' => $user->id,
                        'category' => 'user_approval',
                        'priority' => 'high',
                        'status' => 'pending',
                    ]);
                } catch (\Exception $e) {}
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reject user
     */
    public function rejectUser(User $user, string $notes = null): bool
    {
        DB::beginTransaction();
        
        try {
            // Find and update approval request
            $approvalRequest = UserApprovalRequest::where('user_id', $user->id)
                ->where('status', 'pending')
                ->first();

            if ($approvalRequest) {
                $approvalRequest->update([
                    'status' => 'rejected',
                    'approved_by' => (\Illuminate\Support\Facades\Auth::user() ? \Illuminate\Support\Facades\Auth::user()->id : null),
                    'approval_notes' => $notes,
                    'approved_at' => now(),
                ]);
            }

            // Log activity
            $this->logActivity(\Illuminate\Support\Facades\Auth::user(), 'reject', 'User', $user->id, null, null, 'Rejected user: ' . $user->name);

            // Send notification to user
            if (class_exists('App\\Services\\NotificationService')) {
                try {
                    app(\App\Services\NotificationService::class)->createNotification([
                        'type' => 'system',
                        'title' => 'Akun Anda ditolak',
                        'message' => 'Akun Anda tidak disetujui. Silakan hubungi admin untuk informasi lebih lanjut.',
                        'user_id' => $user->id,
                        'category' => 'user_approval',
                        'priority' => 'high',
                        'status' => 'pending',
                    ]);
                } catch (\Exception $e) {}
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get pending approval requests
     */
    public function getPendingApprovals()
    {
        return UserApprovalRequest::with(['user', 'approver'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get user activity logs
     */
    public function getUserActivityLogs(User $user = null, int $limit = 100)
    {
        $query = UserActivityLog::with('user');
        
        if ($user) {
            $query->where('user_id', $user->id);
        }
        
        return $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Create approval request
     */
    private function createApprovalRequest(User $user, string $type, array $data, string $reason = null): UserApprovalRequest
    {
        return UserApprovalRequest::create([
            'user_id' => $user->id,
            'request_type' => $type,
            'request_data' => $data,
            'reason' => $reason,
            'status' => 'pending',
        ]);
    }

    /**
     * Log user activity
     */
    private function logActivity(User $user, string $action, string $resource = null, int $resourceId = null, array $oldData = null, array $newData = null, string $description = null): void
    {
        UserActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'resource' => $resource,
            'resource_id' => $resourceId,
            'old_data' => $oldData,
            'new_data' => $newData,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'description' => $description,
        ]);
    }

    /**
     * Get user roles
     */
    public function getUserRoles(): array
    {
        return [
            'super_admin' => 'Super Administrator',
            'admin' => 'Administrator',
            'finance' => 'Finance Officer',
            'staff' => 'Staff Member',
            'student' => 'Student',
            'user' => 'Regular User',
        ];
    }

    /**
     * Get users with role filtering
     */
    public function getUsersWithFilters(array $filters = [])
    {
        $query = User::query();

        if (isset($filters['role']) && $filters['role'] !== 'all') {
            $query->where('role', $filters['role']);
        }

        if (isset($filters['status']) && $filters['status'] !== 'all') {
            $query->where('is_active', $filters['status'] === 'active');
        }

        if (isset($filters['search']) && !empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }
}
