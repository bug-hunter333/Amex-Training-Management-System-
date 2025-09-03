<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Session extends Model
{
    use HasFactory;

    // Fix the table name mismatch
    protected $table = 'course_sessions';

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'topic',
        'session_date',
        'start_time',
        'end_time',
        'meeting_link',
        'recording_link',
        'session_type',
        'status',
        'notes',
        'materials'
    ];

    protected $casts = [
        'session_date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'materials' => 'array'
    ];

    /**
     * Get the course that owns the session
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Check if session is today
     */
    public function isToday()
    {
        return $this->session_date->isToday();
    }

    /**
     * Check if session is in the past
     */
    public function isPast()
    {
        return $this->session_date->isPast();
    }

    /**
     * Check if session is upcoming
     */
    public function isUpcoming()
    {
        return $this->session_date->isFuture();
    }

    /**
     * Get formatted session time
     */
    public function getFormattedTimeAttribute()
    {
        return $this->start_time->format('g:i A') . ' - ' . $this->end_time->format('g:i A');
    }

    /**
     * Get session duration in minutes
     */
    public function getDurationAttribute()
    {
        return $this->start_time->diffInMinutes($this->end_time);
    }

    /**
     * Get session duration formatted
     */
    public function getDurationFormattedAttribute()
    {
        $minutes = $this->duration;
        if ($minutes >= 60) {
            $hours = floor($minutes / 60);
            $remainingMinutes = $minutes % 60;
            return $hours . 'h' . ($remainingMinutes > 0 ? ' ' . $remainingMinutes . 'm' : '');
        }
        return $minutes . 'm';
    }

    /**
     * Check if session can be started
     */
    public function canBeStarted()
    {
        return $this->status === 'scheduled' && 
               $this->session_date->isToday() &&
               now()->between(
                   $this->start_time->subMinutes(15), // Allow starting 15 minutes early
                   $this->end_time
               );
    }

    /**
     * Check if session can be completed
     */
    public function canBeCompleted()
    {
        return $this->status === 'ongoing';
    }

    /**
     * Check if session can be cancelled
     */
    public function canBeCancelled()
    {
        return !in_array($this->status, ['completed', 'cancelled']);
    }

    /**
     * Check if session can be edited
     */
    public function canBeEdited()
    {
        return $this->status !== 'completed';
    }

    /**
     * Scope for upcoming sessions
     */
    public function scopeUpcoming($query)
    {
        return $query->where('session_date', '>=', now())
                    ->where('status', '!=', 'cancelled');
    }

    /**
     * Scope for past sessions
     */
    public function scopePast($query)
    {
        return $query->where('session_date', '<', now());
    }

    /**
     * Scope for active sessions
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['scheduled', 'ongoing']);
    }

    /**
     * Scope for sessions by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for sessions by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('session_type', $type);
    }

    /**
     * Scope for today's sessions
     */
    public function scopeToday($query)
    {
        return $query->whereDate('session_date', today());
    }

    /**
     * Scope for this week's sessions
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('session_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'scheduled' => 'yellow',
            'ongoing' => 'green',
            'completed' => 'blue',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get session type color for UI
     */
    public function getTypeColorAttribute()
    {
        return match($this->session_type) {
            'live' => 'blue',
            'recorded' => 'purple',
            'assignment' => 'green',
            'quiz' => 'yellow',
            default => 'gray'
        };
    }

    /**
     * Get session type icon for UI
     */
    public function getTypeIconAttribute()
    {
        return match($this->session_type) {
            'live' => 'video-camera',
            'recorded' => 'film',
            'assignment' => 'document-text',
            'quiz' => 'clipboard-check',
            default => 'calendar'
        };
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($session) {
            // Set default status if not provided
            if (empty($session->status)) {
                $session->status = 'scheduled';
            }
        });
    }
}