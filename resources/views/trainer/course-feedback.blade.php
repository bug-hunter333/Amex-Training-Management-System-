<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Feedback - Trainer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-black">
        <div class="container mx-auto px-6 py-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Course Feedback</h1>
                    <p class="text-gray-300">Review feedback from your trainees to improve your courses</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('trainer.dashboard') }}" 
                       class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20 mb-8">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Filter by Course</label>
                        <select name="course_id" class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white focus:border-blue-400 transition-all">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Filter by Rating</label>
                        <select name="rating" class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white focus:border-blue-400 transition-all">
                            <option value="">All Ratings</option>
                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Sort By</label>
                        <select name="sort" class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white focus:border-blue-400 transition-all">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="rating_high" {{ request('sort') == 'rating_high' ? 'selected' : '' }}>Highest Rating</option>
                            <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>Lowest Rating</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition-colors">
                            Apply Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Feedback Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20">
                    <div class="text-center">
                        <p class="text-gray-400 text-sm mb-2">Average Rating</p>
                        <p class="text-3xl font-bold text-white mb-1">{{ number_format($feedback->avg('rating') ?? 0, 1) }}</p>
                        <div class="flex justify-center items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= round($feedback->avg('rating') ?? 0) ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                </div>

                @for($rating = 5; $rating >= 1; $rating--)
                    <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20">
                        <div class="text-center">
                            <p class="text-gray-400 text-sm mb-2">{{ $rating }} Star{{ $rating > 1 ? 's' : '' }}</p>
                            <p class="text-2xl font-bold text-white mb-2">{{ $feedback->where('rating', $rating)->count() }}</p>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-yellow-400 h-2 rounded-full" 
                                     style="width: {{ $feedback->count() > 0 ? ($feedback->where('rating', $rating)->count() / $feedback->count()) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Feedback List -->
            <div class="space-y-6">
                @forelse($feedback as $feedbackItem)
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:border-white/30 transition-all duration-300">
                        <!-- Feedback Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold">
                                        {{ $feedbackItem->is_anonymous ? 'A' : strtoupper(substr($feedbackItem->user->name ?? 'U', 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold">
                                        {{ $feedbackItem->is_anonymous ? 'Anonymous' : ($feedbackItem->user->name ?? 'Unknown User') }}
                                    </h3>
                                    <p class="text-gray-400 text-sm">{{ $feedbackItem->course->title }}</p>
                                    <p class="text-gray-500 text-xs">{{ $feedbackItem->created_at->format('M j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <!-- Rating -->
                                <div class="flex items-center space-x-2">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $feedbackItem->rating ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-400">({{ $feedbackItem->rating }}/5)</span>
                                </div>

                                <!-- Status Badge -->
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ 
                                    $feedbackItem->status === 'approved' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 
                                    ($feedbackItem->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30') 
                                }}">
                                    {{ ucfirst($feedbackItem->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Feedback Content -->
                        <div class="mb-4">
                            <h4 class="text-white font-medium mb-2">Feedback:</h4>
                            <p class="text-gray-300 leading-relaxed">{{ $feedbackItem->feedback }}</p>
                        </div>

                        <!-- Detailed Ratings -->
                        @if($feedbackItem->instructor_rating || $feedbackItem->content_rating || $feedbackItem->delivery_rating)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 p-4 bg-white/5 rounded-lg">
                                @if($feedbackItem->instructor_rating)
                                    <div class="text-center">
                                        <p class="text-gray-400 text-sm mb-1">Instructor</p>
                                        <div class="flex justify-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $feedbackItem->instructor_rating ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <p class="text-white text-sm mt-1">{{ $feedbackItem->instructor_rating }}/5</p>
                                    </div>
                                @endif

                                @if($feedbackItem->content_rating)
                                    <div class="text-center">
                                        <p class="text-gray-400 text-sm mb-1">Content</p>
                                        <div class="flex justify-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $feedbackItem->content_rating ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <p class="text-white text-sm mt-1">{{ $feedbackItem->content_rating }}/5</p>
                                    </div>
                                @endif

                                @if($feedbackItem->delivery_rating)
                                    <div class="text-center">
                                        <p class="text-gray-400 text-sm mb-1">Delivery</p>
                                        <div class="flex justify-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $feedbackItem->delivery_rating ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <p class="text-white text-sm mt-1">{{ $feedbackItem->delivery_rating }}/5</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Suggestions -->
                        @if($feedbackItem->suggestions)
                            <div class="mb-4">
                                <h4 class="text-white font-medium mb-2">Suggestions for Improvement:</h4>
                                <p class="text-gray-300 leading-relaxed">{{ $feedbackItem->suggestions }}</p>
                            </div>
                        @endif

                        <!-- Recommendation -->
                        @if(!is_null($feedbackItem->would_recommend))
                            <div class="mb-4">
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-400 text-sm">Would recommend this course:</span>
                                    <span class="px-2 py-1 text-xs rounded-full {{ 
                                        $feedbackItem->would_recommend ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' 
                                    }}">
                                        {{ $feedbackItem->would_recommend ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Admin Response -->
                        @if($feedbackItem->admin_response)
                            <div class="mt-4 p-4 bg-blue-500/10 rounded-lg border-l-4 border-blue-500">
                                <h4 class="text-blue-400 font-medium mb-2">Admin Response:</h4>
                                <p class="text-gray-300">{{ $feedbackItem->admin_response }}</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="text-center py-16 bg-white/5 rounded-2xl border border-white/10">
                        <div class="text-gray-500 mb-6">
                            <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 8h10m0 0V6a2 2 0 00-2-2H9a2 2 0 00-2 2v2m10 0v10a2 2 0 01-2 2H9a2 2 0 01-2-2V8m10 0H7"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">No feedback yet</h3>
                        <p class="text-gray-400 text-lg">Feedback from trainees will appear here once they complete your courses.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($feedback->hasPages())
                <div class="mt-12">
                    {{ $feedback->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>