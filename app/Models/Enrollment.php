<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'trainee_name',
        'trainee_email',
        'trainee_phone',
        'date_of_birth',
        'gender',
        'education_level',
        'trainee_address',
        'previous_experience',
        'status',
        'enrollment_date',
        'completion_date',
        'certificate_issued',
        'progress_percentage',
        'notes',
        'reference_id', // ADD THIS LINE
    ];

    protected $casts = [
        'enrollment_date' => 'datetime',
        'completion_date' => 'datetime',
        'date_of_birth' => 'date',
        'certificate_issued' => 'boolean',
        'progress_percentage' => 'integer',
    ];

    /**
     * Boot method to auto-generate reference ID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($enrollment) {
            if (empty($enrollment->reference_id)) {
                $enrollment->reference_id = static::generateReferenceId();
            }
        });
    }

    /**
     * Generate a unique reference ID
     * Format: AMX + Date (YYMMDD) + 4 digits (13 characters total)
     * Example: AMX2708270001
     */
    public static function generateReferenceId(): string
    {
        do {
            // Get current date in YYMMDD format
            $dateString = now()->format('ymd');
            
            // Get the next sequential number for today
            $todayPrefix = 'AMX' . $dateString;
            $lastToday = static::where('reference_id', 'LIKE', $todayPrefix . '%')
                              ->orderBy('reference_id', 'desc')
                              ->first();
            
            if ($lastToday) {
                // Extract the last 4 digits and increment
                $lastNumber = intval(substr($lastToday->reference_id, -4));
                $nextNumber = $lastNumber + 1;
            } else {
                // First enrollment today
                $nextNumber = 1;
            }
            
            // Pad with zeros to make it 4 digits
            $fourDigits = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            
            $referenceId = $todayPrefix . $fourDigits;
        } while (static::where('reference_id', $referenceId)->exists());

        return $referenceId;
    }

    /**
     * Validate reference ID format
     * Format: AMX + 6 digits (date YYMMDD) + 4 digits = 13 characters
     */
    public static function isValidReferenceId(string $referenceId): bool
    {
        // Check if it matches the pattern: AMX + 6 digits + 4 digits (13 total)
        return preg_match('/^AMX[0-9]{6}[0-9]{4}$/', $referenceId);
    }

    /**
     * Get the course that owns the enrollment
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the trainer through the course
     */
    public function trainer()
    {
        return $this->course->trainer();
    }

    /**
     * Check if enrollment is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if enrollment is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if enrollment is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if trainee has completed the course
     */
    public function isCompleted(): bool
    {
        return $this->completion_date !== null;
    }

    /**
     * Get trainee age
     */
    public function getAgeAttribute(): int
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    /**
     * Get formatted enrollment date
     */
    public function getFormattedEnrollmentDateAttribute(): string
    {
        return $this->enrollment_date->format('M j, Y');
    }

    /**
     * Get formatted completion date
     */
    public function getFormattedCompletionDateAttribute(): string
    {
        return $this->completion_date ? $this->completion_date->format('M j, Y') : 'Not completed';
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'approved' => 'green',
            'pending' => 'yellow',
            'rejected' => 'red',
            default => 'gray'
        };
    }

    /**
     * Scope for approved enrollments
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for pending enrollments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for rejected enrollments
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope for completed enrollments
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completion_date');
    }

    /**
     * Scope by course
     */
    public function scopeByCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }
}