<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;
use App\Models\Trainer;
use Illuminate\Support\Facades\Hash;

class CustomUserProvider extends EloquentUserProvider implements UserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) || !isset($credentials['email'])) {
            return null;
        }

        // First try to find in users table
        $user = User::where('email', $credentials['email'])->first();
        
        if ($user) {
            return $user;
        }

        // If not found in users, try trainers table
        $trainer = Trainer::where('email', $credentials['email'])->where('is_active', true)->first();
        
        if ($trainer) {
            // Create a temporary User object for authentication
            // This allows trainers to use the same login system
            $tempUser = new User();
            $tempUser->id = 'trainer_' . $trainer->id;
            $tempUser->name = $trainer->user->name ?? 'Trainer';
            $tempUser->email = $trainer->email;
            $tempUser->password = $trainer->password;
            $tempUser->is_trainer = true;
            $tempUser->role = 'trainer';
            $tempUser->trainer_id = $trainer->id; // Store trainer ID for later use
            
            return $tempUser;
        }

        return null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if (!isset($credentials['password'])) {
            return false;
        }

        return Hash::check($credentials['password'], $user->getAuthPassword());
    }
}