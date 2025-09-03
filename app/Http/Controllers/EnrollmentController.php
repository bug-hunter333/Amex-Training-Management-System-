<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollmentRequest;
use App\Models\Course;
use App\Models\Enrollment;
use App\Mail\EnrollmentConfirmation;
use App\Mail\EnrollmentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EnrollmentController extends Controller
{
    /**
     * Display the enrollment form
     */
    public function create(Course $course)
    {
        // Check if course is available for enrollment
        if (!$course->is_active) {
            return redirect()->back()->with('error', 'This course is not currently available for enrollment.');
        }

        // Check if course is full
        $currentEnrollments = $course->enrollments()->approved()->count();
        if ($currentEnrollments >= $course->max_participants) {
            return redirect()->back()->with('error', 'This course is currently full. Please check back later.');
        }

        return view('enrollments.create', compact('course'));
    }

    /**
     * Store the enrollment
     */
    public function store(EnrollmentRequest $request)
    {
        try {
            // Get the course
            $course = Course::findOrFail($request->course_id);

            // Check if course is still available
            $currentEnrollments = $course->enrollments()->approved()->count();
            if ($currentEnrollments >= $course->max_participants) {
                return redirect()->back()
                    ->with('error', 'Sorry, this course is now full.')
                    ->withInput();
            }

            // Check for duplicate enrollment
            $existingEnrollment = Enrollment::where('course_id', $request->course_id)
                ->where('trainee_email', $request->trainee_email)
                ->first();

            if ($existingEnrollment) {
                return redirect()->back()
                    ->with('error', 'You have already enrolled for this course.')
                    ->withInput();
            }

            // Set enrollment_date to current timestamp
            $enrollmentData = $request->validated();
            $enrollmentData['enrollment_date'] = now();

            // Create the enrollment (reference_id will be auto-generated)
            $enrollment = Enrollment::create($enrollmentData);

            // Load the course relationship
            $enrollment->load('course');

            // Log enrollment creation
            Log::info('Enrollment created', [
                'enrollment_id' => $enrollment->id,
                'reference_id' => $enrollment->reference_id,
                'trainee_email' => $enrollment->trainee_email,
                'course_title' => $enrollment->course->title
            ]);

            // Send confirmation email to trainee with reference ID and course materials
            try {
                Log::info('Attempting to send confirmation email to: ' . $enrollment->trainee_email);
                
                Mail::to($enrollment->trainee_email)->send(new EnrollmentConfirmation($enrollment));
                
                Log::info('Confirmation email sent successfully to: ' . $enrollment->trainee_email, [
                    'reference_id' => $enrollment->reference_id
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send enrollment confirmation email', [
                    'error' => $e->getMessage(),
                    'enrollment_id' => $enrollment->id,
                    'reference_id' => $enrollment->reference_id,
                    'trainee_email' => $enrollment->trainee_email
                ]);
            }

            // Send notification email to admin/course coordinator
            try {
                $adminEmail = config('mail.admin_email', 'amextms2025@gmail.com');
                Log::info('Attempting to send notification email to admin: ' . $adminEmail);
                
                Mail::to($adminEmail)->send(new EnrollmentNotification($enrollment));
                
                Log::info('Admin notification email sent successfully to: ' . $adminEmail);
            } catch (\Exception $e) {
                Log::error('Failed to send enrollment notification email', [
                    'error' => $e->getMessage(),
                    'enrollment_id' => $enrollment->id,
                    'reference_id' => $enrollment->reference_id,
                    'admin_email' => $adminEmail
                ]);
            }

            return redirect()->route('enrollment.success', ['enrollment' => $enrollment->id])
                ->with('success', 'Your enrollment has been submitted successfully! Check your email for your Reference ID: ' . $enrollment->reference_id);

        } catch (\Exception $e) {
            Log::error('Enrollment creation failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->validated()
            ]);
            
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display enrollment success page
     */
    public function success(Enrollment $enrollment)
    {
        return view('enrollments.success', compact('enrollment'));
    }

    /**
     * Display enrollment details
     */
    public function show(Enrollment $enrollment)
    {
        $enrollment->load('course');
        return view('enrollments.show', compact('enrollment'));
    }

    /**
     * Display all enrollments for admin
     */
    public function index(Request $request)
    {
        $query = Enrollment::with('course')
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Search by name, email, or reference ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('trainee_name', 'like', "%{$search}%")
                  ->orWhere('trainee_email', 'like', "%{$search}%")
                  ->orWhere('reference_id', 'like', "%{$search}%");
            });
        }

        $enrollments = $query->paginate(15);
        $courses = Course::active()->get();

        return view('enrollments.index', compact('enrollments', 'courses'));
    }

    /**
     * Update enrollment status
     */
    public function updateStatus(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $oldStatus = $enrollment->status;
        $enrollment->update(['status' => $request->status]);

        // Send status update email if status changed
        if ($oldStatus !== $request->status) {
            try {
                // You can create additional mail classes for status updates
                // Mail::to($enrollment->trainee_email)->send(new EnrollmentStatusUpdate($enrollment));
            } catch (\Exception $e) {
                Log::error('Failed to send status update email: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Enrollment status updated successfully.');
    }

    /**
     * Delete enrollment
     */
    public function destroy(Enrollment $enrollment)
    {
        try {
            $enrollment->delete();
            return redirect()->back()->with('success', 'Enrollment deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete enrollment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete enrollment.');
        }
    }

    /**
     * Validate reference ID and redirect to course page
     */
    public function validateReferenceId(Request $request)
    {
        $request->validate([
            'reference_id' => 'required|string|size:12',
            'course_id' => 'required|exists:courses,id'
        ]);

        $referenceId = strtoupper($request->reference_id);
        
        // Validate reference ID format
        if (!Enrollment::isValidReferenceId($referenceId)) {
            throw ValidationException::withMessages([
                'reference_id' => 'Invalid reference ID format. Please check and try again.'
            ]);
        }

        // Find enrollment with this reference ID and course
        $enrollment = Enrollment::where('reference_id', $referenceId)
            ->where('course_id', $request->course_id)
            ->where('status', 'approved')
            ->with('course')
            ->first();

        if (!$enrollment) {
            throw ValidationException::withMessages([
                'reference_id' => 'Reference ID not found or not approved for this course. Please check and try again.'
            ]);
        }

        // Redirect to dedicated course page
        return redirect()->route('course.dedicated', [
            'enrollment' => $enrollment->id,
            'reference_id' => $referenceId
        ]);
    }

    /**
     * Display dedicated course page
     */
    public function dedicatedCoursePage(Request $request, Enrollment $enrollment)
    {
        // Verify reference ID matches
        $providedReferenceId = $request->get('reference_id');
        if ($enrollment->reference_id !== $providedReferenceId) {
            return redirect()->route('dashboard')->with('error', 'Invalid access. Please use your reference ID.');
        }

        // Load course with all necessary relationships
        $enrollment->load(['course' => function($query) {
            $query->with(['sessions' => function($sessionQuery) {
                $sessionQuery->where('session_date', '>=', now())
                             ->orderBy('session_date', 'asc');
            }]);
        }]);

        return view('course.dedicated', compact('enrollment'));
    }

    /**
     * Test email configuration
     */
    public function testEmail()
    {
        try {
            Log::info('Testing email configuration...');
            
            Mail::raw('This is a test email from TMS Training Management System. If you receive this, your email configuration is working correctly!', function ($message) {
                $message->to('miyulasbandara@gmail.com') // Change to your test email
                        ->subject('TMS Email Configuration Test - ' . now()->format('Y-m-d H:i:s'))
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            Log::info('Test email sent successfully');
            return response()->json(['success' => true, 'message' => '✅ Email sent successfully!']);
            
        } catch (\Exception $e) {
            Log::error('Test email failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => '❌ Email failed: ' . $e->getMessage()]);
        }
    }
}