<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Check if user is active
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Your account has been deactivated. Please contact administrator.');
        }

        // Get user permissions based on role
        $userPermissions = $this->getUserPermissions($user->role);
        
        // Check if user has any of the required permissions
        $hasPermission = false;
        foreach ($permissions as $permission) {
            if (in_array($permission, $userPermissions)) {
                $hasPermission = true;
                break;
            }
        }
        
        if (!$hasPermission) {
            abort(403, 'Unauthorized. You do not have permission to perform this action.');
        }

        return $next($request);
    }
    
    /**
     * Get user permissions based on role
     */
    private function getUserPermissions(string $role): array
    {
        $permissions = [
            'super_admin' => [
                'users.view', 'users.create', 'users.update', 'users.delete',
                'students.view', 'students.create', 'students.update', 'students.delete',
                'payments.view', 'payments.create', 'payments.update', 'payments.delete', 'payments.verify',
                'fees.view', 'fees.create', 'fees.update', 'fees.delete',
                'scholarships.view', 'scholarships.create', 'scholarships.update', 'scholarships.delete',
                'receivables.view', 'receivables.create', 'receivables.update', 'receivables.delete',
                'reports.view', 'reports.create', 'reports.generate',
                'settings.view', 'settings.update',
                'audit.view',
            ],
            'admin' => [
                'students.view', 'students.create', 'students.update', 'students.delete',
                'payments.view', 'payments.create', 'payments.update', 'payments.verify',
                'fees.view', 'fees.create', 'fees.update',
                'scholarships.view', 'scholarships.create', 'scholarships.update',
                'receivables.view', 'receivables.create', 'receivables.update',
                'reports.view', 'reports.create', 'reports.generate',
                'settings.view',
            ],
            'operator' => [
                'students.view', 'students.create', 'students.update',
                'payments.view', 'payments.create', 'payments.update',
                'fees.view',
                'scholarships.view',
                'receivables.view', 'receivables.create', 'receivables.update',
                'reports.view',
            ],
            'viewer' => [
                'students.view',
                'payments.view',
                'fees.view',
                'scholarships.view',
                'receivables.view',
                'reports.view',
            ],
            'finance' => [
                'students.view', 'students.create', 'students.update',
                'payments.view', 'payments.create', 'payments.update', 'payments.verify',
                'fees.view', 'fees.create', 'fees.update',
                'receivables.view', 'receivables.create', 'receivables.update',
                'reports.view', 'reports.create', 'reports.generate',
            ],
            'staff' => [
                'students.view', 'students.create', 'students.update',
                'payments.view', 'payments.create', 'payments.update',
                'receivables.view', 'receivables.create', 'receivables.update',
                'reports.view',
            ],
            'user' => [
                'students.view',
                'payments.view',
                'fees.view',
                'receivables.view',
                'reports.view',
            ],
            'student' => [
                'students.view',
                'payments.view',
                'fees.view',
                'receivables.view',
            ],
        ];
        
        return $permissions[$role] ?? [];
    }
}
