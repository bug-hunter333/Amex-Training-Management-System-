<?php

namespace App\Mail;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnrollmentConfirmation extends Mailable  // REMOVED "implements ShouldQueue"
{
    use Queueable, SerializesModels;

    public $enrollment;

    /**
     * Create a new message instance.
     */
    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Course Enrollment Confirmation - Reference ID: ' . $this->enrollment->reference_id,
            from: config('mail.from.address', 'amextms2025@gmail.com'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'emails.enrollment-confirmation',  // SIMPLIFIED path
            with: [
                'enrollment' => $this->enrollment,
                'course' => $this->enrollment->course,
                'studentName' => $this->enrollment->trainee_name,
                'referenceId' => $this->enrollment->reference_id,
                'courseMaterials' => $this->getCourseMaterials(),
                'nextSteps' => $this->getNextSteps(),
                'dashboardUrl' => route('dashboard'),
                'supportEmail' => 'amextms2025@gmail.com',
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Get course materials information
     */
    private function getCourseMaterials(): array
    {
        $course = $this->enrollment->course;
        
        return [
            'materials' => [
                'Course handbook and syllabus',
                'Digital learning resources',
                'Practice exercises and assignments',
                'Video tutorials and lectures',
                'Online assessment tools'
            ],
            'resources' => [
                'Online student portal access',
                'Discussion forums',
                'Live session recordings',
                'Additional reading materials',
                'Technical support documentation'
            ],
            'platform' => 'Microsoft Teams',
            'duration' => ($course->duration_weeks ?? 4) . ' weeks (' . ($course->duration_hours ?? 40) . ' hours)',
            'startDate' => $course->start_date ? date('F j, Y', strtotime($course->start_date)) : 'To be announced',
        ];
    }

    /**
     * Get next steps information
     */
    private function getNextSteps(): array
    {
        return [
            [
                'title' => 'Keep Your Reference ID Safe',
                'description' => 'Use your reference ID (' . $this->enrollment->reference_id . ') to access your course materials and track your enrollment status.',
                'action' => 'Save this email for future reference',
                'icon' => 'shield-check'
            ],
            [
                'title' => 'Course Access',
                'description' => 'Use your reference ID in the "My Courses" section to access your dedicated course page.',
                'action' => 'Visit Dashboard → My Courses',
                'icon' => 'academic-cap'
            ],
            [
                'title' => 'Application Review',
                'description' => 'Our admissions team will review your application within 2-3 business hours.',
                'action' => 'Check your email for status updates',
                'icon' => 'clock'
            ],
            [
                'title' => 'Payment Instructions',
                'description' => 'Payment details will be sent once your application is approved.',
                'action' => 'Wait for approval notification',
                'icon' => 'credit-card'
            ]
        ];
    }
}