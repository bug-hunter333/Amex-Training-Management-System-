<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\AdminController;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseFeedbackController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TrainerAuthController;

// ==============================================================================
// PUBLIC ROUTES
// ==============================================================================
Route::get('/home', function () {
    return view('home');
});
Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CoursesController::class, 'show'])->name('courses.show');

// ==============================================================================
// PROFILE ROUTES
// ==============================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/two-factor', [ProfileController::class, 'enableTwoFactorAuthentication'])->name('profile.two-factor.enable');
    Route::delete('/profile/two-factor', [ProfileController::class, 'disableTwoFactorAuthentication'])->name('profile.two-factor.disable');
    Route::post('/profile/sessions', [ProfileController::class, 'destroySessions'])->name('profile.sessions.destroy');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================================================================
// ENROLLMENT ROUTES
// ==============================================================================
Route::prefix('enrollment')->name('enrollment.')->group(function () {
    Route::get('/course/{course}', [EnrollmentController::class, 'create'])->name('create');
    Route::post('/store', [EnrollmentController::class, 'store'])->name('store');
    Route::get('/success/{enrollment}', [EnrollmentController::class, 'success'])->name('success');
    Route::get('/details/{enrollment}', [EnrollmentController::class, 'show'])->name('show');
});

// Alternative routes for easier access
Route::get('/enroll/{course}', [EnrollmentController::class, 'create'])->name('courses.enroll');
Route::get('/enrollments/success/{enrollment}', [EnrollmentController::class, 'success'])->name('enrollments.success');

// ==============================================================================
// TRAINEE DASHBOARD ROUTES
// ==============================================================================
Route::middleware(['auth'])->prefix('trainee')->name('trainee.')->group(function () {
    Route::get('/dashboard', [TraineeController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-courses', [TraineeController::class, 'myCourses'])->name('my-courses');
    Route::post('/activate-course', [TraineeController::class, 'activateCourse'])->name('activate-course');
    Route::post('/activate-course-ajax', [TraineeController::class, 'activateCourseAjax'])->name('activate-course-ajax');
    Route::get('/course/{enrollment}', [TraineeController::class, 'showCourse'])->name('show-course');
    Route::get('/course/{enrollment}/access', [TraineeController::class, 'accessCourse'])->name('access-course');
    Route::get('/browse-courses', [TraineeController::class, 'browseCourses'])->name('browse-courses');
    
    // Course Feedback API Routes
    Route::post('/api/course-feedback', [TraineeController::class, 'storeFeedback'])->name('api.store-feedback');
    Route::get('/api/course-feedback/{courseId}', [TraineeController::class, 'getFeedback'])->name('api.get-feedback');
    Route::delete('/api/course-feedback/{courseId}', [TraineeController::class, 'deleteFeedback'])->name('api.delete-feedback');
});

// ==============================================================================
// COURSE ACCESS ROUTES (UPDATED)
// ==============================================================================
Route::middleware(['auth'])->group(function () {
    // Redirect old course access route to new trainee routes
    Route::get('/course/{enrollment}/access', function($enrollment) {
        return redirect()->route('trainee.access-course', $enrollment);
    })->name('course.dedicated');
    
    // Redirect old my-courses route to new trainee route
    Route::get('/my-courses', function() {
        return redirect()->route('trainee.my-courses');
    })->name('my-courses');
});

// ==============================================================================
// ADMIN ROUTES - COMPREHENSIVE MANAGEMENT SYSTEM
// ==============================================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'manageUsers'])->name('index');
        Route::get('/create', [AdminController::class, 'createUser'])->name('create');
        Route::post('/', [AdminController::class, 'storeUser'])->name('store');
        Route::get('/{user}/edit', [AdminController::class, 'editUser'])->name('edit');
        Route::put('/{user}', [AdminController::class, 'updateUser'])->name('update');
        Route::patch('/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('toggle-status');
        Route::delete('/{user}', [AdminController::class, 'destroyUser'])->name('destroy');
    });
    
    // Course Management
    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/', [AdminController::class, 'manageCourses'])->name('index');
        Route::get('/{course}', [AdminController::class, 'showCourse'])->name('show');
        Route::patch('/{course}/toggle-status', [AdminController::class, 'toggleCourseStatus'])->name('toggle-status');
        Route::patch('/{course}/update-status', [AdminController::class, 'updateCourseStatus'])->name('update-status');
    });
    
    // Trainer Management
    Route::prefix('trainers')->name('trainers.')->group(function () {
        Route::get('/', [AdminController::class, 'manageTrainers'])->name('index');
        Route::get('/{trainer}', [AdminController::class, 'showTrainer'])->name('show');
        Route::patch('/{trainer}/update-status', [AdminController::class, 'updateTrainerStatus'])->name('update-status');
    });
    
    // Enrollment Management (Enhanced)
    Route::prefix('enrollments')->name('enrollments.')->group(function () {
        Route::get('/', [AdminController::class, 'manageEnrollments'])->name('index');
        Route::get('/{enrollment}', [EnrollmentController::class, 'show'])->name('show');
        Route::patch('/{enrollment}/status', [EnrollmentController::class, 'updateStatus'])->name('updateStatus');
        Route::patch('/{enrollment}/update-status', [AdminController::class, 'updateEnrollmentStatus'])->name('update-status');
        Route::delete('/{enrollment}', [EnrollmentController::class, 'destroy'])->name('destroy');
        
        // Approval/Rejection routes
        Route::get('/{enrollment}/approve', function (Enrollment $enrollment) {
            $enrollment->approve();
            return redirect()->route('admin.enrollments.show', $enrollment)
                ->with('success', 'Enrollment approved successfully!');
        })->name('approve');

        Route::get('/{enrollment}/reject', function (Enrollment $enrollment) {
            $enrollment->reject();
            return redirect()->route('admin.enrollments.show', $enrollment)
                ->with('success', 'Enrollment rejected successfully!');
        })->name('reject');
    });
    
    // Course Feedback Management (Enhanced)
    Route::prefix('course-feedbacks')->name('course-feedbacks.')->group(function () {
        Route::get('/', [CourseFeedbackController::class, 'adminIndex'])->name('index');
        Route::get('/{feedback}', [CourseFeedbackController::class, 'adminShow'])->name('show');
        Route::post('/{feedbackId}/status', [CourseFeedbackController::class, 'updateStatus'])->name('update-status');
        Route::post('/respond', [CourseFeedbackController::class, 'respond'])->name('respond');
        Route::delete('/{feedbackId}', [CourseFeedbackController::class, 'destroy'])->name('delete');
        Route::patch('/{feedback}/approve', [CourseFeedbackController::class, 'approve'])->name('approve');
        Route::patch('/{feedback}/reject', [CourseFeedbackController::class, 'reject'])->name('reject');
        Route::post('/bulk-action', [CourseFeedbackController::class, 'bulkAction'])->name('bulk-action');
        Route::get('/export/{course?}', [CourseFeedbackController::class, 'export'])->name('export');
    });
    
    // General Feedback Management
    Route::prefix('feedback')->name('feedback.')->group(function () {
        Route::get('/', [AdminController::class, 'manageFeedback'])->name('index');
    });
    
    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    
    // System Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [AdminController::class, 'systemSettings'])->name('index');
        Route::put('/', [AdminController::class, 'updateSystemSettings'])->name('update');
    });
    
    // Admin Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [AdminController::class, 'profile'])->name('show');
        Route::put('/', [AdminController::class, 'updateProfile'])->name('update');
    });
});

// ==============================================================================
// EMAIL TESTING ROUTES
// ==============================================================================
Route::get('/debug-gmail-smtp', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('Test email from TMS at ' . now(), function ($message) {
            $message->to('miyulasbandara@gmail.com')
                    ->subject('TMS Test - ' . now()->format('H:i:s'))
                    ->from('amextms2025@gmail.com', 'TMS Training');
        });
        return '✅ Test email sent to miyulasbandara@gmail.com - Check your inbox and spam folder!';
    } catch (Exception $e) {
        return '❌ Email failed: ' . $e->getMessage();
    }
});

// ==============================================================================
// MAIN DASHBOARD ROUTES
// ==============================================================================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('/dashboard.index');
    })->name('dashboard');
});

// ==============================================================================
// COURSE FEEDBACK ROUTES
// ==============================================================================
Route::middleware(['auth'])->group(function () {
    Route::prefix('course-feedback')->name('course-feedback.')->group(function () {
        Route::get('/create/{enrollment}', [CourseFeedbackController::class, 'create'])->name('create');
        Route::post('/{enrollment}', [CourseFeedbackController::class, 'store'])->name('store');
        Route::get('/user/{enrollment}', [CourseFeedbackController::class, 'getUserFeedback'])->name('user');
        Route::get('/course/{course}', [CourseFeedbackController::class, 'show'])->name('show');
        Route::delete('/{feedback}', [CourseFeedbackController::class, 'destroy'])->name('destroy');
    });
});

// ==============================================================================
// TRAINER AUTHENTICATION ROUTES
// ==============================================================================
Route::prefix('trainer')->name('trainer.')->group(function () {
    // Guest routes (not authenticated)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [TrainerAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [TrainerAuthController::class, 'login'])->name('auth.login');
    });
    
    // Authenticated trainer routes
    Route::middleware('trainer')->group(function () {
        Route::post('/logout', [TrainerAuthController::class, 'logout'])->name('logout');
    });
});

// Update existing trainer routes to use the trainer middleware
Route::middleware(['auth', 'trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [TrainerController::class, 'dashboard'])->name('dashboard');
    
    // Course Management
    Route::get('/my-courses', [TrainerController::class, 'myCourses'])->name('my-courses');
    Route::get('/courses/create', [TrainerController::class, 'createCourse'])->name('courses.create');
    Route::post('/courses', [TrainerController::class, 'storeCourse'])->name('courses.store');
    Route::get('/courses/{course}/edit', [TrainerController::class, 'editCourse'])->name('courses.edit');
    Route::put('/courses/{course}', [TrainerController::class, 'updateCourse'])->name('courses.update');
    Route::delete('/courses/{course}', [TrainerController::class, 'deleteCourse'])->name('courses.delete');
    
    // Session Management - COMPLETE SET
    Route::get('/sessions', [TrainerController::class, 'manageSessions'])->name('sessions.index');
    Route::get('/sessions/create', [TrainerController::class, 'createSession'])->name('sessions.create');
    Route::post('/sessions', [TrainerController::class, 'storeSession'])->name('sessions.store');
    Route::get('/sessions/{session}/edit', [TrainerController::class, 'editSession'])->name('sessions.edit');
    Route::put('/sessions/{session}', [TrainerController::class, 'updateSession'])->name('sessions.update');
    Route::patch('/sessions/{session}/cancel', [TrainerController::class, 'cancelSession'])->name('sessions.cancel');
    Route::patch('/sessions/{session}/start', [TrainerController::class, 'startSession'])->name('sessions.start');
    Route::patch('/sessions/{session}/complete', [TrainerController::class, 'completeSession'])->name('sessions.complete');
    Route::delete('/sessions/{session}', [TrainerController::class, 'destroySession'])->name('sessions.destroy');
    
    // Trainee Management
    Route::get('/trainees', [TrainerController::class, 'assignedTrainees'])->name('trainees');
    Route::patch('/trainees/{enrollment}/status', [TrainerController::class, 'updateTraineeStatus'])->name('trainees.update-status');
    Route::delete('/trainees/{enrollment}', [TrainerController::class, 'removeTrainee'])->name('trainees.remove');
    
    // Feedback Management
    Route::get('/feedback', [TrainerController::class, 'viewFeedback'])->name('feedback');
    
    // AJAX Routes
    Route::get('/api/courses', [TrainerController::class, 'getTrainerCourses'])->name('api.courses');
});