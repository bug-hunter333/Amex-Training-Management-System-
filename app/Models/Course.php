<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'category',
        'course_type',
        'difficulty_level',
        'duration_weeks',
        'duration_hours',
        'price',
        'prerequisites',
        'learning_objectives',
        'course_outline',
        'certificate_type',
        'max_participants',
        'min_participants',
        'auto_enrollment',
        'enrollment_start_date',
        'enrollment_end_date',
        'start_date',
        'end_date',
        'schedule',
        'timezone',
        'venue_type',
        'venue_name',
        'venue_address',
        'online_platform',
        'lecturer_name',
        'lecturer_email',
        'lecturer_bio',
        'trainer_id',
        'materials',
        'resources',
        'status',
        'is_active',
        'is_featured',
        'is_mandatory',
        'meta_title',
        'meta_description',
        'thumbnail',
        'tags',
        'target_departments',
        'target_roles',
        'target_levels',
        'requires_approval',
        'average_rating',
        'total_reviews',
        'view_count',
        'enrollment_count',
        'completion_count'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_mandatory' => 'boolean',
        'requires_approval' => 'boolean',
        'auto_enrollment' => 'boolean',
        'prerequisites' => 'array',
        'learning_objectives' => 'array',
        'schedule' => 'array',
        'materials' => 'array',
        'resources' => 'array',
        'tags' => 'array',
        'target_departments' => 'array',
        'target_roles' => 'array',
        'target_levels' => 'array',
        'enrollment_start_date' => 'datetime',
        'enrollment_end_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'average_rating' => 'decimal:2',
        'total_reviews' => 'integer',
        'view_count' => 'integer',
        'enrollment_count' => 'integer',
        'completion_count' => 'integer'
    ];

    /**
     * Get the trainer that owns the course
     */
    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    /**
     * Get all enrollments for this course
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get only approved enrollments
     */
    public function approvedEnrollments()
    {
        return $this->hasMany(Enrollment::class)->where('status', 'approved');
    }

    /**
     * Get only pending enrollments
     */
    public function pendingEnrollments()
    {
        return $this->hasMany(Enrollment::class)->where('status', 'pending');
    }

    /**
     * Get all sessions for this course
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Get upcoming sessions for this course
     */
    public function upcomingSessions()
    {
        return $this->hasMany(Session::class)->where('session_date', '>=', now())->where('status', '!=', 'cancelled');
    }

    /**
     * Get past sessions for this course
     */
    public function pastSessions()
    {
        return $this->hasMany(Session::class)->where('session_date', '<', now());
    }

    /**
     * Get all feedback for this course
     */
    public function feedbacks(): HasMany
    {
        return $this->hasMany(CourseFeedback::class);
    }

    /**
     * Get approved feedback for this course
     */
    public function approvedFeedbacks()
    {
        return $this->hasMany(CourseFeedback::class)->where('status', 'approved');
    }

    /**
     * Check if course is full
     */
    public function isFull()
    {
        return $this->approvedEnrollments()->count() >= $this->max_participants;
    }

    /**
     * Get available spots
     */
    public function getAvailableSpotsAttribute()
    {
        return $this->max_participants - $this->approvedEnrollments()->count();
    }

    /**
     * Get enrollment statistics
     */
    public function getEnrollmentStatsAttribute()
    {
        $total = $this->enrollments()->count();
        $approved = $this->approvedEnrollments()->count();
        $pending = $this->pendingEnrollments()->count();
        $rejected = $this->enrollments()->where('status', 'rejected')->count();

        return [
            'total' => $total,
            'approved' => $approved,
            'pending' => $pending,
            'rejected' => $rejected,
            'available_spots' => $this->available_spots,
            'occupancy_rate' => $this->max_participants > 0 ? round(($approved / $this->max_participants) * 100, 2) : 0
        ];
    }

    /**
     * Scope for active courses
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for courses with available spots
     */
    public function scopeAvailable($query)
    {
        return $query->whereRaw('(SELECT COUNT(*) FROM enrollments WHERE course_id = courses.id AND status = "approved") < max_participants');
    }

    /**
     * Check if user is already enrolled
     */
    public function isUserEnrolled($email)
    {
        return $this->enrollments()
            ->where('trainee_email', $email)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format((float) ($this->price ?? 0), 0);
    }

    /**
     * Get course duration in a readable format
     */
    public function getFormattedDurationAttribute()
    {
        $weeks = $this->duration_weeks;
        return $weeks . ' week' . ($weeks > 1 ? 's' : '');
    }

    /**
     * Check if course is currently running
     */
    public function isOngoing()
    {
        return now()->between($this->start_date, $this->end_date);
    }

    /**
     * Check if course is upcoming
     */
    public function isUpcoming()
    {
        return now()->lt($this->start_date);
    }

    /**
     * Check if course is completed
     */
    public function isCompleted()
    {
        return now()->gt($this->end_date);
    }

    /**
     * Get course status
     */
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'draft';
        }

        if ($this->isOngoing()) {
            return 'ongoing';
        }

        if ($this->isUpcoming()) {
            return 'upcoming';
        }

        if ($this->isCompleted()) {
            return 'completed';
        }

        return 'active';
    }

    /**
     * Update course statistics
     */
    public function updateStats()
    {
        $this->update([
            'enrollment_count' => $this->approvedEnrollments()->count(),
            'average_rating' => $this->feedbacks()->avg('rating') ?? 0,
            'total_reviews' => $this->feedbacks()->count(),
        ]);
    }
}