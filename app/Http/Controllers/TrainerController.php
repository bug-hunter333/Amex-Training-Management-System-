<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\CourseFeedback;
use App\Models\Session;
use App\Models\User;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TrainerController extends Controller
{
    /**
     * Get the trainer record for the authenticated user
     */
    private function getTrainer()
    {
        $user = Auth::user();
        $trainer = Trainer::where('user_id', $user->id)->first();
        
        if (!$trainer) {
            abort(403, 'You are not registered as a trainer.');
        }
        
        return $trainer;
    }

    /**
     * Display the trainer dashboard
     */
    /**
 * Display the trainer dashboard - DEBUG VERSION
 */
public function dashboard()
{
    $trainer = $this->getTrainer();
    
    // DEBUG: Check trainer details
    Log::info('Dashboard - Trainer Info', [
        'trainer_id' => $trainer->id,
        'user_id' => $trainer->user_id,
        'user_name' => $trainer->user->name ?? 'No name'
    ]);
    
    // DEBUG: Raw database queries
    $rawCourseCount = DB::table('courses')->where('trainer_id', $trainer->id)->count();
    $rawEnrollmentCount = DB::table('enrollments')
        ->join('courses', 'enrollments.course_id', '=', 'courses.id')
        ->where('courses.trainer_id', $trainer->id)
        ->where('enrollments.status', 'approved')
        ->count();
        
    Log::info('Raw Database Counts', [
        'raw_courses' => $rawCourseCount,
        'raw_approved_enrollments' => $rawEnrollmentCount
    ]);
    
    // Get trainer's courses with statistics
    $courses = Course::where('trainer_id', $trainer->id)
        ->withCount(['enrollments as total_enrollments', 'approvedEnrollments as approved_enrollments'])
        ->with(['sessions' => function($query) {
            $query->where('session_date', '>=', now())->orderBy('session_date');
        }])
        ->get();

    // Dashboard statistics - Using direct database queries
    $stats = [
        'total_courses' => $rawCourseCount, // Use raw count
        'total_trainees' => $rawEnrollmentCount, // Use raw count
        'active_sessions' => Session::whereHas('course', function($query) use ($trainer) {
            $query->where('trainer_id', $trainer->id);
        })->where('status', 'scheduled')->count(),
        'pending_enrollments' => Enrollment::whereHas('course', function($query) use ($trainer) {
            $query->where('trainer_id', $trainer->id);
        })->where('status', 'pending')->count(),
    ];
    
    // DEBUG: Log final stats
    Log::info('Final Dashboard Stats', $stats);
    
    // Also dump stats to screen temporarily (remove this in production)
    // dd($stats);

    // Recent feedback
    $recentFeedback = CourseFeedback::whereHas('course', function($query) use ($trainer) {
        $query->where('trainer_id', $trainer->id);
    })->with(['course', 'user'])->latest()->take(5)->get();

    // Upcoming sessions
    $upcomingSessions = Session::whereHas('course', function($query) use ($trainer) {
        $query->where('trainer_id', $trainer->id);
    })->where('session_date', '>=', now())
      ->where('status', '!=', 'cancelled')
      ->with('course')
      ->orderBy('session_date')
      ->take(5)
      ->get();

    return view('trainer.dashboard', compact('courses', 'stats', 'recentFeedback', 'upcomingSessions', 'trainer'));
}

    /**
     * Show all courses created by trainer
     */
    public function myCourses()
    {
        $trainer = $this->getTrainer();
        
        $courses = Course::where('trainer_id', $trainer->id)
            ->withCount([
                'enrollments as total_enrollments',
                'approvedEnrollments as approved_enrollments',
                'sessions as total_sessions'
            ])
            ->with(['enrollments' => function($query) {
                $query->latest();
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('trainer.my-courses', compact('courses', 'trainer'));
    }

    /**
     * Show form to create new course
     */
    public function createCourse()
    {
        $trainer = $this->getTrainer();
        return view('trainer.courses.create', compact('trainer'));
    }

    /**
     * Store new course
     */
public function storeCourse(Request $request)
{
    $trainer = $this->getTrainer();
    
    // DEBUG: Log trainer info
    Log::info('Creating course for trainer', [
        'trainer_id' => $trainer->id,
        'user_id' => $trainer->user_id,
        'trainer_name' => $trainer->user->name
    ]);
    
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|string',
        'course_type' => 'required|string',
        'difficulty_level' => 'required|string',
        'duration_weeks' => 'required|integer|min:1',
        'duration_hours' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'max_participants' => 'required|integer|min:1',
        'min_participants' => 'required|integer|min:1',
        'start_date' => 'required|date|after:today',
        'end_date' => 'required|date|after:start_date',
        'enrollment_start_date' => 'required|date',
        'enrollment_end_date' => 'required|date|after:enrollment_start_date',
        'prerequisites' => 'nullable|array',
        'learning_objectives' => 'nullable|array',
        'schedule' => 'nullable|array',
        'materials' => 'nullable|array',
        'resources' => 'nullable|array',
        'tags' => 'nullable|array',
        'venue_type' => 'required|string',
        'venue_name' => 'nullable|string',
        'venue_address' => 'nullable|string',
        'requires_approval' => 'boolean',
        'is_featured' => 'boolean',
        'is_mandatory' => 'boolean',
    ]);

    $validated['trainer_id'] = $trainer->id;
    $validated['lecturer_name'] = $trainer->user->name;
    $validated['lecturer_email'] = $trainer->user->email;
    $validated['lecturer_bio'] = $trainer->bio;
    $validated['slug'] = Str::slug($validated['title']);
    $validated['status'] = 'published';
    $validated['is_active'] = true;
    
    // DEBUG: Log data before saving
    Log::info('Course data before save', [
        'trainer_id' => $validated['trainer_id'],
        'title' => $validated['title'],
        'slug' => $validated['slug']
    ]);
    
    // Ensure unique slug
    $originalSlug = $validated['slug'];
    $counter = 1;
    while (Course::where('slug', $validated['slug'])->exists()) {
        $validated['slug'] = $originalSlug . '-' . $counter;
        $counter++;
    }

    // Create course and get the created instance
    $course = Course::create($validated);
    
    // DEBUG: Verify course was created
    Log::info('Course created', [
        'course_id' => $course->id,
        'trainer_id' => $course->trainer_id,
        'title' => $course->title
    ]);
    
    // DEBUG: Check count after creation
    $currentCount = Course::where('trainer_id', $trainer->id)->count();
    Log::info('Current course count after creation', ['count' => $currentCount]);

    return redirect()->route('trainer.dashboard')->with('success', 'Course created successfully!');
}

    /**
     * Show form to edit course
     */
    public function editCourse(Course $course)
    {
        $trainer = $this->getTrainer();
        
        // Check if trainer owns this course
        if ($course->trainer_id !== $trainer->id) {
            abort(403);
        }

        return view('trainer.edit-course', compact('course', 'trainer'));
    }

    /**
     * Update course
     */
    public function updateCourse(Request $request, Course $course)
    {
        $trainer = $this->getTrainer();
        
        // Check if trainer owns this course
        if ($course->trainer_id !== $trainer->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'course_type' => 'required|string',
            'difficulty_level' => 'required|string',
            'duration_weeks' => 'required|integer|min:1',
            'duration_hours' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'min_participants' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'enrollment_start_date' => 'required|date',
            'enrollment_end_date' => 'required|date|after:enrollment_start_date',
            'prerequisites' => 'nullable|array',
            'learning_objectives' => 'nullable|array',
            'schedule' => 'nullable|array',
            'materials' => 'nullable|array',
            'resources' => 'nullable|array',
            'tags' => 'nullable|array',
            'venue_type' => 'required|string',
            'venue_name' => 'nullable|string',
            'venue_address' => 'nullable|string',
            'requires_approval' => 'boolean',
            'is_featured' => 'boolean',
            'is_mandatory' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Update slug only if title changed
        if ($validated['title'] !== $course->title) {
            $validated['slug'] = Str::slug($validated['title']);
            
            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Course::where('slug', $validated['slug'])->where('id', '!=', $course->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $course->update($validated);

        // Redirect to dashboard to see updated stats
        return redirect()->route('trainer.dashboard')->with('success', 'Course updated successfully!');
    }

    /**
     * Show assigned trainees
     */
    public function assignedTrainees()
    {
        $trainer = $this->getTrainer();
        
        $enrollments = Enrollment::whereHas('course', function($query) use ($trainer) {
            $query->where('trainer_id', $trainer->id);
        })->with(['course', 'user'])
          ->orderBy('created_at', 'desc')
          ->paginate(15);

        return view('trainer.manage-trainees', compact('enrollments', 'trainer'));
    }

    /**
     * View feedback received from trainees
     */
    public function viewFeedback(Request $request)
    {
        $trainer = $this->getTrainer();
        
        $query = CourseFeedback::whereHas('course', function($q) use ($trainer) {
            $q->where('trainer_id', $trainer->id);
        })->with(['course', 'user']);

        // Filter by course if specified
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by rating if specified
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $feedback = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get trainer's courses for filter dropdown
        $courses = Course::where('trainer_id', $trainer->id)->get();

        return view('trainer.course-feedback', compact('feedback', 'courses', 'trainer'));
    }

    /**
     * Session management
     */
    public function manageSessions()
    {
        $trainer = $this->getTrainer();
        
        $sessions = Session::whereHas('course', function($query) use ($trainer) {
            $query->where('trainer_id', $trainer->id);
        })->with('course')
          ->orderBy('session_date', 'desc')
          ->paginate(15);

        return view('trainer.sessions.index', compact('sessions', 'trainer'));
    }

    /**
     * Show form to create new session
     */
    public function createSession()
    {
        $trainer = $this->getTrainer();
        $courses = Course::where('trainer_id', $trainer->id)->where('is_active', true)->get();

        return view('trainer.sessions.create', compact('courses', 'trainer'));
    }

    /**
     * Show form to edit session
     */
    public function editSession(Session $session)
    {
        $trainer = $this->getTrainer();
        
        // Verify trainer owns the course
        if ($session->course->trainer_id !== $trainer->id) {
            abort(403);
        }

        $courses = Course::where('trainer_id', $trainer->id)->where('is_active', true)->get();

        return view('trainer.sessions.edit', compact('session', 'courses', 'trainer'));
    }

    /**
     * Store new session
     */
    public function storeSession(Request $request)
    {
        $trainer = $this->getTrainer();
        
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'topic' => 'nullable|string',
            'session_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'meeting_link' => 'nullable|url',
            'session_type' => 'required|in:live,recorded,assignment,quiz',
            'materials' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        // Verify trainer owns the course
        $course = Course::findOrFail($validated['course_id']);
        if ($course->trainer_id !== $trainer->id) {
            abort(403);
        }

        // Convert times to datetime
        $validated['start_time'] = Carbon::parse($validated['session_date'] . ' ' . $validated['start_time']);
        $validated['end_time'] = Carbon::parse($validated['session_date'] . ' ' . $validated['end_time']);

        Session::create($validated);

        return redirect()->route('trainer.sessions.index')->with('success', 'Session created successfully!');
    }

    /**
     * Update session
     */
    public function updateSession(Request $request, Session $session)
    {
        $trainer = $this->getTrainer();
        
        // Verify trainer owns the course
        if ($session->course->trainer_id !== $trainer->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'topic' => 'nullable|string',
            'session_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'meeting_link' => 'nullable|url',
            'session_type' => 'required|in:live,recorded,assignment,quiz',
            'materials' => 'nullable|array',
            'notes' => 'nullable|string',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
        ]);

        // Convert times to datetime
        $validated['start_time'] = Carbon::parse($validated['session_date'] . ' ' . $validated['start_time']);
        $validated['end_time'] = Carbon::parse($validated['session_date'] . ' ' . $validated['end_time']);

        $session->update($validated);

        return redirect()->route('trainer.sessions.index')->with('success', 'Session updated successfully!');
    }

    /**
     * Start session
     */
    public function startSession(Session $session)
    {
        $trainer = $this->getTrainer();
        
        // Verify trainer owns the course
        if ($session->course->trainer_id !== $trainer->id) {
            abort(403);
        }

        // Check if session can be started
        if (!$session->canBeStarted()) {
            return back()->with('error', 'Session cannot be started at this time.');
        }

        $session->update(['status' => 'ongoing']);

        return back()->with('success', 'Session started successfully!');
    }

    /**
     * Complete session
     */
    public function completeSession(Session $session)
    {
        $trainer = $this->getTrainer();
        
        // Verify trainer owns the course
        if ($session->course->trainer_id !== $trainer->id) {
            abort(403);
        }

        // Check if session can be completed
        if (!$session->canBeCompleted()) {
            return back()->with('error', 'Session cannot be completed.');
        }

        $session->update(['status' => 'completed']);

        return back()->with('success', 'Session completed successfully!');
    }

    /**
     * Cancel session
     */
    public function cancelSession(Session $session)
    {
        $trainer = $this->getTrainer();
        
        // Verify trainer owns the course
        if ($session->course->trainer_id !== $trainer->id) {
            abort(403);
        }

        $session->update(['status' => 'cancelled']);

        return back()->with('success', 'Session cancelled successfully!');
    }

    /**
     * Delete session permanently
     */
    public function destroySession(Session $session)
    {
        $trainer = $this->getTrainer();
        
        // Verify trainer owns the course
        if ($session->course->trainer_id !== $trainer->id) {
            abort(403);
        }

        // Check if session can be deleted (only if not completed or ongoing)
        if (in_array($session->status, ['completed', 'ongoing'])) {
            return back()->with('error', 'Cannot delete a session that is completed or ongoing.');
        }

        $session->delete();

        return redirect()->route('trainer.sessions.index')->with('success', 'Session deleted successfully!');
    }

    /**
     * Update trainee enrollment status
     */
    public function updateTraineeStatus(Request $request, Enrollment $enrollment)
    {
        $trainer = $this->getTrainer();
        
        // Verify trainer owns the course
        if ($enrollment->course->trainer_id !== $trainer->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $enrollment->update($validated);

        return back()->with('success', 'Trainee status updated successfully!');
    }

    /**
     * Remove enrolled trainee
     */
    public function removeTrainee(Enrollment $enrollment)
    {
        $trainer = $this->getTrainer();
        
        // Verify trainer owns the course
        if ($enrollment->course->trainer_id !== $trainer->id) {
            abort(403);
        }

        $enrollment->delete();

        return back()->with('success', 'Trainee removed successfully!');
    }

    /**
     * Get trainer's courses (AJAX)
     */
    public function getTrainerCourses()
    {
        $trainer = $this->getTrainer();
        
        $courses = Course::where('trainer_id', $trainer->id)
            ->select('id', 'title', 'slug', 'is_active', 'enrollment_count', 'max_participants')
            ->withCount('approvedEnrollments')
            ->get();

        return response()->json($courses);
    }

    /**
     * Show trainer profile
     */
    public function profile()
    {
        $trainer = $this->getTrainer();
        return view('trainer.profile', compact('trainer'));
    }

    /**
     * Update trainer profile
     */
    public function updateProfile(Request $request)
    {
        $trainer = $this->getTrainer();
        $user = $trainer->user;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'specialization' => 'nullable|string',
            'linkedin_profile' => 'nullable|url',
            'certifications' => 'nullable|string',
        ]);

        // Update user data
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update trainer data
        $trainer->update([
            'phone' => $validated['phone'] ?? $trainer->phone,
            'bio' => $validated['bio'] ?? $trainer->bio,
            'specialization' => $validated['specialization'] ?? $trainer->specialization,
            'linkedin_profile' => $validated['linkedin_profile'] ?? $trainer->linkedin_profile,
            'certifications' => $validated['certifications'] ?? $trainer->certifications,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}