<?php

namespace App\Http\Controllers;

use App\Models\CourseFeedback;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CourseFeedbackRequest;
use Illuminate\Support\Facades\DB;

class CourseFeedbackController extends Controller
{
    /**
     * Display feedback form
     */
    public function create(Request $request, $enrollmentId)
    {
        $enrollment = Enrollment::with('course')->findOrFail($enrollmentId);
        
        // Check if user is enrolled and authorized
        if ($enrollment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this enrollment.');
        }

        // Check if feedback already exists
        $existingFeedback = CourseFeedback::where('user_id', Auth::id())
            ->where('course_id', $enrollment->course_id)
            ->first();

        return response()->json([
            'enrollment' => $enrollment,
            'existing_feedback' => $existingFeedback,
            'can_submit' => !$existingFeedback || $existingFeedback->canBeEdited()
        ]);
    }

    /**
     * Store or update course feedback using Form Request validation
     */
    public function store(CourseFeedbackRequest $request, $enrollmentId): JsonResponse
    {
        $enrollment = Enrollment::with('course', 'user')->findOrFail($enrollmentId);
        
        // Check if user is authorized
        if ($enrollment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        try {
            // Check for existing feedback
            $existingFeedback = CourseFeedback::where('user_id', Auth::id())
                ->where('course_id', $enrollment->course_id)
                ->first();

            if ($existingFeedback && !$existingFeedback->canBeEdited()) {
                return response()->json([
                    'error' => 'Feedback cannot be modified at this time.'
                ], 422);
            }

            $feedbackData = [
                'user_id' => Auth::id(),
                'course_id' => $enrollment->course_id,
                'enrollment_id' => $enrollment->id,
                'username' => $enrollment->user->name,
                'email' => $enrollment->user->email,
                'rating' => $request->validated()['rating'],
                'feedback' => $request->validated()['feedback'],
                'categories' => $request->validated()['categories'] ?? [],
                'is_anonymous' => $request->validated()['is_anonymous'] ?? false,
                'status' => 'pending'
            ];

            if ($existingFeedback) {
                // Update existing feedback
                $existingFeedback->update($feedbackData);
                $feedback = $existingFeedback;
                $message = 'Your feedback has been updated successfully!';
            } else {
                // Create new feedback
                $feedback = CourseFeedback::create($feedbackData);
                $message = 'Thank you for your feedback! It will be reviewed before being published.';
            }

            // Update course average rating
            $this->updateCourseRating($enrollment->course_id);

            return response()->json([
                'success' => true,
                'message' => $message,
                'feedback' => $feedback,
                'can_edit' => $feedback->canBeEdited()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while submitting your feedback. Please try again.'
            ], 500);
        }
    }

    /**
     * Show feedback for a course
     */
    public function show($courseId): JsonResponse
    {
        $course = Course::findOrFail($courseId);
        
        $feedbacks = CourseFeedback::with('user')
            ->where('course_id', $courseId)
            ->approved()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'average_rating' => CourseFeedback::where('course_id', $courseId)
                ->approved()
                ->avg('rating'),
            'total_feedbacks' => CourseFeedback::where('course_id', $courseId)
                ->approved()
                ->count(),
            'rating_distribution' => CourseFeedback::where('course_id', $courseId)
                ->approved()
                ->selectRaw('rating, COUNT(*) as count')
                ->groupBy('rating')
                ->pluck('count', 'rating')
                ->toArray()
        ];

        return response()->json([
            'course' => $course,
            'feedbacks' => $feedbacks,
            'stats' => $stats
        ]);
    }

    /**
     * Delete feedback
     */
    public function destroy($feedbackId): JsonResponse
    {
        $feedback = CourseFeedback::findOrFail($feedbackId);
        
        // Check if user owns the feedback
        if ($feedback->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        if (!$feedback->canBeEdited()) {
            return response()->json([
                'error' => 'Feedback cannot be deleted at this time.'
            ], 422);
        }

        $courseId = $feedback->course_id;
        $feedback->delete();

        // Update course rating
        $this->updateCourseRating($courseId);

        return response()->json([
            'success' => true,
            'message' => 'Feedback deleted successfully.'
        ]);
    }

    /**
     * Get user's feedback for a specific course
     */
    public function getUserFeedback($enrollmentId): JsonResponse
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);
        
        if ($enrollment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        $feedback = CourseFeedback::where('user_id', Auth::id())
            ->where('course_id', $enrollment->course_id)
            ->first();

        return response()->json([
            'feedback' => $feedback,
            'can_submit' => !$feedback,
            'can_edit' => $feedback ? $feedback->canBeEdited() : false
        ]);
    }

    /**
     * Update course average rating
     */
    private function updateCourseRating($courseId): void
    {
        $course = Course::find($courseId);
        if (!$course) return;

        $approvedFeedbacks = CourseFeedback::where('course_id', $courseId)
            ->approved();

        $averageRating = $approvedFeedbacks->avg('rating') ?: 0;
        $totalReviews = $approvedFeedbacks->count();

        $course->update([
            'average_rating' => round($averageRating, 2),
            'total_reviews' => $totalReviews
        ]);
    }

    /**
     * Admin: Display all feedbacks with filters
     */
    public function adminIndex(Request $request)
    {
        $query = CourseFeedback::with(['user', 'course', 'enrollment'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('course_id') && $request->course_id !== '') {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('rating') && $request->rating !== '') {
            $query->where('rating', $request->rating);
        }

        if ($request->has('anonymous')) {
            $query->where('is_anonymous', $request->boolean('anonymous'));
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('feedback', 'LIKE', "%{$search}%")
                  ->orWhere('username', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhereHas('course', function ($courseQuery) use ($search) {
                      $courseQuery->where('title', 'LIKE', "%{$search}%");
                  });
            });
        }

        $feedbacks = $query->paginate(20);

        // Get statistics
        $stats = [
            'total' => CourseFeedback::count(),
            'pending' => CourseFeedback::pending()->count(),
            'approved' => CourseFeedback::approved()->count(),
            'rejected' => CourseFeedback::rejected()->count(),
            'average_rating' => CourseFeedback::approved()->avg('rating'),
        ];

        // Get courses for filter dropdown
        $courses = Course::select('id', 'title')->orderBy('title')->get();

        if ($request->expectsJson()) {
            return response()->json([
                'feedbacks' => $feedbacks,
                'stats' => $stats,
                'courses' => $courses
            ]);
        }

        return view('admin.course-feedbacks.index', compact('feedbacks', 'stats', 'courses'));
    }

    /**
     * Admin: Show specific feedback
     */
    public function adminShow(CourseFeedback $feedback)
    {
        $feedback->load(['user', 'course', 'enrollment']);
        
        return response()->json(['feedback' => $feedback]);
    }

    /**
     * Admin: Approve feedback
     */
    public function approve(CourseFeedback $feedback, Request $request)
    {
        $request->validate([
            'admin_response' => 'nullable|string|max:500'
        ]);

        $feedback->update([
            'status' => 'approved',
            'admin_response' => $request->input('admin_response')
        ]);

        // Update course rating
        $this->updateCourseRating($feedback->course_id);

        return response()->json([
            'success' => true,
            'message' => 'Feedback has been approved successfully.',
            'feedback' => $feedback
        ]);
    }

    /**
     * Admin: Reject feedback
     */
    public function reject(CourseFeedback $feedback, Request $request)
    {
        $request->validate([
            'admin_response' => 'required|string|max:500'
        ]);

        $feedback->update([
            'status' => 'rejected',
            'admin_response' => $request->input('admin_response')
        ]);

        // Update course rating (exclude rejected feedback)
        $this->updateCourseRating($feedback->course_id);

        return response()->json([
            'success' => true,
            'message' => 'Feedback has been rejected.',
            'feedback' => $feedback
        ]);
    }

    /**
     * Admin: Add response to feedback
     */
    public function respond(CourseFeedback $feedback, Request $request)
    {
        $request->validate([
            'admin_response' => 'required|string|max:500'
        ]);

        $feedback->update([
            'admin_response' => $request->input('admin_response')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Response has been added to the feedback.',
            'feedback' => $feedback
        ]);
    }

    /**
     * Admin: Bulk actions on feedbacks
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'feedback_ids' => 'required|array|min:1',
            'feedback_ids.*' => 'exists:course_feedbacks,id',
            'admin_response' => 'nullable|string|max:500'
        ]);

        $feedbackIds = $request->input('feedback_ids');
        $action = $request->input('action');
        $adminResponse = $request->input('admin_response');

        DB::beginTransaction();

        try {
            $updatedCount = 0;
            $courseIds = [];

            switch ($action) {
                case 'approve':
                    $updatedCount = CourseFeedback::whereIn('id', $feedbackIds)
                        ->update([
                            'status' => 'approved',
                            'admin_response' => $adminResponse
                        ]);
                    
                    // Collect course IDs for rating update
                    $courseIds = CourseFeedback::whereIn('id', $feedbackIds)
                        ->pluck('course_id')
                        ->unique()
                        ->toArray();
                    break;

                case 'reject':
                    if (!$adminResponse) {
                        return response()->json([
                            'error' => 'Admin response is required when rejecting feedback.'
                        ], 422);
                    }

                    $updatedCount = CourseFeedback::whereIn('id', $feedbackIds)
                        ->update([
                            'status' => 'rejected',
                            'admin_response' => $adminResponse
                        ]);

                    // Collect course IDs for rating update
                    $courseIds = CourseFeedback::whereIn('id', $feedbackIds)
                        ->pluck('course_id')
                        ->unique()
                        ->toArray();
                    break;

                case 'delete':
                    // Get course IDs before deletion
                    $courseIds = CourseFeedback::whereIn('id', $feedbackIds)
                        ->pluck('course_id')
                        ->unique()
                        ->toArray();

                    $updatedCount = CourseFeedback::whereIn('id', $feedbackIds)->delete();
                    break;
            }

            // Update course ratings for affected courses
            foreach ($courseIds as $courseId) {
                $this->updateCourseRating($courseId);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully {$action}ed {$updatedCount} feedback(s).",
                'updated_count' => $updatedCount
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'error' => 'An error occurred while processing the bulk action.'
            ], 500);
        }
    }

    /**
     * Admin: Export feedbacks to CSV
     */
    public function export(Request $request, $courseId = null)
    {
        $query = CourseFeedback::with(['user', 'course', 'enrollment']);

        // Apply course filter if specified
        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        // Apply additional filters from request
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->get();

        $filename = 'course_feedbacks_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($feedbacks) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'ID',
                'Course Title',
                'Student Name',
                'Student Email',
                'Rating',
                'Feedback',
                'Categories',
                'Anonymous',
                'Status',
                'Admin Response',
                'Submitted Date',
                'Updated Date'
            ]);

            // CSV Rows
            foreach ($feedbacks as $feedback) {
                fputcsv($file, [
                    $feedback->id,
                    $feedback->course->title ?? 'N/A',
                    $feedback->is_anonymous ? 'Anonymous' : $feedback->username,
                    $feedback->is_anonymous ? 'Anonymous' : $feedback->email,
                    $feedback->rating,
                    $feedback->feedback,
                    is_array($feedback->categories) ? implode(', ', $feedback->categories) : '',
                    $feedback->is_anonymous ? 'Yes' : 'No',
                    ucfirst($feedback->status),
                    $feedback->admin_response ?? '',
                    $feedback->created_at->format('Y-m-d H:i:s'),
                    $feedback->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}