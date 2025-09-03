<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = DB::table('courses')
            ->where('is_active', true)
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Decode JSON fields with proper array conversion
        $courses = $courses->map(function ($course) {
            $course->prerequisites = $this->safeJsonDecode($course->prerequisites);
            $course->learning_objectives = $this->safeJsonDecode($course->learning_objectives);
            $course->schedule = $this->safeJsonDecode($course->schedule);
            $course->materials = $this->safeJsonDecode($course->materials);
            $course->resources = $this->safeJsonDecode($course->resources);
            $course->tags = $this->safeJsonDecode($course->tags);
            $course->target_departments = $this->safeJsonDecode($course->target_departments);
            $course->target_roles = $this->safeJsonDecode($course->target_roles);
            $course->target_levels = $this->safeJsonDecode($course->target_levels);
            
            return $course;
        });

        return view('courses.index', compact('courses'));
    }

    public function show($slug)
    {
        $course = DB::table('courses')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$course) {
            abort(404);
        }

        // Decode JSON fields with proper array conversion
        $course->prerequisites = $this->safeJsonDecode($course->prerequisites);
        $course->learning_objectives = $this->safeJsonDecode($course->learning_objectives);
        $course->schedule = $this->safeJsonDecode($course->schedule);
        $course->materials = $this->safeJsonDecode($course->materials);
        $course->resources = $this->safeJsonDecode($course->resources);
        $course->tags = $this->safeJsonDecode($course->tags);
        $course->target_departments = $this->safeJsonDecode($course->target_departments);
        $course->target_roles = $this->safeJsonDecode($course->target_roles);
        $course->target_levels = $this->safeJsonDecode($course->target_levels);

        return view('courses.show', compact('course'));
    }

    /**
     * Safely decode JSON and ensure it returns an array
     */
    private function safeJsonDecode($value)
    {
        if (is_null($value) || $value === '') {
            return [];
        }
        
        $decoded = json_decode($value, true);
        
        // If json_decode returns null and it's not a JSON null, return empty array
        if ($decoded === null && $value !== 'null') {
            return [];
        }
        
        // If it's a string, wrap it in an array
        if (is_string($decoded)) {
            return [$decoded];
        }
        
        // If it's not an array, return empty array
        if (!is_array($decoded)) {
            return [];
        }
        
        return $decoded;
    }
}