<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $enrollment->course->title }} - Course Access</title>
    <meta name="description" content="{{ $enrollment->course->meta_description ?? $enrollment->course->description }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#1e40af',
                    }
                }
            }
        }
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gray-800 border-b border-gray-700 px-6 py-4">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center space-x-4">
                <a href="{{ route('trainee.my-courses') }}" class="text-gray-300 hover:text-white transition-colors">
                    ← Back to My Courses
                </a>
                <div class="h-6 w-px bg-gray-600"></div>
                <h1 class="text-xl font-semibold">{{ $enrollment->course->title }}</h1>
                @if($enrollment->course->is_mandatory)
                    <span class="bg-red-600 px-2 py-1 rounded text-xs font-medium">MANDATORY</span>
                @endif
                @if($enrollment->course->is_featured)
                    <span class="bg-yellow-600 px-2 py-1 rounded text-xs font-medium">FEATURED</span>
                @endif
            </div>
            <div class="flex items-center space-x-4">
                <span class="bg-green-600 px-3 py-1 rounded-full text-sm font-medium">{{ ucfirst($enrollment->status) }}</span>
                <span class="text-gray-400">ID: {{ $enrollment->reference_id }}</span>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Course Overview -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <div class="flex items-start justify-between mb-4">
                        <h2 class="text-2xl font-bold">Course Overview</h2>
                        <div class="flex items-center space-x-2">
                            <div class="flex text-yellow-400">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 {{ $i < floor($enrollment->course->average_rating) ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.46,13.97L5.82,21L12,17.27Z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-400">{{ number_format($enrollment->course->average_rating, 1) }}/5 ({{ $enrollment->course->total_reviews }} reviews)</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-blue-600 px-3 py-1 rounded-full text-sm">{{ ucfirst($enrollment->course->category) }}</span>
                        <span class="bg-purple-600 px-3 py-1 rounded-full text-sm">{{ ucfirst(str_replace('_', ' ', $enrollment->course->course_type)) }}</span>
                        <span class="bg-green-600 px-3 py-1 rounded-full text-sm">{{ ucfirst(str_replace('_', ' ', $enrollment->course->difficulty_level)) }}</span>
                        <span class="bg-orange-600 px-3 py-1 rounded-full text-sm">{{ ucfirst(str_replace('_', ' ', $enrollment->course->certificate_type)) }}</span>
                    </div>

                    <p class="text-gray-300 mb-6">{{ $enrollment->course->description }}</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center p-4 bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-primary">{{ $enrollment->course->duration_weeks }}</div>
                            <div class="text-sm text-gray-400">Weeks</div>
                        </div>
                        <div class="text-center p-4 bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-primary">{{ $enrollment->course->duration_hours }}</div>
                            <div class="text-sm text-gray-400">Hours</div>
                        </div>
                        <div class="text-center p-4 bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-primary">{{ ($upcomingSessions ?? collect())->count() + ($pastSessions ?? collect())->count() }}</div>
                            <div class="text-sm text-gray-400">Sessions</div>
                        </div>
                        <div class="text-center p-4 bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-green-500">{{ $enrollment->progress ?? 0 }}%</div>
                            <div class="text-sm text-gray-400">Progress</div>
                        </div>
                    </div>

                    <!-- Course Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-600">
                        <div>
                            <h4 class="font-semibold mb-3">Course Information</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Start Date:</span>
                                    <span>{{ \Carbon\Carbon::parse($enrollment->course->start_date)->format('M j, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">End Date:</span>
                                    <span>{{ \Carbon\Carbon::parse($enrollment->course->end_date)->format('M j, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Venue:</span>
                                    <span>{{ ucfirst(str_replace('_', ' ', $enrollment->course->venue_type)) }}</span>
                                </div>
                                @if($enrollment->course->venue_type === 'physical' && $enrollment->course->venue_name)
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">Location:</span>
                                        <span>{{ $enrollment->course->venue_name }}</span>
                                    </div>
                                @endif
                                @if($enrollment->course->venue_type === 'online' && $enrollment->course->online_platform)
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">Platform:</span>
                                        <span>{{ $enrollment->course->online_platform }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Timezone:</span>
                                    <span>{{ $enrollment->course->timezone }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-3">Enrollment Stats</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Enrolled:</span>
                                    <span>{{ $enrollment->course->enrollment_count }}/{{ $enrollment->course->max_participants }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Completed:</span>
                                    <span>{{ $enrollment->course->completion_count }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Views:</span>
                                    <span>{{ number_format($enrollment->course->view_count) }}</span>
                                </div>
                                <div class="w-full bg-gray-600 rounded-full h-2 mt-3">
                                    <div class="bg-primary h-2 rounded-full" style="width: {{ ($enrollment->course->enrollment_count / $enrollment->course->max_participants) * 100 }}%"></div>
                                </div>
                                <div class="text-xs text-gray-400 text-center">Enrollment Progress</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Learning Objectives -->
              @if($enrollment->course->learning_objectives && count($enrollment->course->learning_objectives) > 0)
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h2 class="text-xl font-bold mb-4">Learning Objectives</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($enrollment->course->learning_objectives as $objective)
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-300">{{ $objective }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

               <!-- Prerequisites -->
@if($enrollment->course->prerequisites && count($enrollment->course->prerequisites) > 0)
<div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
    <h2 class="text-xl font-bold mb-4">Prerequisites</h2>
    <div class="space-y-2">
        @foreach($enrollment->course->prerequisites as $prerequisite)
        <div class="flex items-center space-x-3">
            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
            <p class="text-gray-300">{{ $prerequisite }}</p>
        </div>
        @endforeach
    </div>
</div>
@endif

                <!-- Course Outline -->
                @if($enrollment->course->course_outline)
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h2 class="text-xl font-bold mb-4">Course Outline</h2>
                    <div class="prose prose-invert max-w-none">
                        <div class="text-gray-300 whitespace-pre-line">{{ $enrollment->course->course_outline }}</div>
                    </div>
                </div>
                @endif

                <!-- Upcoming Sessions -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold">Upcoming Sessions</h2>
                        <span class="text-sm text-gray-400">{{ ($upcomingSessions ?? collect())->count() }} sessions scheduled</span>
                    </div>
                    
                    @if(($upcomingSessions ?? collect())->count() > 0)
                        <div class="space-y-4">
                            @foreach(($upcomingSessions ?? collect()) as $session)
                            <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">{{ $session->topic ?? $session->title ?? 'Session ' . $loop->iteration }}</h3>
                                        <p class="text-sm text-gray-400">{{ $session->session_date->format('l, F j, Y') }}</p>
                                        <p class="text-sm text-gray-400">{{ $session->session_date->format('g:i A') }} - {{ $session->session_date->addHours(2)->format('g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    @if($session->isPast())
                                        <span class="bg-gray-600 px-3 py-1 rounded-full text-xs">Completed</span>
                                        @if($session->recording_link)
                                            <a href="{{ $session->recording_link }}" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-sm transition-colors" target="_blank">
                                                View Recording
                                            </a>
                                        @else
                                            <span class="bg-gray-600 px-4 py-2 rounded-lg text-sm">Recording N/A</span>
                                        @endif
                                    @elseif($session->isToday())
                                        <span class="bg-red-600 px-3 py-1 rounded-full text-xs">Today</span>
                                        @if($session->meeting_link)
                                            <a href="{{ $session->meeting_link }}" class="bg-primary hover:bg-secondary px-4 py-2 rounded-lg text-sm transition-colors" target="_blank">
                                                Join Session
                                            </a>
                                        @else
                                            <span class="bg-gray-600 px-4 py-2 rounded-lg text-sm">Link N/A</span>
                                        @endif
                                    @else
                                        <span class="bg-yellow-600 px-3 py-1 rounded-full text-xs">Upcoming</span>
                                        <span class="bg-gray-600 px-4 py-2 rounded-lg text-sm">
                                            {{ $session->session_date->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h4m5.657 6.657A7.96 7.96 0 0112 20a7.96 7.96 0 01-5.657-2.343m11.314 0C19.781 15.533 20 13.796 20 12s-.219-3.533-1.343-4.657m-11.314 0C5.219 8.467 5 10.204 5 12s.219 3.533 1.343 4.657"></path>
                            </svg>
                            <p>No upcoming sessions scheduled.</p>
                        </div>
                    @endif
                </div>

                <!-- Past Sessions -->
                @if(($pastSessions ?? collect())->count() > 0)
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold">Past Sessions</h2>
                        <span class="text-sm text-gray-400">{{ ($pastSessions ?? collect())->count() }} completed sessions</span>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach(($pastSessions ?? collect()) as $session)
                        <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gray-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold">{{ $session->topic ?? $session->title ?? 'Session ' . $loop->iteration }}</h3>
                                    <p class="text-sm text-gray-400">{{ $session->session_date->format('l, F j, Y') }}</p>
                                    <p class="text-sm text-gray-400">{{ $session->session_date->format('g:i A') }} - {{ $session->session_date->addHours(2)->format('g:i A') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="bg-gray-600 px-3 py-1 rounded-full text-xs">Completed</span>
                                @if($session->recording_link)
                                    <a href="{{ $session->recording_link }}" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-sm transition-colors" target="_blank">
                                        View Recording
                                    </a>
                                @else
                                    <span class="bg-gray-600 px-4 py-2 rounded-lg text-sm">Recording N/A</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Course Feedback Section -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold">Course Feedback</h2>
                        <div class="text-sm text-gray-400">Share your experience</div>
                    </div>
                    
                    <!-- User's Feedback Status -->
                    <div id="feedback-status" class="mb-4">
                        <!-- Will be populated by JavaScript -->
                    </div>
                    
                    <!-- Feedback Form -->
                    <form id="feedback-form" class="space-y-4" style="display: none;">
                        <!-- Rating -->
                        <div>
                            <label class="block text-sm font-medium mb-2">Overall Rating</label>
                            <div class="flex items-center space-x-1 mb-2">
                                <div class="flex" id="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating({{ $i }})" class="rating-star text-2xl text-gray-600 hover:text-yellow-400 transition-colors" data-rating="{{ $i }}">★</button>
                                    @endfor
                                </div>
                                <span id="rating-text" class="text-sm text-gray-400 ml-2">Click to rate</span>
                            </div>
                            <input type="hidden" id="rating-input" name="rating" required>
                        </div>

                        <!-- Feedback Categories -->
                        <div>
                            <label class="block text-sm font-medium mb-2">What would you like to feedback about? (Optional)</label>
                            <div class="flex flex-wrap gap-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="categories[]" value="content" class="mr-2 rounded">
                                    <span class="text-sm">Content Quality</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="categories[]" value="instructor" class="mr-2 rounded">
                                    <span class="text-sm">Instructor</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="categories[]" value="delivery" class="mr-2 rounded">
                                    <span class="text-sm">Delivery Method</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="categories[]" value="materials" class="mr-2 rounded">
                                    <span class="text-sm">Materials</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="categories[]" value="support" class="mr-2 rounded">
                                    <span class="text-sm">Support</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="categories[]" value="overall" class="mr-2 rounded">
                                    <span class="text-sm">Overall Experience</span>
                                </label>
                            </div>
                        </div>

                        <!-- Feedback Text -->
                        <div>
                            <label for="feedback-text" class="block text-sm font-medium mb-2">Your Feedback</label>
                            <textarea 
                                id="feedback-text" 
                                name="feedback" 
                                rows="4" 
                                class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none text-white placeholder-gray-400" 
                                placeholder="Please share your thoughts about this course. What did you like? What could be improved? (Minimum 10 characters)"
                                required
                                minlength="10"
                                maxlength="2000"></textarea>
                            <div class="text-xs text-gray-400 mt-1">
                                <span id="char-count">0</span>/2000 characters
                            </div>
                        </div>

                        <!-- Anonymous Option -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_anonymous" class="mr-2 rounded">
                                <span class="text-sm">Submit feedback anonymously</span>
                            </label>
                            <p class="text-xs text-gray-400 mt-1">If checked, your name will not be shown with this feedback</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-600">
                            <button 
                                type="button" 
                                onclick="cancelFeedback()" 
                                class="px-4 py-2 text-gray-400 hover:text-white transition-colors">
                                Cancel
                            </button>
                            <div class="flex space-x-3">
                                <button 
                                    type="button" 
                                    onclick="deleteFeedback()" 
                                    id="delete-feedback-btn" 
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-sm transition-colors" 
                                    style="display: none;">
                                    Delete Feedback
                                </button>
                                <button 
                                    type="submit" 
                                    id="submit-feedback-btn"
                                    class="px-6 py-2 bg-primary hover:bg-secondary rounded-lg text-sm transition-colors">
                                    Submit Feedback
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Feedback Messages -->
                    <div id="feedback-messages" class="mt-4"></div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Instructor Info -->
                @if($enrollment->course->instructor)
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-lg font-bold mb-4">Instructor</h3>
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center">
                            <span class="text-xl font-bold text-white">
                                {{ strtoupper(substr($enrollment->course->instructor->name ?? 'I', 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <h4 class="font-semibold">{{ $enrollment->course->instructor->name ?? 'Instructor Name' }}</h4>
                            <p class="text-sm text-gray-400">{{ $enrollment->course->instructor->title ?? 'Course Instructor' }}</p>
                        </div>
                    </div>
                    @if($enrollment->course->instructor->bio)
                        <p class="text-sm text-gray-300">{{ $enrollment->course->instructor->bio }}</p>
                    @endif
                </div>
                @endif

                <!-- Course Materials -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-lg font-bold mb-4">Course Materials</h3>
                    <div class="space-y-3">
                        <a href="#" class="flex items-center justify-between p-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm">Course Handbook</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            </svg>
                        </a>
                        <a href="#" class="flex items-center justify-between p-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm">Video Resources</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            </svg>
                        </a>
                        <a href="#" class="flex items-center justify-between p-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm">Assignment Template</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-lg font-bold mb-4">Your Progress</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span>Course Progress</span>
                                <span>{{ $enrollment->progress ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span>Sessions Attended</span>
                                <span>{{ $enrollment->sessions_attended ?? 0 }}/{{ ($upcomingSessions ?? collect())->count() + ($pastSessions ?? collect())->count() }}</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ (($enrollment->sessions_attended ?? 0) / max(($upcomingSessions ?? collect())->count() + ($pastSessions ?? collect())->count(), 1)) * 100 }}%"></div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-600">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400">Certificate Status</span>
                                @if($enrollment->progress >= 80)
                                    <span class="bg-green-600 px-2 py-1 rounded text-xs">Eligible</span>
                                @else
                                    <span class="bg-gray-600 px-2 py-1 rounded text-xs">{{ 80 - ($enrollment->progress ?? 0) }}% to go</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Support & Help -->
                <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-lg font-bold mb-4">Support & Help</h3>
                    <div class="space-y-3">
                        <a href="#" class="flex items-center space-x-3 p-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm">FAQ & Help Center</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 p-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h2m-2-4h.01M15 4h.01M10 12h.01M15 12h.01"></path>
                            </svg>
                            <span class="text-sm">Contact Support</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 p-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors">
                            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <span class="text-sm">Discussion Forum</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Feedback Form -->
    <script>
        let currentRating = 0;
        let hasExistingFeedback = false;
        let feedbackData = null;

        // Initialize feedback system
        document.addEventListener('DOMContentLoaded', function() {
            loadFeedbackStatus();
            setupCharacterCounter();
        });

        // Load user's existing feedback status
        function loadFeedbackStatus() {
            // This would typically be an AJAX call to your backend
            // For now, we'll simulate it
            const statusDiv = document.getElementById('feedback-status');
            
            // Simulate checking if user has existing feedback
            setTimeout(() => {
                if (hasExistingFeedback) {
                    statusDiv.innerHTML = `
                        <div class="bg-green-800 border border-green-600 rounded-lg p-4 mb-4">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium">You have already submitted feedback for this course.</p>
                                    <p class="text-xs text-gray-300">Rating: ★★★★☆ (4/5) • Submitted on March 15, 2024</p>
                                </div>
                            </div>
                            <button onclick="editFeedback()" class="mt-3 text-sm bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded transition-colors">
                                Edit Feedback
                            </button>
                        </div>
                    `;
                } else {
                    statusDiv.innerHTML = `
                        <div class="bg-gray-700 rounded-lg p-4 mb-4">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium">We'd love to hear your thoughts about this course!</p>
                                    <p class="text-xs text-gray-400">Your feedback helps us improve our training programs.</p>
                                </div>
                            </div>
                            <button onclick="showFeedbackForm()" class="mt-3 text-sm bg-primary hover:bg-secondary px-3 py-1 rounded transition-colors">
                                Give Feedback
                            </button>
                        </div>
                    `;
                }
            }, 500);
        }

        // Show feedback form
        function showFeedbackForm() {
            document.getElementById('feedback-form').style.display = 'block';
            document.getElementById('feedback-status').style.display = 'none';
        }

        // Edit existing feedback
        function editFeedback() {
            hasExistingFeedback = true;
            document.getElementById('delete-feedback-btn').style.display = 'inline-block';
            document.getElementById('submit-feedback-btn').textContent = 'Update Feedback';
            
            // Pre-populate form with existing data (simulate)
            setRating(4);
            document.getElementById('feedback-text').value = 'This is my existing feedback that I want to edit...';
            updateCharacterCount();
            
            showFeedbackForm();
        }

        // Cancel feedback
        function cancelFeedback() {
            document.getElementById('feedback-form').style.display = 'none';
            document.getElementById('feedback-status').style.display = 'block';
            resetFeedbackForm();
        }

        // Reset form
        function resetFeedbackForm() {
            currentRating = 0;
            document.getElementById('rating-input').value = '';
            document.getElementById('feedback-text').value = '';
            document.querySelectorAll('input[name="categories[]"]').forEach(cb => cb.checked = false);
            document.querySelector('input[name="is_anonymous"]').checked = false;
            updateRatingStars();
            updateCharacterCount();
            document.getElementById('delete-feedback-btn').style.display = 'none';
            document.getElementById('submit-feedback-btn').textContent = 'Submit Feedback';
        }

        // Set rating
        function setRating(rating) {
            currentRating = rating;
            document.getElementById('rating-input').value = rating;
            updateRatingStars();
        }

        // Update rating stars display
        function updateRatingStars() {
            const stars = document.querySelectorAll('.rating-star');
            const ratingText = document.getElementById('rating-text');
            
            stars.forEach((star, index) => {
                if (index < currentRating) {
                    star.classList.remove('text-gray-600');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-600');
                }
            });
            
            if (currentRating > 0) {
                const ratingLabels = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
                ratingText.textContent = `${currentRating}/5 - ${ratingLabels[currentRating]}`;
            } else {
                ratingText.textContent = 'Click to rate';
            }
        }

        // Setup character counter
        function setupCharacterCounter() {
            const textarea = document.getElementById('feedback-text');
            textarea.addEventListener('input', updateCharacterCount);
        }

        // Update character count
        function updateCharacterCount() {
            const textarea = document.getElementById('feedback-text');
            const charCount = document.getElementById('char-count');
            charCount.textContent = textarea.value.length;
        }

        // Submit feedback
        document.getElementById('feedback-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (currentRating === 0) {
                showMessage('Please select a rating before submitting.', 'error');
                return;
            }
            
            const formData = new FormData(this);
            formData.set('rating', currentRating);
            
            // Simulate API call
            showMessage('Submitting feedback...', 'info');
            
            setTimeout(() => {
                showMessage('Thank you for your feedback! It has been submitted successfully.', 'success');
                hasExistingFeedback = true;
                cancelFeedback();
                loadFeedbackStatus();
            }, 1000);
        });

        // Delete feedback
        function deleteFeedback() {
            if (confirm('Are you sure you want to delete your feedback? This action cannot be undone.')) {
                showMessage('Deleting feedback...', 'info');
                
                setTimeout(() => {
                    showMessage('Your feedback has been deleted.', 'success');
                    hasExistingFeedback = false;
                    cancelFeedback();
                    loadFeedbackStatus();
                }, 1000);
            }
        }

        // Show message
        function showMessage(message, type) {
            const messagesDiv = document.getElementById('feedback-messages');
            const colorClasses = {
                success: 'bg-green-800 border-green-600 text-green-100',
                error: 'bg-red-800 border-red-600 text-red-100',
                info: 'bg-blue-800 border-blue-600 text-blue-100'
            };
            
            messagesDiv.innerHTML = `
                <div class="${colorClasses[type]} border rounded-lg p-3 text-sm">
                    ${message}
                </div>
            `;
            
            // Auto-hide success messages
            if (type === 'success') {
                setTimeout(() => {
                    messagesDiv.innerHTML = '';
                }, 3000);
            }
        }

        // Initialize rating stars
        updateRatingStars();

        // Additional functionality for enhanced user experience
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Auto-save draft feedback
        let draftTimer;
        document.getElementById('feedback-text').addEventListener('input', function() {
            clearTimeout(draftTimer);
            draftTimer = setTimeout(() => {
                // Save draft to browser storage (if available)
                if (typeof(Storage) !== "undefined") {
                    const draftData = {
                        rating: currentRating,
                        feedback: this.value,
                        timestamp: new Date().toISOString()
                    };
                    localStorage.setItem('course_feedback_draft', JSON.stringify(draftData));
                }
            }, 2000);
        });

        // Load draft on page load
        window.addEventListener('load', function() {
            if (typeof(Storage) !== "undefined") {
                const draft = localStorage.getItem('course_feedback_draft');
                if (draft && !hasExistingFeedback) {
                    const draftData = JSON.parse(draft);
                    const draftAge = new Date() - new Date(draftData.timestamp);
                    
                    // Only load draft if it's less than 24 hours old
                    if (draftAge < 24 * 60 * 60 * 1000) {
                        const loadDraft = confirm('We found a draft of your feedback. Would you like to load it?');
                        if (loadDraft) {
                            if (draftData.rating) setRating(draftData.rating);
                            if (draftData.feedback) {
                                document.getElementById('feedback-text').value = draftData.feedback;
                                updateCharacterCount();
                            }
                        }
                    }
                }
            }
        });

        // Clear draft after successful submission
        function clearDraft() {
            if (typeof(Storage) !== "undefined") {
                localStorage.removeItem('course_feedback_draft');
            }
        }

        // Progress tracking
        function updateProgress(sessionId) {
            // This would typically make an AJAX call to update session attendance
            console.log('Updating progress for session:', sessionId);
        }

        // Notification system for upcoming sessions
        function checkUpcomingSessions() {
            const now = new Date();
            const upcomingSessions = document.querySelectorAll('[data-session-date]');
            
            upcomingSessions.forEach(session => {
                const sessionDate = new Date(session.dataset.sessionDate);
                const timeDiff = sessionDate - now;
                const minutesDiff = Math.floor(timeDiff / (1000 * 60));
                
                // Notify if session is starting in 15 minutes
                if (minutesDiff <= 15 && minutesDiff > 0) {
                    showNotification(`Session starting in ${minutesDiff} minutes!`, 'warning');
                }
            });
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
            
            const typeClasses = {
                info: 'bg-blue-600 text-white',
                warning: 'bg-yellow-600 text-white',
                success: 'bg-green-600 text-white',
                error: 'bg-red-600 text-white'
            };
            
            notification.className += ` ${typeClasses[type]}`;
            notification.innerHTML = `
                <div class="flex items-center space-x-3">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-white hover:text-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Check for upcoming sessions every minute
        setInterval(checkUpcomingSessions, 60000);
        checkUpcomingSessions(); // Check immediately on load

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + Enter to submit feedback when form is visible
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                const form = document.getElementById('feedback-form');
                if (form.style.display !== 'none') {
                    form.dispatchEvent(new Event('submit'));
                }
            }
            
            // Escape to cancel feedback form
            if (e.key === 'Escape') {
                const form = document.getElementById('feedback-form');
                if (form.style.display !== 'none') {
                    cancelFeedback();
                }
            }
        });

        // Print functionality
        function printCourseInfo() {
            window.print();
        }

        // Add print styles
        const printStyles = `
            <style media="print">
                .no-print { display: none !important; }
                body { background: white !important; color: black !important; }
                .bg-gray-800, .bg-gray-700 { background: #f5f5f5 !important; border: 1px solid #ddd !important; }
                .text-white { color: black !important; }
                nav, .sidebar { display: none !important; }
                .main-content { width: 100% !important; }
            </style>
        `;
        document.head.insertAdjacentHTML('beforeend', printStyles);

        // Enhanced form submission with better error handling
        const originalSubmit = document.getElementById('feedback-form').addEventListener;
        document.getElementById('feedback-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            const errors = [];
            if (currentRating === 0) errors.push('Please select a rating');
            
            const feedbackText = document.getElementById('feedback-text').value.trim();
            if (feedbackText.length < 10) errors.push('Feedback must be at least 10 characters long');
            if (feedbackText.length > 2000) errors.push('Feedback must be less than 2000 characters');
            
            if (errors.length > 0) {
                showMessage(errors.join('<br>'), 'error');
                return;
            }
            
            // Disable submit button to prevent double submission
            const submitBtn = document.getElementById('submit-feedback-btn');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';
            
            // Collect form data
            const formData = new FormData(this);
            formData.set('rating', currentRating);
            formData.set('course_id', '{{ $enrollment->course->id }}');
            formData.set('enrollment_id', '{{ $enrollment->id }}');
            
            // Simulate API call with better error handling
            showMessage('Submitting your feedback...', 'info');
            
            // In a real application, you would make an AJAX call here
            fetch('/api/course-feedback', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Thank you for your feedback! It has been submitted successfully.', 'success');
                    hasExistingFeedback = true;
                    clearDraft();
                    cancelFeedback();
                    loadFeedbackStatus();
                } else {
                    throw new Error(data.message || 'Failed to submit feedback');
                }
            })
            .catch(error => {
                showMessage('Error submitting feedback: ' + error.message, 'error');
            })
            .finally(() => {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });

        // Add course to calendar functionality
        function addToCalendar() {
            const courseTitle = '{{ $enrollment->course->title }}';
            const startDate = '{{ $enrollment->course->start_date }}';
            const endDate = '{{ $enrollment->course->end_date }}';
            const description = '{{ $enrollment->course->description }}';
            
            // Create calendar event URL (Google Calendar format)
            const eventUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(courseTitle)}&dates=${startDate.replace(/[-:]/g, '')}/${endDate.replace(/[-:]/g, '')}&details=${encodeURIComponent(description)}`;
            
            window.open(eventUrl, '_blank');
        }

        // Course sharing functionality
        function shareCourse() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $enrollment->course->title }}',
                    text: 'Check out this course: {{ $enrollment->course->description }}',
                    url: window.location.href
                }).catch(console.error);
            } else {
                // Fallback to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    showNotification('Course link copied to clipboard!', 'success');
                }).catch(() => {
                    showNotification('Unable to copy link', 'error');
                });
            }
        }

        // Initialize tooltips for better UX
        function initializeTooltips() {
            const tooltipElements = document.querySelectorAll('[data-tooltip]');
            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', showTooltip);
                element.addEventListener('mouseleave', hideTooltip);
            });
        }

        function showTooltip(e) {
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute z-50 px-2 py-1 text-xs text-white bg-black rounded shadow-lg pointer-events-none';
            tooltip.textContent = e.target.dataset.tooltip;
            tooltip.id = 'tooltip';
            
            document.body.appendChild(tooltip);
            
            const rect = e.target.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
        }

        function hideTooltip() {
            const tooltip = document.getElementById('tooltip');
            if (tooltip) tooltip.remove();
        }

        // Initialize all enhanced features
        initializeTooltips();

        console.log('Course Access Page initialized with enhanced features');
    </script>

    <!-- Additional CSS for enhanced features -->
    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        
        /* Loading states */
        .loading {
            position: relative;
            pointer-events: none;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Enhanced hover effects */
        .hover-scale {
            transition: transform 0.2s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.02);
        }
        
        /* Focus indicators for accessibility */
        .focus-visible:focus-visible {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }
        
        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                background: white !important;
                color: black !important;
            }
            
            .bg-gray-800, .bg-gray-700 {
                background: #f5f5f5 !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>
</body>
</html>