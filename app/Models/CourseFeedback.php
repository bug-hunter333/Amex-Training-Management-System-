<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFeedback extends Model
{
    use HasFactory;

    protected $table = 'course_feedbacks';

    protected $fillable = [
        'user_id',
        'course_id',
        'enrollment_id',
        'username',
        'email',
        'rating',
        'feedback',
        'categories',
        'is_anonymous',
        'status',
        'admin_response'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_anonymous' => 'boolean',
        'categories' => 'array'
    ];

    /**
     * Get the course that owns the feedback
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user who gave the feedback
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the enrollment this feedback belongs to
     */
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Scope for approved feedback
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for high ratings
     */
    public function scopeHighRating($query, $rating = 4)
    {
        return $query->where('rating', '>=', $rating);
    }

    /**
     * Scope for recent feedback
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Get display name (respects anonymity)
     */
    public function getDisplayNameAttribute()
    {
        return $this->is_anonymous ? 'Anonymous' : $this->username;
    }
}