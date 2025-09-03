<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Trainer;
use Symfony\Component\HttpFoundation\Response;

class TrainerMiddleware
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
            return redirect()->route('trainer.login');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if user has a trainer profile
        $trainer = Trainer::where('user_id', $user->id)->first();

        if (!$trainer) {
            // User doesn't have a trainer profile
            Auth::logout();
            return redirect()->route('trainer.login')
                ->withErrors(['email' => 'You are not registered as a trainer.']);
        }

        // Check if trainer is active
        if (!$trainer->is_active) {
            Auth::logout();
            return redirect()->route('trainer.login')
                ->withErrors(['email' => 'Your trainer account is currently inactive. Please contact the administrator.']);
        }

        // Store trainer info in session for easy access throughout the request
        session(['trainer_id' => $trainer->id]);
        
        // Add trainer to request for easy access in controllers
        $request->attributes->add(['trainer' => $trainer]);

        return $next($request);
    }
}