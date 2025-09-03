<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SessionController extends Controller
{
    /**
     * Display a listing of sessions for the trainer
     */
    public function index()
    {
        $trainer = Auth::user();
        
        $sessions = Session::whereHas('course', function($query) use ($trainer) {
            $query->where('trainer_id', $trainer->id);
        })->with('course')
          ->orderBy('session_date', 'desc')
          ->paginate(15);

        // Get statistics for the dashboard
        $stats = [
            'total_sessions' => Session::whereHas('course', function($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id);
            })->count(),
            
            'scheduled_sessions' => Session::whereHas('course', function($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id);
            })->where('status', 'scheduled')->count(),
            
            'completed_sessions' => Session::whereHas('course', function($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id);
            })->where('status', 'completed')->count(),
            
            'upcoming_sessions' => Session::whereHas('course', function($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id);
            })->where('session_date', '>=', now())
              ->where('status', '!=', 'cancelled')
              ->count(),
        ];

        return view('trainer.sessions.index', compact('sessions', 'stats'));
    }

    /**
     * Show the form for creating a new session
     */
    public function create()
    {
        $trainer = Auth::user();
        $courses = Course::where('trainer_id', $trainer->id)
                        ->where('is_active', true)
                        ->orderBy('title')
                        ->get();

        if ($courses->isEmpty()) {
            return redirect()->route('trainer.sessions.index')
                           ->with('error', 'You need to create at least one active course before adding sessions.');
        }

        return view('trainer.sessions.create', compact('courses'));
    }

    /**
     * Store a newly created session
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'topic' => 'nullable|string|max:255',
            'session_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'meeting_link' => 'nullable|url|max:500',
            'session_type' => 'required|in:live,recorded,assignment,quiz',
            'materials' => 'nullable|array',
            'materials.*' => 'string|max:500',
            'notes' => 'nullable|string',
        ]);

        // Verify trainer owns the course
        $course = Course::findOrFail($validated['course_id']);
        if ($course->trainer_id !== Auth::id()) {
            abort(403, 'You can only create sessions for your own courses.');
        }

        // Filter out empty materials
        if (isset($validated['materials'])) {
            $validated['materials'] = array_filter($validated['materials'], function($material) {
                return !empty(trim($material));
            });
        }

        Session::create($validated);

        return redirect()->route('trainer.sessions.index')
                       ->with('success', 'Session created successfully!');
    }

    /**
     * Show the form for editing a session
     */
    public function edit(Session $session)
    {
        // Verify trainer owns the course
        if ($session->course->trainer_id !== Auth::id()) {
            abort(403, 'You can only edit sessions for your own courses.');
        }

        $trainer = Auth::user();
        $courses = Course::where('trainer_id', $trainer->id)
                        ->where('is_active', true)
                        ->orderBy('title')
                        ->get();

        return view('trainer.sessions.edit', compact('session', 'courses'));
    }

    /**
     * Update the specified session
     */
    public function update(Request $request, Session $session)
    {
        // Verify trainer owns the course
        if ($session->course->trainer_id !== Auth::id()) {
            abort(403, 'You can only update sessions for your own courses.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'topic' => 'nullable|string|max:255',
            'session_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'meeting_link' => 'nullable|url|max:500',
            'session_type' => 'required|in:live,recorded,assignment,quiz',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'materials' => 'nullable|array',
            'materials.*' => 'string|max:500',
            'notes' => 'nullable|string',
        ]);

        // Filter out empty materials
        if (isset($validated['materials'])) {
            $validated['materials'] = array_filter($validated['materials'], function($material) {
                return !empty(trim($material));
            });
        }

        $session->update($validated);

        return redirect()->route('trainer.sessions.index')
                       ->with('success', 'Session updated successfully!');
    }

    /**
     * Cancel a session
     */
    public function cancel(Session $session)
    {
        // Verify trainer owns the course
        if ($session->course->trainer_id !== Auth::id()) {
            abort(403, 'You can only cancel sessions for your own courses.');
        }

        $session->update(['status' => 'cancelled']);

        return back()->with('success', 'Session cancelled successfully!');
    }

    /**
     * Complete a session
     */
    public function complete(Session $session)
    {
        // Verify trainer owns the course
        if ($session->course->trainer_id !== Auth::id()) {
            abort(403, 'You can only complete sessions for your own courses.');
        }

        $session->update(['status' => 'completed']);

        return back()->with('success', 'Session marked as completed!');
    }

    /**
     * Start a session
     */
    public function start(Session $session)
    {
        // Verify trainer owns the course
        if ($session->course->trainer_id !== Auth::id()) {
            abort(403, 'You can only start sessions for your own courses.');
        }

        $session->update(['status' => 'ongoing']);

        return back()->with('success', 'Session started successfully!');
    }

    /**
     * Delete a session
     */
    public function destroy(Session $session)
    {
        // Verify trainer owns the course
        if ($session->course->trainer_id !== Auth::id()) {
            abort(403, 'You can only delete sessions for your own courses.');
        }

        $session->delete();

        return back()->with('success', 'Session deleted successfully!');
    }
}