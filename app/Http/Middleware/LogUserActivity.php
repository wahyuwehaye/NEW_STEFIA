<?php

namespace App\Http\Middleware;

use App\Models\UserActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Log user activity if user is authenticated
        if (auth()->check()) {
            $this->logActivity($request, $response);
        }

        return $response;
    }

    /**
     * Log user activity
     */
    private function logActivity(Request $request, Response $response): void
    {
        try {
            $user = auth()->user();
            $action = $this->getActionFromRequest($request);
            
            if ($action && $this->shouldLogActivity($request)) {
                $resource = $this->getResourceFromRequest($request);
                $resourceId = $this->getResourceIdFromRequest($request);
                
                UserActivityLog::create([
                    'user_id' => $user->id,
                    'action' => $action,
                    'resource' => $resource,
                    'resource_id' => $resourceId,
                    'data' => $this->getDataFromRequest($request),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }
        } catch (\Exception $e) {
            // Log error but don't break the request
            logger()->error('Failed to log user activity: ' . $e->getMessage());
        }
    }
    
    /**
     * Check if activity should be logged
     */
    private function shouldLogActivity(Request $request): bool
    {
        $excludedRoutes = [
            'dashboard',
            'profile.show',
            'heartbeat',
            'health-check',
        ];
        
        $routeName = $request->route()?->getName();
        
        // Don't log certain routes
        if (in_array($routeName, $excludedRoutes)) {
            return false;
        }
        
        // Don't log asset requests
        if (str_contains($request->path(), 'assets/') || 
            str_contains($request->path(), 'images/') ||
            str_contains($request->path(), 'css/') ||
            str_contains($request->path(), 'js/')) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Get resource from request
     */
    private function getResourceFromRequest(Request $request): ?string
    {
        $uri = $request->path();
        $segments = explode('/', $uri);
        
        // Try to extract resource from URI
        if (count($segments) > 0) {
            $resource = $segments[0];
            
            // Map common resources
            return match($resource) {
                'users' => 'user',
                'students' => 'student',
                'payments' => 'payment',
                'receivables' => 'receivable',
                'reports' => 'report',
                'sync' => 'sync',
                default => $resource
            };
        }
        
        return null;
    }
    
    /**
     * Get resource ID from request
     */
    private function getResourceIdFromRequest(Request $request): ?int
    {
        $route = $request->route();
        
        if ($route) {
            $parameters = $route->parameters();
            
            // Common parameter names for IDs
            $idParams = ['id', 'user', 'student', 'payment', 'receivable', 'report'];
            
            foreach ($idParams as $param) {
                if (isset($parameters[$param]) && is_numeric($parameters[$param])) {
                    return (int) $parameters[$param];
                }
            }
        }
        
        return null;
    }
    
    /**
     * Get data from request
     */
    private function getDataFromRequest(Request $request): array
    {
        $data = [
            'method' => $request->method(),
            'url' => $request->url(),
            'route' => $request->route()?->getName(),
        ];
        
        // Add request data for POST/PUT/PATCH requests (excluding sensitive data)
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $input = $request->all();
            
            // Remove sensitive fields
            $sensitiveFields = ['password', 'password_confirmation', 'token', '_token', 'current_password'];
            foreach ($sensitiveFields as $field) {
                unset($input[$field]);
            }
            
            $data['input'] = $input;
        }
        
        return $data;
    }

    /**
     * Get action from request
     */
    private function getActionFromRequest(Request $request): ?string
    {
        $method = $request->method();
        $route = $request->route();
        
        if (!$route) {
            return null;
        }
        
        $routeName = $route->getName();
        $uri = $request->path();
        
        // Map common actions
        return match(true) {
            str_contains($routeName, 'create') || $method === 'POST' => 'create',
            str_contains($routeName, 'edit') || str_contains($routeName, 'update') || $method === 'PUT' || $method === 'PATCH' => 'update',
            str_contains($routeName, 'destroy') || $method === 'DELETE' => 'delete',
            str_contains($routeName, 'show') || str_contains($routeName, 'index') || $method === 'GET' => 'view',
            default => 'action'
        };
    }

    /**
     * Get description from request
     */
    private function getDescriptionFromRequest(Request $request): string
    {
        $route = $request->route();
        $routeName = $route ? $route->getName() : 'unknown';
        $uri = $request->path();
        
        return "Accessed {$routeName} ({$uri}) via {$request->method()}";
    }
}
