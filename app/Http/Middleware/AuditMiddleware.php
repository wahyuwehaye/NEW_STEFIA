<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserActivityLog;
use Illuminate\Support\Facades\Log;

class AuditMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        
        // Process the request
        $response = $next($request);
        
        // Log the activity if user is authenticated
        if (auth()->check()) {
            $this->logActivity($request, $response, $startTime);
        }
        
        return $response;
    }
    
    /**
     * Log user activity
     */
    private function logActivity(Request $request, Response $response, float $startTime): void
    {
        try {
            $endTime = microtime(true);
            $duration = ($endTime - $startTime) * 1000; // Convert to milliseconds
            
            $user = auth()->user();
            $route = $request->route();
            $routeName = $route ? $route->getName() : null;
            $action = $this->getActionFromRoute($routeName, $request->method());
            
            // Only log certain actions to avoid noise
            if ($this->shouldLogAction($action, $request->method())) {
                UserActivityLog::create([
                    'user_id' => $user->id,
                    'action' => $action,
                    'resource_type' => $this->getResourceType($routeName),
                    'resource_id' => $this->getResourceId($request),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'status_code' => $response->getStatusCode(),
                    'duration' => round($duration, 2),
                    'metadata' => [
                        'route' => $routeName,
                        'parameters' => $route ? $route->parameters() : [],
                        'input' => $this->filterSensitiveData($request->except(['password', 'password_confirmation'])),
                    ],
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to log user activity', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'url' => $request->fullUrl(),
            ]);
        }
    }
    
    /**
     * Get action from route name
     */
    private function getActionFromRoute(?string $routeName, string $method): string
    {
        if (!$routeName) {
            return strtolower($method);
        }
        
        // Extract action from route name (e.g., 'students.store' -> 'create')
        $parts = explode('.', $routeName);
        $action = end($parts);
        
        // Map route actions to user-friendly actions
        $actionMap = [
            'index' => 'view',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
            'verify' => 'verify',
            'approve' => 'approve',
            'reject' => 'reject',
        ];
        
        return $actionMap[$action] ?? $action;
    }
    
    /**
     * Get resource type from route name
     */
    private function getResourceType(?string $routeName): ?string
    {
        if (!$routeName) {
            return null;
        }
        
        $parts = explode('.', $routeName);
        return $parts[0] ?? null;
    }
    
    /**
     * Get resource ID from request
     */
    private function getResourceId(Request $request): ?int
    {
        $route = $request->route();
        if (!$route) {
            return null;
        }
        
        $parameters = $route->parameters();
        
        // Common resource ID parameter names
        $idParams = ['id', 'student', 'payment', 'fee', 'scholarship', 'receivable', 'report', 'user'];
        
        foreach ($idParams as $param) {
            if (isset($parameters[$param])) {
                $value = $parameters[$param];
                return is_numeric($value) ? (int) $value : null;
            }
        }
        
        return null;
    }
    
    /**
     * Check if action should be logged
     */
    private function shouldLogAction(string $action, string $method): bool
    {
        // Don't log GET requests for view actions to reduce noise
        if ($method === 'GET' && $action === 'view') {
            return false;
        }
        
        // Log all other actions
        return true;
    }
    
    /**
     * Filter sensitive data from request input
     */
    private function filterSensitiveData(array $data): array
    {
        $sensitiveKeys = ['password', 'password_confirmation', 'token', 'api_key', 'secret'];
        
        foreach ($sensitiveKeys as $key) {
            if (isset($data[$key])) {
                $data[$key] = '[FILTERED]';
            }
        }
        
        return $data;
    }
}
