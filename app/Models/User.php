<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne; // <-- Add this

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type', // assuming you have this field
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if user is a trainer
     */
    public function isTrainer(): bool
    {
        return $this->user_type === 'trainer'
            && $this->trainer()->exists()
            && $this->trainer->is_active;
    }

    /**
     * Get the trainer profile associated with the user
     */
    public function trainer()
    {
        return $this->hasOne(Trainer::class);
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->user_type === $role;
    }

    /**
     * Get the admin profile associated with the user
     */
    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * Check if user is an active admin
     */
    public function isAdmin(): bool
    {
        return $this->user_type === 'admin'
            && $this->admin()->where('is_active', true)->exists();
    }

    /**
     * Check if user is student/trainee
     */
    public function isStudent(): bool
    {
        return in_array($this->user_type, ['student', 'trainee']);
    }
}
