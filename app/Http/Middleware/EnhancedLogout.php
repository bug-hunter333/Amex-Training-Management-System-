<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnhancedLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log logout attempts for security monitoring
        if ($request->is('*/logout') || $request->is('logout')) {
            $user = Auth::user();
            
            if ($user) {
                Log::info('User logout attempt', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'session_id' => $request->session()->getId(),
                    'timestamp' => now()
                ]);
            }
        }

        $response = $next($request);

        // Add security headers for logout responses
        if ($request->is('*/logout') || $request->is('logout')) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            $response->headers->set('Clear-Site-Data', '"cache", "cookies", "storage"');
        }

        return $response;
    }
}