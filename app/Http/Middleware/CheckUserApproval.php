<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // If not authenticated and trying to access protected routes, redirect to login
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Session expired. Please login again.'], 401);
            }
            
            return redirect()->route('login')
                ->withErrors(['email' => 'Session Anda telah habis. Silakan login kembali.']);
        }
        
        $user = Auth::user();
        
        // Additional check to ensure user object is valid
        if (!$user) {
            Auth::logout();
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Session expired. Please login again.'], 401);
            }
            
            return redirect()->route('login')
                ->withErrors(['email' => 'Session Anda telah habis. Silakan login kembali.']);
        }
        
        // Check if user is approved
        if (!$user->isApproved()) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda belum disetujui oleh Super Admin. Silakan tunggu persetujuan.']);
        }
        
        // Check if user is active
        if (!$user->isActive()) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi administrator.']);
        }
        
        // Check if user is locked
        if ($user->isLocked()) {
            Auth::logout();
            $lockedUntil = $user->locked_until->format('H:i:s d/m/Y');
            return redirect()->route('login')
                ->withErrors(['email' => "Akun Anda dikunci hingga {$lockedUntil} karena terlalu banyak percobaan login yang gagal."]);
        }
        
        return $next($request);
    }
}
