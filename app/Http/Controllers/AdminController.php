<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\CourseFeedback;
use App\Models\Session;
use App\Models\User;
use App\Models\Trainer;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Get the admin record for the authenticated user
     */
    private function getAdmin()
    {
        $user = Auth::user();
        $admin = Admin::where('user_id', $user->id)->first();
        
        if (!$admin) {
            abort(403, 'You are not authorized as an administrator.');
        }
        
        return $admin;
    }

    /**
     * Display the admin dashboard
     */
    public function dashboard()
    {
        $admin = $this->getAdmin();
        
        // Dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'total_trainers' => Trainer::count(),
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
            'active_courses' => Course::where('is_active', true)->count(),
            'pending_enrollments' => Enrollment::where('status', 'pending')->count(),
            'active_sessions' => Session::where('status', 'scheduled')->count(),
            'completed_sessions' => Session::where('status', 'completed')->count(),
        ];

        // Recent activities
        $recentEnrollments = Enrollment::with(['course', 'user'])
            ->latest()
            ->take(10)
            ->get();

        $recentCourses = Course::with('trainer.user')
            ->latest()
            ->take(5)
            ->get();

        $recentFeedback = CourseFeedback::with(['course', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Monthly enrollment trends
        $monthlyEnrollments = Enrollment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )->whereYear('created_at', now()->year)
         ->groupBy('year', 'month')
         ->orderBy('year', 'desc')
         ->orderBy('month', 'desc')
         ->take(12)
         ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'recentEnrollments', 
            'recentCourses', 
            'recentFeedback', 
            'monthlyEnrollments',
            'admin'
        ));
    }

    /**
     * Manage all users
     */
    public function manageUsers(Request $request)
    {
        $admin = $this->getAdmin();
        
        $query = User::with(['trainer', 'enrollments']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $role = $request->role;
            if ($role === 'trainer') {
                $query->whereHas('trainer');
            } elseif ($role === 'student') {
                $query->whereDoesntHave('trainer');
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.index', compact('users', 'admin'));
    }

    /**
     * Show form to create new user
     */
    public function createUser()
    {
        $admin = $this->getAdmin();
        return view('admin.users.create', compact('admin'));
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $admin = $this->getAdmin();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:student,trainer,admin',
            'is_active' => 'boolean',
            // Trainer specific fields
            'specialization' => 'nullable|string',
            'bio' => 'nullable|string',
            'certifications' => 'nullable|string',
            'linkedin_profile' => 'nullable|url',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'is_active' => $validated['is_active'] ?? true,
            'email_verified_at' => now(),
        ]);

        // Create role-specific records
        if ($validated['role'] === 'trainer') {
            Trainer::create([
                'user_id' => $user->id,
                'specialization' => $validated['specialization'],
                'bio' => $validated['bio'],
                'certifications' => $validated['certifications'],
                'linkedin_profile' => $validated['linkedin_profile'],
                'is_approved' => true, // Admin created trainers are auto-approved
            ]);
        } elseif ($validated['role'] === 'admin') {
            Admin::create([
                'user_id' => $user->id,
                'permissions' => json_encode(['manage_users', 'manage_courses', 'manage_content']),
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    /**
     * Show form to edit user
     */
    public function editUser(User $user)
    {
        $admin = $this->getAdmin();
        $user->load('trainer');
        
        return view('admin.users.edit', compact('user', 'admin'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $admin = $this->getAdmin();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            // Trainer specific fields
            'specialization' => 'nullable|string',
            'bio' => 'nullable|string',
            'certifications' => 'nullable|string',
            'linkedin_profile' => 'nullable|url',
        ]);

        // Update user
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'is_active' => $validated['is_active'] ?? $user->is_active,
        ]);

        // Update trainer info if exists
        if ($user->trainer) {
            $user->trainer->update([
                'specialization' => $validated['specialization'],
                'bio' => $validated['bio'],
                'certifications' => $validated['certifications'],
                'linkedin_profile' => $validated['linkedin_profile'],
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Toggle user active status
     */
    public function toggleUserStatus(User $user)
    {
        $admin = $this->getAdmin();
        
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "User {$status} successfully!");
    }

    /**
     * Delete user
     */
    public function destroyUser(User $user)
    {
        $admin = $this->getAdmin();
        
        // Check if user has active enrollments or courses
        if ($user->enrollments()->exists() || ($user->trainer && $user->trainer->courses()->exists())) {
            return back()->with('error', 'Cannot delete user with active enrollments or courses.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    /**
     * Manage all courses
     */
    public function manageCourses(Request $request)
    {
        $admin = $this->getAdmin();
        
        $query = Course::with(['trainer.user'])
            ->withCount(['enrollments as total_enrollments', 'approvedEnrollments as approved_enrollments']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by trainer
        if ($request->filled('trainer_id')) {
            $query->where('trainer_id', $request->trainer_id);
        }

        $courses = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get all trainers for filter
        $trainers = Trainer::with('user')->get();
        
        // Get unique categories
        $categories = Course::distinct('category')->pluck('category')->filter();

        return view('admin.courses.index', compact('courses', 'trainers', 'categories', 'admin'));
    }

    /**
     * Show course details
     */
    public function showCourse(Course $course)
    {
        $admin = $this->getAdmin();
        
        $course->load([
            'trainer.user',
            'enrollments.user',
            'sessions',
            'feedback.user'
        ]);

        return view('admin.courses.show', compact('course', 'admin'));
    }

    /**
     * Toggle course active status
     */
    public function toggleCourseStatus(Course $course)
    {
        $admin = $this->getAdmin();
        
        $course->update(['is_active' => !$course->is_active]);
        
        $status = $course->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Course {$status} successfully!");
    }

    /**
     * Update course status
     */
    public function updateCourseStatus(Request $request, Course $course)
    {
        $admin = $this->getAdmin();
        
        $validated = $request->validate([
            'status' => 'required|in:draft,published,suspended,cancelled'
        ]);

        $course->update($validated);

        return back()->with('success', 'Course status updated successfully!');
    }

    /**
     * Manage all trainers
     */
    public function manageTrainers(Request $request)
    {
        $admin = $this->getAdmin();
        
        $query = Trainer::with('user')
            ->withCount(['courses as total_courses']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('specialization', 'like', "%{$search}%");
        }

        // Filter by approval status
        if ($request->filled('approval_status')) {
            $query->where('is_approved', $request->approval_status === 'approved');
        }

        $trainers = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.trainers.index', compact('trainers', 'admin'));
    }

    /**
     * Show trainer details
     */
    public function showTrainer(Trainer $trainer)
    {
        $admin = $this->getAdmin();
        
        $trainer->load([
            'user',
            'courses.enrollments',
            'courses' => function($query) {
                $query->withCount(['enrollments as total_enrollments', 'approvedEnrollments as approved_enrollments']);
            }
        ]);

        return view('admin.trainers.show', compact('trainer', 'admin'));
    }

    /**
     * Approve/reject trainer
     */
    public function updateTrainerStatus(Request $request, Trainer $trainer)
    {
        $admin = $this->getAdmin();
        
        $validated = $request->validate([
            'is_approved' => 'required|boolean',
            'approval_notes' => 'nullable|string'
        ]);

        $trainer->update([
            'is_approved' => $validated['is_approved'],
            'approval_notes' => $validated['approval_notes'],
            'approved_at' => $validated['is_approved'] ? now() : null,
        ]);

        $status = $validated['is_approved'] ? 'approved' : 'rejected';
        return back()->with('success', "Trainer {$status} successfully!");
    }

    /**
     * Manage all enrollments
     */
    public function manageEnrollments(Request $request)
    {
        $admin = $this->getAdmin();
        
        $query = Enrollment::with(['course', 'user']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('course', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $enrollments = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get all courses for filter
        $courses = Course::select('id', 'title')->get();

        return view('admin.enrollments.index', compact('enrollments', 'courses', 'admin'));
    }

    /**
     * Update enrollment status
     */
    public function updateEnrollmentStatus(Request $request, Enrollment $enrollment)
    {
        $admin = $this->getAdmin();
        
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,cancelled'
        ]);

        $enrollment->update($validated);

        return back()->with('success', 'Enrollment status updated successfully!');
    }

    /**
     * View all feedback
     */
    public function manageFeedback(Request $request)
    {
        $admin = $this->getAdmin();
        
        $query = CourseFeedback::with(['course', 'user']);

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $feedback = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get all courses for filter
        $courses = Course::select('id', 'title')->get();

        return view('admin.feedback.index', compact('feedback', 'courses', 'admin'));
    }

    /**
     * System settings
     */
    public function systemSettings()
    {
        $admin = $this->getAdmin();
        
        // Get system configuration (you might store this in a settings table)
        $settings = [
            'site_name' => config('app.name'),
            'site_email' => config('mail.from.address'),
            'max_upload_size' => ini_get('upload_max_filesize'),
            'timezone' => config('app.timezone'),
            'maintenance_mode' => app()->isDownForMaintenance(),
        ];

        return view('admin.settings.index', compact('settings', 'admin'));
    }

    /**
     * Update system settings
     */
    public function updateSystemSettings(Request $request)
    {
        $admin = $this->getAdmin();
        
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'timezone' => 'required|string',
            'maintenance_mode' => 'boolean',
        ]);

        // Here you would update your settings storage (database, config files, etc.)
        // This is a simplified example
        
        return back()->with('success', 'System settings updated successfully!');
    }

    /**
     * Generate reports
     */
    public function reports(Request $request)
    {
        $admin = $this->getAdmin();
        
        $reportType = $request->get('type', 'overview');
        
        $data = [];
        
        switch ($reportType) {
            case 'enrollments':
                $data = $this->getEnrollmentReportData($request);
                break;
            case 'courses':
                $data = $this->getCourseReportData($request);
                break;
            case 'trainers':
                $data = $this->getTrainerReportData($request);
                break;
            default:
                $data = $this->getOverviewReportData($request);
        }

        return view('admin.reports.index', compact('data', 'reportType', 'admin'));
    }

    /**
     * Get overview report data
     */
    private function getOverviewReportData($request)
    {
        return [
            'total_users' => User::count(),
            'total_trainers' => Trainer::count(),
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
            'monthly_enrollments' => Enrollment::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )->groupBy('month')
             ->orderBy('month')
             ->get(),
        ];
    }

    /**
     * Get enrollment report data
     */
    private function getEnrollmentReportData($request)
    {
        $query = Enrollment::query();
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return [
            'enrollments_by_status' => $query->select('status', DB::raw('COUNT(*) as count'))
                ->groupBy('status')->get(),
            'enrollments_by_course' => $query->with('course')
                ->select('course_id', DB::raw('COUNT(*) as count'))
                ->groupBy('course_id')
                ->having('count', '>', 0)
                ->orderBy('count', 'desc')
                ->take(10)
                ->get(),
        ];
    }

    /**
     * Get course report data
     */
    private function getCourseReportData($request)
    {
        return [
            'courses_by_category' => Course::select('category', DB::raw('COUNT(*) as count'))
                ->groupBy('category')->get(),
            'courses_by_status' => Course::select('status', DB::raw('COUNT(*) as count'))
                ->groupBy('status')->get(),
            'popular_courses' => Course::withCount('enrollments')
                ->orderBy('enrollments_count', 'desc')
                ->take(10)
                ->get(),
        ];
    }

    /**
     * Get trainer report data
     */
    private function getTrainerReportData($request)
    {
        return [
            'trainers_by_approval' => Trainer::select('is_approved', DB::raw('COUNT(*) as count'))
                ->groupBy('is_approved')->get(),
            'active_trainers' => Trainer::whereHas('courses', function($query) {
                $query->where('is_active', true);
            })->count(),
            'top_trainers' => Trainer::with('user')
                ->withCount('courses')
                ->orderBy('courses_count', 'desc')
                ->take(10)
                ->get(),
        ];
    }

    /**
     * Show admin profile
     */
    public function profile()
    {
        $admin = $this->getAdmin();
        return view('admin.profile', compact('admin'));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $admin = $this->getAdmin();
        $user = $admin->user;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }
}