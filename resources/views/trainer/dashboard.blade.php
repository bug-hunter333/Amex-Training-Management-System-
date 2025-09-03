<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-black">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Trainer Dashboard</h1>
            <p class="text-gray-300">Welcome back, {{ auth()->user()->name ?? 'Trainer' }}! Manage your courses and trainees.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Courses -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:border-blue-400/50 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-300 text-sm font-medium">Total Courses</p>
                        <p class="text-3xl font-bold text-white">{{ $stats['total_courses'] ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-500/20 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Trainees -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:border-green-400/50 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-300 text-sm font-medium">Active Trainees</p>
                        <p class="text-3xl font-bold text-white">{{ $stats['total_trainees'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-500/20 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Sessions -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:border-purple-400/50 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-300 text-sm font-medium">Scheduled Sessions</p>
                        <p class="text-3xl font-bold text-white">{{ $stats['active_sessions'] ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-500/20 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Enrollments -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:border-yellow-400/50 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-300 text-sm font-medium">Pending Enrollments</p>
                        <p class="text-3xl font-bold text-white">{{ $stats['pending_enrollments'] ?? 0 }}</p>
                    </div>
                    <div class="bg-yellow-500/20 p-3 rounded-xl">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Create New Course -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('trainer.courses.create') }}" 
                       class="block bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create New Course
                        </div>
                    </a>
                    <a href="{{ route('trainer.sessions.create') }}" 
                       class="block bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-green-500/25">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Schedule Session
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Feedback -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-white">Recent Feedback</h3>
                    <a href="{{ route('trainer.feedback') }}" class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse($recentFeedback->take(3) as $feedback)
                        <div class="bg-white/5 rounded-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-300">{{ $feedback->course->title ?? 'N/A' }}</span>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= ($feedback->rating ?? 0) ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-gray-400">{{ Str::limit($feedback->feedback ?? 'No feedback provided', 100) }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No feedback received yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Sessions -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-white">Upcoming Sessions</h3>
                    <a href="{{ route('trainer.sessions.index') }}" class="text-blue-400 hover:text-blue-300 text-sm">Manage All</a>
                </div>
                <div class="space-y-3">
                    @forelse($upcomingSessions->take(3) as $session)
                        <div class="bg-white/5 rounded-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-white">{{ $session->title ?? 'Untitled Session' }}</span>
                                <span class="text-xs text-gray-400">{{ $session->course->title ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center text-xs text-gray-400">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ optional($session->session_date)->format('M j, Y g:i A') ?? 'Date not set' }}
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No upcoming sessions.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- My Courses -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-semibold text-white">My Courses</h3>
                <a href="{{ route('trainer.my-courses') }}" class="text-blue-400 hover:text-blue-300">View All</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($courses->take(6) as $course)
                    <div class="bg-white/5 rounded-lg p-4 border border-white/10 hover:border-white/30 transition-all duration-300">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-semibold text-white">{{ $course->title ?? 'Untitled Course' }}</h4>
                            <span class="px-2 py-1 text-xs rounded-full {{ ($course->is_active ?? false) ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                {{ ($course->is_active ?? false) ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-300">
                            <div>
                                <span class="text-gray-500">Enrolled:</span>
                                <div class="font-medium">{{ $course->approved_enrollments_count ?? 0 }}/{{ $course->max_participants ?? 0 }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500">Sessions:</span>
                                <div class="font-medium">{{ $course->sessions->count() ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('trainer.courses.edit', $course) }}" 
                               class="text-xs bg-blue-500/20 text-blue-400 px-3 py-1 rounded-md hover:bg-blue-500/30 transition-colors">
                                Edit
                            </a>
                            <a href="{{ route('courses.show', $course->slug ?? '#') }}" 
                               class="text-xs bg-gray-500/20 text-gray-400 px-3 py-1 rounded-md hover:bg-gray-500/30 transition-colors">
                                View
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <div class="text-gray-500 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-white mb-2">No courses yet</h4>
                        <p class="text-gray-400 mb-4">Create your first course to get started.</p>
                        <a href="{{ route('trainer.courses.create') }}" 
                           class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create Course
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>