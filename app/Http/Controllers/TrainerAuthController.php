<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Trainer;
use Illuminate\Validation\ValidationException;

class TrainerAuthController extends Controller
{
    /**
     * Show the trainer login form
     */
    public function showLoginForm()
    {
        return view('auth.trainer.login');
    }

    /**
     * Handle trainer login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Find trainer by email
        $trainer = Trainer::where('trainer_mail', $request->email)->first();

        if (!$trainer) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        // Check if trainer is active
        if (!$trainer->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Your trainer account is currently inactive. Please contact the administrator.'],
            ]);
        }

        // Get the associated user
        $user = $trainer->user;

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['No user account found for this trainer.'],
            ]);
        }

        // Attempt to login with the user account
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        // Login the user
        Auth::login($user, $request->boolean('remember'));

        // Store trainer info in session for easy access
        session(['trainer_id' => $trainer->id]);

        $request->session()->regenerate();

        return redirect()->intended(route('trainer.dashboard'));
    }

    /**
     * Handle trainer logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('trainer.login');
    }
}