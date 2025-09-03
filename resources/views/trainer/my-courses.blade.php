<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - Trainer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-black">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold text-white mb-2">My Courses</h1>
                <p class="text-gray-300">Manage and monitor your training courses</p>
            </div>
            <a href="{{ route('trainer.courses.create') }}" 
               class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create New Course
                </div>
            </a>
        </div>

        <!-- Courses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
                <div class="bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/20 hover:border-white/40 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                    <!-- Course Header -->
                    <div class="bg-gradient-to-r from-blue-500/20 to-purple-500/20 p-6 border-b border-white/10">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-xl font-bold text-white leading-tight">{{ $course->title }}</h3>
                            <div class="flex flex-col items-end space-y-2">
                                <span class="px-3 py-1 text-xs rounded-full font-medium {{ $course->is_active ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-gray-500/20 text-gray-400 border border-gray-500/30' }}">
                                    {{ $course->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if($course->is_featured)
                                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                        Featured
                                    </span>
                                @endif
                            </div>
                        </div>
                        <p class="text-gray-300 text-sm mb-4">{{ Str::limit($course->description, 120) }}</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">{{ ucfirst($course->category) }}</span>
                            <span class="text-white font-semibold">${{ number_format($course->price) }}</span>
                        </div>
                    </div>

                    <!-- Course Stats -->
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <!-- Enrollment Stats -->
                            <div class="bg-white/5 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-gray-400 text-sm">Enrollment</span>
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div class="text-white font-bold text-lg">{{ $course->approved_enrollments_count ?? 0 }}/{{ $course->max_participants }}</div>
                                <div class="w-full bg-gray-700 rounded-full h-2 mt-2">
                                    <div class="bg-blue-500 h-2 rounded-full" 
                                         style="width: {{ $course->max_participants > 0 ? (($course->approved_enrollments_count ?? 0) / $course->max_participants) * 100 : 0 }}%"></div>
                                </div>
                            </div>

                            <!-- Sessions Count -->
                            <div class="bg-white/5 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-gray-400 text-sm">Sessions</span>
                                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="text-white font-bold text-lg">{{ $course->total_sessions_count ?? 0 }}</div>
                                <div class="text-gray-400 text-xs mt-1">Total scheduled</div>
                            </div>
                        </div>

                        <!-- Course Details -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm text-gray-300">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Duration: {{ $course->duration_weeks }} weeks ({{ $course->duration_hours }}h)
                            </div>
                            <div class="flex items-center text-sm text-gray-300">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Level: {{ ucfirst($course->difficulty_level) }}
                            </div>
                            <div class="flex items-center text-sm text-gray-300">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Starts: {{ \Carbon\Carbon::parse($course->start_date)->format('M j, Y') }}
                            </div>
                        </div>

                        <!-- Recent Enrollments -->
                        @if($course->enrollments->count() > 0)
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-white mb-3">Recent Enrollments</h4>
                                <div class="space-y-2">
                                    @foreach($course->enrollments->take(3) as $enrollment)
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-300">{{ $enrollment->trainee_name }}</span>
                                            <span class="px-2 py-1 text-xs rounded-full {{ 
                                                $enrollment->status === 'approved' ? 'bg-green-500/20 text-green-400' : 
                                                ($enrollment->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') 
                                            }}">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                        </div>
                                    @endforeach
                                    @if($course->enrollments->count() > 3)
                                        <div class="text-xs text-gray-500 text-center">
                                            +{{ $course->enrollments->count() - 3 }} more enrollments
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('trainer.courses.edit', $course) }}" 
                               class="flex-1 bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 text-center py-2 px-3 rounded-lg text-sm font-medium transition-all duration-300">
                                Edit Course
                            </a>
                            <a href="{{ route('courses.show', $course->slug) }}" 
                               class="flex-1 bg-gray-500/20 hover:bg-gray-500/30 text-gray-300 text-center py-2 px-3 rounded-lg text-sm font-medium transition-all duration-300">
                                View Public
                            </a>
                        </div>
                        
                        <div class="flex gap-2 mt-2">
                            <a href="{{ route('trainer.trainees') }}?course_id={{ $course->id }}" 
                               class="flex-1 bg-green-500/20 hover:bg-green-500/30 text-green-400 text-center py-2 px-3 rounded-lg text-sm font-medium transition-all duration-300">
                                Manage Trainees
                            </a>
                            <a href="{{ route('trainer.sessions.index') }}?course_id={{ $course->id }}" 
                               class="flex-1 bg-purple-500/20 hover:bg-purple-500/30 text-purple-400 text-center py-2 px-3 rounded-lg text-sm font-medium transition-all duration-300">
                                Manage Sessions
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="text-center py-16 bg-white/5 rounded-2xl border border-white/10">
                        <div class="text-gray-500 mb-6">
                            <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">No courses created yet</h3>
                        <p class="text-gray-400 text-lg mb-8">Start building your training program by creating your first course.</p>
                        <a href="{{ route('trainer.courses.create') }}" 
                           class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create Your First Course
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($courses->hasPages())
            <div class="mt-12">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</body>
</html>