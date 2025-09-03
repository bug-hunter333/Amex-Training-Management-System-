<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trainer extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'trainer_name',
    'trainer_mail', 
    'employee_id',
    'department',
    'specialization',
    'bio',
    'experience_years',
    'is_active',
    'phone',
    'certifications',
    'address',
    'qualification',
    'profile_image',
    'linkedin_url',
    'status',
];

    protected $casts = [
        'certifications' => 'array',
        'is_active' => 'boolean',
        'experience_years' => 'integer',
    ];

    /**
     * Get the user that owns the trainer profile
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all courses created by this trainer
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get active courses only
     */
    public function activeCourses()
    {
        return $this->hasMany(Course::class)->where('is_active', true);
    }

    /**
     * Get all enrollments through courses
     */
    public function enrollments()
    {
        return $this->hasManyThrough(Enrollment::class, Course::class);
    }

    /**
     * Get all sessions through courses
     */
    public function sessions()
    {
        return $this->hasManyThrough(Session::class, Course::class);
    }

    /**
     * Get all feedback through courses
     */
    public function feedbacks()
    {
        return $this->hasManyThrough(CourseFeedback::class, Course::class);
    }

    /**
     * Scope for active trainers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get trainer's full name
     */
    public function getNameAttribute()
    {
        return $this->user->name;
    }

    /**
     * Get trainer's email
     */
    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    /**
     * Get formatted experience
     */
    public function getFormattedExperienceAttribute()
    {
        return $this->experience_years . ' year' . ($this->experience_years > 1 ? 's' : '') . ' experience';
    }

    /**
     * Get trainer statistics
     */
    public function getStatsAttribute()
    {
        return [
            'total_courses' => $this->courses()->count(),
            'active_courses' => $this->activeCourses()->count(),
            'total_trainees' => $this->enrollments()->where('status', 'approved')->count(),
            'total_sessions' => $this->sessions()->count(),
            'average_rating' => $this->feedbacks()->avg('rating') ?: 0,
            'total_feedback' => $this->feedbacks()->count(),
        ];
    }
}