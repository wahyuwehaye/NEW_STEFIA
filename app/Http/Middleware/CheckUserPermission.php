<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Check if user has the required permission
        if (!$user->hasPermission($permission)) {
            // Log unauthorized access attempt
            $user->logActivity('unauthorized_access', 'permission', null, [
                'permission' => $permission,
                'url' => $request->url(),
                'method' => $request->method(),
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'Anda tidak memiliki izin untuk mengakses resource ini.',
                    'required_permission' => $permission,
                ], 403);
            }
            
            return redirect()->back()
                ->withErrors(['error' => 'Anda tidak memiliki izin untuk mengakses halaman ini.'])
                ->withInput();
        }
        
        return $next($request);
    }
}
