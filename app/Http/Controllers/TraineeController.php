<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use App\Models\Session; // <-- Don't forget this import if using sessions
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\CourseFeedback;
class TraineeController extends Controller
{
    /**
     * Display the trainee dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get user's enrollments by email (since you're not using user_id in enrollments)
        $enrollments = Enrollment::where('trainee_email', $user->email)
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_enrollments' => $enrollments->count(),
            'active_courses' => $enrollments->where('status', 'approved')->count(),
            'pending_enrollments' => $enrollments->where('status', 'pending')->count(),
            'completed_courses' => 0 // Implement later
        ];

        return view('trainee.dashboard', compact('enrollments', 'stats'));
    }

    /**
     * Show my courses page
     */
    public function myCourses()
    {
        $user = Auth::user();
        
        $enrollments = Enrollment::where('trainee_email', $user->email)
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('trainee.my-courses', compact('enrollments'));
    }

    /**
     * Activate course with reference ID
     */
    public function activateCourse(Request $request)
    {
        $request->validate([
            'reference_id' => [
                'required',
                'string',
                'size:13',
                'regex:/^AMX\d{10}$/'
            ]
        ], [
            'reference_id.size' => 'Reference ID must be exactly 13 characters long.',
            'reference_id.regex' => 'Invalid reference ID format. Please check and try again.'
        ]);

        $referenceId = strtoupper($request->reference_id);
        $user = Auth::user();

        $enrollment = Enrollment::where('reference_id', $referenceId)
            ->where('trainee_email', $user->email)
            ->with('course')
            ->first();

        if (!$enrollment) {
            throw ValidationException::withMessages([
                'reference_id' => 'Reference ID not found or does not belong to your email address.'
            ]);
        }

        if ($enrollment->status === 'approved') {
            return redirect()->back()->with('info', 'This course is already activated!');
        }

        $enrollment->update(['status' => 'approved']);

        return redirect()->back()->with('success', 
            'Course "' . $enrollment->course->title . '" has been activated successfully! You can now access your course materials.');
    }

    /**
     * Show course details for an enrolled student
     */
    public function showCourse(Enrollment $enrollment)
    {
        $user = Auth::user();

        if ($enrollment->trainee_email !== $user->email) {
            abort(403, 'Unauthorized access to this course.');
        }

        $enrollment->load(['course']);

        return view('trainee.course-details', compact('enrollment'));
    }

    /**
     * Access course content (basic version)
     */
    public function accessCourse(Request $request, Enrollment $enrollment)
    {
        $user = Auth::user();

        if ($enrollment->trainee_email !== $user->email) {
            abort(403, 'Unauthorized access to this course.');
        }

        if ($enrollment->status !== 'approved') {
            return redirect()->route('trainee.my-courses')
                ->with('error', 'This course is not yet activated. Please use your reference ID to activate it first.');
        }

        $providedReferenceId = $request->get('reference_id');
        if ($providedReferenceId && $enrollment->reference_id !== $providedReferenceId) {
            return redirect()->route('trainee.my-courses')
                ->with('error', 'Invalid reference ID for this course.');
        }

        $enrollment->load(['course']);

        return view('trainee.course-access', compact('enrollment'));
    }

    /**
     * Search for courses available for enrollment
     */
    public function browseCourses(Request $request)
    {
        $query = Course::query()->active()->available();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('lecturer_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->difficulty);
        }

        $courses = $query->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Course::active()->pluck('category')->unique();
        $difficulties = Course::active()->pluck('difficulty_level')->unique();

        return view('trainee.browse-courses', compact('courses', 'categories', 'difficulties'));
    }

    /**
     * Activate course with AJAX
     */
    public function activateCourseAjax(Request $request)
    {
        try {
            $request->validate([
                'reference_id' => [
                    'required',
                    'string',
                    'size:13',
                    'regex:/^AMX\d{10}$/'
                ]
            ], [
                'reference_id.size' => 'Reference ID must be exactly 13 characters long.',
                'reference_id.regex' => 'Invalid reference ID format. Please check and try again.'
            ]);

            $referenceId = strtoupper($request->reference_id);
            $user = Auth::user();

            $enrollment = Enrollment::where('reference_id', $referenceId)
                ->where('trainee_email', $user->email)
                ->with('course')
                ->first();

            if (!$enrollment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reference ID not found or does not belong to your email address.'
                ], 404);
            }

            if ($enrollment->status === 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'This course is already activated!'
                ], 400);
            }

            $enrollment->update(['status' => 'approved']);

            return response()->json([
                'success' => true,
                'message' => 'Course "' . $enrollment->course->title . '" has been activated successfully!',
                'course' => [
                    'title' => $enrollment->course->title,
                    'reference_id' => $enrollment->reference_id,
                    'status' => 'approved'
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    /**
     * Access course content with sessions and progress
     */
   /**
 * Access course content with sessions and progress
 */
public function accessCourseWithProgress(Request $request, Enrollment $enrollment)
{
    $user = Auth::user();

    if ($enrollment->trainee_email !== $user->email) {
        abort(403, 'Unauthorized access to this course.');
    }

    if ($enrollment->status !== 'approved') {
        return redirect()->route('trainee.my-courses')
            ->with('error', 'This course is not yet activated. Please use your reference ID to activate it first.');
    }

    $providedReferenceId = $request->get('reference_id');
    if ($providedReferenceId && $enrollment->reference_id !== $providedReferenceId) {
        return redirect()->route('trainee.my-courses')
            ->with('error', 'Invalid reference ID for this course.');
    }

    $enrollment->load(['course']);
    $course = $enrollment->course;  // This creates the $course variable

    $upcomingSessions = Session::where('course_id', $course->id)
        ->upcoming()
        ->active()
        ->orderBy('session_date', 'asc')
        ->get();

    $pastSessions = Session::where('course_id', $course->id)
        ->past()
        ->orderBy('session_date', 'desc')
        ->get();

    $totalSessions = Session::where('course_id', $course->id)->count();
    $attendedSessions = $pastSessions->count();
    $progress = $totalSessions > 0 ? round(($attendedSessions / $totalSessions) * 100, 2) : 0;

    // Update enrollment with calculated progress
    $enrollment->progress = $progress;
    $enrollment->sessions_attended = $attendedSessions;
    $enrollment->total_sessions = $totalSessions;
    $enrollment->assignments_completed = 0;
    $enrollment->total_assignments = 0;

    // Make sure to pass the $course variable to the view
    return view('trainee.course-access', compact('enrollment', 'course', 'upcomingSessions', 'pastSessions'));
}

public function storeFeedback(Request $request)
{
    $request->validate([
        'course_id' => 'required|exists:courses,id',
        'enrollment_id' => 'required|exists:enrollments,id',
        'rating' => 'required|integer|min:1|max:5',
        'feedback' => 'required|string|min:10|max:2000',
        'categories' => 'nullable|array',
        'categories.*' => 'string|in:content,instructor,delivery,materials,support,overall',
        'is_anonymous' => 'nullable|boolean'
    ]);

    $user = Auth::user();
    $enrollment = Enrollment::findOrFail($request->enrollment_id);

    // Verify the enrollment belongs to the current user
    if ($enrollment->trainee_email !== $user->email) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access to this enrollment.'
        ], 403);
    }

    // Verify the course_id matches the enrollment
    if ($enrollment->course_id != $request->course_id) {
        return response()->json([
            'success' => false,
            'message' => 'Course ID does not match enrollment.'
        ], 400);
    }

    try {
        // Check if feedback already exists
        $existingFeedback = CourseFeedback::where('user_id', $user->id)
            ->where('course_id', $request->course_id)
            ->first();

        $feedbackData = [
            'user_id' => $user->id,
            'course_id' => $request->course_id,
            'enrollment_id' => $request->enrollment_id,
            'username' => $user->name,
            'email' => $user->email,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'categories' => $request->categories ?? [],
            'is_anonymous' => $request->boolean('is_anonymous'),
            'status' => 'pending' // Default to pending for admin approval
        ];

        if ($existingFeedback) {
            // Update existing feedback
            $existingFeedback->update($feedbackData);
            $feedback = $existingFeedback;
            $action = 'updated';
        } else {
            // Create new feedback
            $feedback = CourseFeedback::create($feedbackData);
            $action = 'submitted';
        }

        // Update course stats
        $enrollment->course->updateStats();

        return response()->json([
            'success' => true,
            'message' => "Your feedback has been {$action} successfully!",
            'data' => [
                'id' => $feedback->id,
                'rating' => $feedback->rating,
                'status' => $feedback->status,
                'created_at' => $feedback->created_at->format('M j, Y'),
                'action' => $action
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to submit feedback. Please try again.'
        ], 500);
    }
}

/**
 * Get user's feedback for a course
 */
public function getFeedback($courseId)
{
    $user = Auth::user();
    
    $feedback = CourseFeedback::where('user_id', $user->id)
        ->where('course_id', $courseId)
        ->first();

    if (!$feedback) {
        return response()->json([
            'success' => false,
            'message' => 'No feedback found for this course.'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'id' => $feedback->id,
            'rating' => $feedback->rating,
            'feedback' => $feedback->feedback,
            'categories' => $feedback->categories,
            'is_anonymous' => $feedback->is_anonymous,
            'status' => $feedback->status,
            'created_at' => $feedback->created_at->format('M j, Y g:i A'),
            'admin_response' => $feedback->admin_response
        ]
    ]);
}

/**
 * Delete user's feedback
 */
public function deleteFeedback($courseId)
{
    $user = Auth::user();
    
    $feedback = CourseFeedback::where('user_id', $user->id)
        ->where('course_id', $courseId)
        ->first();

    if (!$feedback) {
        return response()->json([
            'success' => false,
            'message' => 'No feedback found to delete.'
        ], 404);
    }

    $feedback->delete();

    // Update course stats
    $course = Course::find($courseId);
    if ($course) {
        $course->updateStats();
    }

    return response()->json([
        'success' => true,
        'message' => 'Your feedback has been deleted successfully.'
    ]);
}
}
