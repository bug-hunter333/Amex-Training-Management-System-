<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Option 1: Check user_type field first (if you have it)
        if ($user->user_type === 'admin') {
            return $next($request);
        }

        // Option 2: Check admin table
        $admin = Admin::where('user_id', $user->id)->where('is_active', true)->first();
        
        if ($admin) {
            return $next($request);
        }

        // Option 3: Check if user has admin email (fallback for development)
        $adminEmails = ['admin@example.com', 'miyulasbandara@gmail.com']; // Add your admin emails
        if (in_array($user->email, $adminEmails)) {
            return $next($request);
        }

        // If none of the above conditions are met
        abort(403, 'Unauthorized. Admin access required.');
    }
}