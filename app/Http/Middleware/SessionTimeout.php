<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if session has expired
        if (!$request->session()->has('last_activity')) {
            // First time visiting, set last activity
            $request->session()->put('last_activity', time());
        } else {
            $lastActivity = $request->session()->get('last_activity');
            $sessionLifetime = config('session.lifetime') * 60; // Convert minutes to seconds
            
            // Check if session has timed out
            if (time() - $lastActivity > $sessionLifetime) {
                // Session has expired
                Auth::logout();
                $request->session()->flush();
                $request->session()->regenerate();
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Session expired. Please login again.',
                        'redirect' => route('login')
                    ], 401);
                }
                
                return redirect()->route('login')
                    ->withErrors(['email' => 'Session Anda telah habis. Silakan login kembali.']);
            }
        }
        
        // Update last activity time
        $request->session()->put('last_activity', time());
        
        return $next($request);
    }
}
