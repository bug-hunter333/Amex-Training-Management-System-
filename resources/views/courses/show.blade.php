<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - AMEX Training Institute</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
        }

        .tab-button {
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.6);
            border-bottom: 2px solid transparent;
        }

        .tab-button.active {
            color: #ffffff;
            border-bottom-color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }

        .tab-button:hover:not(.active) {
            color: rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.02);
        }

        .enroll-btn {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            color: #000;
            transition: all 0.3s ease;
        }

        .enroll-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }

        .secondary-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .secondary-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .badge-featured {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            color: #000;
            animation: pulse 2s infinite;
        }

        .badge-mandatory {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .badge-type {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .hero-image {
            background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 100%);
            z-index: 1;
        }

        .hero-image>* {
            position: relative;
            z-index: 2;
        }

        .tag-item {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .tag-item:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .rating-stars {
            color: #fbbf24;
        }

        .breadcrumb-link {
            color: rgba(255, 255, 255, 0.6);
            transition: color 0.3s ease;
        }

        .breadcrumb-link:hover {
            color: #ffffff;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.4s ease-out;
        }

        .sticky-sidebar {
            position: sticky;
            top: 2rem;
        }

        .nav-glass {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="h-full text-white min-h-screen">

    <div class="min-h-full" x-data="{ activeTab: 'overview' }">

        <!-- Navigation -->
        <nav class="fixed top-0 w-full z-50 bg-black/80 backdrop-blur-md border-b border-white/10">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                            <span class="text-black font-bold text-sm">A</span>
                        </div>
                        <span class="text-xl font-semibold">AMEX Training Institute</span>
                    </div>
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#" class="text-white/70 hover:text-white transition-colors">Home</a>

                        <a href="#contact" class="text-white/70 hover:text-white transition-colors">Contact</a>
                        <a href="#" class="text-white transition-colors font-medium">Courses</a>

                        @auth
                            <!-- Show user menu when logged in -->
                            <div class="relative group">
                                <button
                                    class="text-gray-300 hover:text-white transition-colors flex items-center space-x-2">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div
                                    class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-700 rounded-t-lg">Dashboard</a>
                                    <a href="{{ route('profile.show') }}"
                                        class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-700">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-700 rounded-b-lg">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Show login/register when not logged in -->
                            <a href="{{ route('login') }}"
                                class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-lg transition-colors">Login</a>
                            <a href="{{ route('register') }}"
                                class="bg-white text-black hover:bg-gray-200 px-4 py-2 rounded-lg font-medium transition-colors hover-glow">Get
                                Started</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <div class="pt-20 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Breadcrumb -->
                <nav class="mb-8 animate-fade-in">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li><a href="{{ route('courses.index') }}" class="breadcrumb-link">Courses</a></li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-white/40" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium text-white">{{ $course->title }}</span>
                        </li>
                    </ol>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Main Content -->
                    <div class="lg:col-span-2">

                        <!-- Course Header -->
                        <div class="glass-card rounded-2xl overflow-hidden mb-8 animate-slide-up">
                            <div class="hero-image h-80 relative">
                                @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                                        class="absolute inset-0 w-full h-full object-cover">
                                @endif

                                <!-- Badges -->
                                <div class="absolute top-6 left-6 flex flex-wrap gap-3 z-10">
                                    @if($course->is_featured)
                                        <span
                                            class="badge-featured px-4 py-2 rounded-full text-sm font-bold">Featured</span>
                                    @endif
                                    @if($course->is_mandatory)
                                        <span
                                            class="badge-mandatory px-4 py-2 rounded-full text-sm font-bold">Mandatory</span>
                                    @endif
                                    <span class="badge-type px-4 py-2 rounded-full text-sm font-semibold capitalize">
                                        {{ str_replace('-', ' ', $course->course_type) }}
                                    </span>
                                </div>

                                <!-- Course Title Overlay -->
                                <div class="absolute bottom-6 left-6 right-6 z-10">
                                    <div class="glass-card rounded-xl p-6">
                                        <div class="flex flex-wrap items-center gap-4 mb-4">
                                            <span class="tag-item px-3 py-1 rounded-full text-sm capitalize">
                                                {{ str_replace('-', ' ', $course->category) }}
                                            </span>
                                            <div class="flex items-center rating-stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor($course->average_rating))
                                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                            <path
                                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-white/30" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                        </svg>
                                                    @endif
                                                @endfor
                                                <span
                                                    class="ml-2 text-white/80">{{ number_format($course->average_rating, 1) }}
                                                    ({{ $course->total_reviews }} reviews)</span>
                                            </div>
                                        </div>
                                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">{{ $course->title }}
                                        </h1>
                                        <p class="text-white/80 text-lg leading-relaxed">{{ $course->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Course Details Tabs -->
                        <div class="glass-card rounded-2xl overflow-hidden animate-slide-up">
                            <div class="border-b border-white/10">
                                <nav class="flex space-x-8 px-6 overflow-x-auto">
                                    <button @click="activeTab = 'overview'"
                                        :class="activeTab === 'overview' ? 'active' : ''"
                                        class="tab-button whitespace-nowrap py-4 px-2 font-medium text-sm focus:outline-none">
                                        Overview
                                    </button>
                                    <button @click="activeTab = 'outline'"
                                        :class="activeTab === 'outline' ? 'active' : ''"
                                        class="tab-button whitespace-nowrap py-4 px-2 font-medium text-sm focus:outline-none">
                                        Course Outline
                                    </button>
                                    <button @click="activeTab = 'objectives'"
                                        :class="activeTab === 'objectives' ? 'active' : ''"
                                        class="tab-button whitespace-nowrap py-4 px-2 font-medium text-sm focus:outline-none">
                                        Learning Objectives
                                    </button>
                                    <button @click="activeTab = 'materials'"
                                        :class="activeTab === 'materials' ? 'active' : ''"
                                        class="tab-button whitespace-nowrap py-4 px-2 font-medium text-sm focus:outline-none">
                                        Materials
                                    </button>
                                </nav>
                            </div>

                            <div class="p-8">
                                <!-- Overview Tab -->
                                <div x-show="activeTab === 'overview'" class="tab-content"
                                    :class="activeTab === 'overview' ? 'active' : ''">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div>
                                            <h3 class="text-xl font-bold text-white mb-6">Prerequisites</h3>
                                            <ul class="space-y-3">
                                                @foreach($course->prerequisites as $prerequisite)
                                                    <li class="flex items-start group">
                                                        <svg class="w-5 h-5 text-green-400 mr-3 mt-1 flex-shrink-0 group-hover:text-green-300 transition-colors"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L3.293 9.293a1 1 0 01-1.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span
                                                            class="text-white/80 group-hover:text-white transition-colors">{{ $prerequisite }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-white mb-6">Target Audience</h3>
                                            <div class="space-y-6">
                                                <div>
                                                    <h4 class="font-semibold text-white/90 mb-3">Departments:</h4>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($course->target_departments as $dept)
                                                            <span
                                                                class="tag-item px-3 py-1 rounded-full text-sm">{{ $dept }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-white/90 mb-3">Roles:</h4>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($course->target_roles as $role)
                                                            <span
                                                                class="tag-item px-3 py-1 rounded-full text-sm">{{ $role }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-white/90 mb-3">Levels:</h4>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($course->target_levels as $level)
                                                            <span
                                                                class="tag-item px-3 py-1 rounded-full text-sm capitalize">{{ $level }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Course Outline Tab -->
                                <div x-show="activeTab === 'outline'" class="tab-content"
                                    :class="activeTab === 'outline' ? 'active' : ''">
                                    <h3 class="text-xl font-bold text-white mb-6">Course Outline</h3>
                                    <div class="prose prose-invert max-w-none text-white/80 leading-relaxed">
                                        {!! nl2br(e($course->course_outline)) !!}
                                    </div>
                                </div>

                                <!-- Learning Objectives Tab -->
                                <div x-show="activeTab === 'objectives'" class="tab-content"
                                    :class="activeTab === 'objectives' ? 'active' : ''">
                                    <h3 class="text-xl font-bold text-white mb-6">Learning Objectives</h3>
                                    <ul class="space-y-4">
                                        @foreach($course->learning_objectives as $objective)
                                            <li class="flex items-start group">
                                                <svg class="w-6 h-6 text-blue-400 mr-4 mt-0.5 flex-shrink-0 group-hover:text-blue-300 transition-colors"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span
                                                    class="text-white/80 group-hover:text-white transition-colors text-lg">{{ $objective }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Materials Tab -->
                                <div x-show="activeTab === 'materials'" class="tab-content"
                                    :class="activeTab === 'materials' ? 'active' : ''">
                                    <div class="space-y-8">
                                        <div>
                                            <h3 class="text-xl font-bold text-white mb-6">Course Materials</h3>
                                            <ul class="space-y-3">
                                                @foreach($course->materials as $material)
                                                    <li class="flex items-center group">
                                                        <svg class="w-5 h-5 text-green-400 mr-3 group-hover:text-green-300 transition-colors"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span
                                                            class="text-white/80 group-hover:text-white transition-colors">{{ $material }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-white mb-6">Additional Resources</h3>
                                            <ul class="space-y-3">
                                                @foreach($course->resources as $resource)
                                                    <li class="flex items-center group">
                                                        <svg class="w-5 h-5 text-blue-400 mr-3 group-hover:text-blue-300 transition-colors"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span
                                                            class="text-white/80 group-hover:text-white transition-colors">{{ $resource }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <!-- Enrollment Card -->
                        <div class="glass-card rounded-2xl p-8 sticky-sidebar animate-slide-up">
                            <div class="text-center mb-8">
                                <div class="text-4xl font-bold text-white mb-3">${{ number_format($course->price, 0) }}
                                </div>
                                @if($course->requires_approval)
                                    <p class="text-sm text-yellow-400 mb-4">Approval required before enrollment</p>
                                @endif
                            </div>

                            <!-- Course Info -->
                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-white/60">Duration:</span>
                                    <span class="font-medium text-white">{{ $course->duration_weeks }} weeks
                                        ({{ $course->duration_hours }} hours)</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-white/60">Difficulty:</span>
                                    <span
                                        class="font-medium text-white capitalize">{{ $course->difficulty_level }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-white/60">Certificate:</span>
                                    <span
                                        class="font-medium text-white capitalize">{{ str_replace('-', ' ', $course->certificate_type) }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-white/60">Enrolled:</span>
                                    <span
                                        class="font-medium text-white">{{ $course->enrollment_count }}/{{ $course->max_participants }}</span>
                                </div>
                                @if($course->schedule)
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-white/60">Schedule:</span>
                                        <span
                                            class="font-medium text-white text-sm">{{ implode(', ', $course->schedule['days'] ?? []) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-white/60">Time:</span>
                                        <span
                                            class="font-medium text-white text-sm">{{ $course->schedule['time'] ?? '' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-white/60">Lecturer:</span>
                                        <span class="font-medium text-white text-sm">{{$course->lecturer_name}}</span>

                                    </div>
                                @endif
                            </div>

                            <!-- Enrollment Dates -->
                            <div class="info-card rounded-xl p-6 mb-8">
                                <h4 class="font-bold text-white mb-4">Important Dates</h4>
                                <div class="space-y-3 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-white/60">Enrollment Opens:</span>
                                        <span
                                            class="font-medium text-white">{{ date('M j, Y', strtotime($course->enrollment_start_date)) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-white/60">Enrollment Closes:</span>
                                        <span
                                            class="font-medium text-white">{{ date('M j, Y', strtotime($course->enrollment_end_date)) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-white/60">Course Starts:</span>
                                        <span
                                            class="font-medium text-white">{{ date('M j, Y', strtotime($course->start_date)) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-white/60">Course Ends:</span>
                                        <span
                                            class="font-medium text-white">{{ date('M j, Y', strtotime($course->end_date)) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->

                            <div class="space-y-3 mb-8">
                                @if(($course->enrollment_count ?? 24) < ($course->max_participants ?? 30))
                                    @if($course->requires_approval ?? false)
                                        <a href="{{ route('enrollment.create', $course->id) }}" class="inline-block w-full">
                                            <button
                                                class="w-full bg-amber-600 hover:bg-amber-700 text-white px-6 py-4 rounded-lg font-medium transition-colors">
                                                Request Enrollment
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{ route('enrollment.create', $course->id) }}" class="inline-block w-full">
                                            <button
                                                class="w-full bg-black hover:bg-gray-800 text-white px-6 py-4 rounded-lg font-medium transition-colors">
                                                Enroll Now
                                            </button>
                                        </a>
                                    @endif
                                @else
                                    <button disabled
                                        class="w-full bg-gray-400 text-white px-6 py-4 rounded-lg font-medium cursor-not-allowed">
                                        Course Full
                                    </button>
                                @endif

                                <button onclick="sendEmailToInstructor()"
                                    class="w-full bg-gray-100 border-2 border-gray-300 hover:border-gray-400 text-gray-700 hover:text-black px-6 py-4 rounded-lg font-medium transition-colors">
                                    Send A Mail
                                </button>

                            </div>
                            <!-- Venue Information -->
                            @if($course->venue_type !== 'online')
                                <div class="info-card rounded-xl p-6 mb-8">
                                    <h4 class="font-bold text-white mb-4">Venue Information</h4>
                                    <div class="text-sm text-white/70 space-y-2">
                                        @if($course->venue_name)
                                            <p class="font-medium text-white">{{ $course->venue_name }}</p>
                                        @endif
                                        @if($course->venue_address)
                                            <p>{{ $course->venue_address }}</p>
                                        @endif
                                        @if($course->online_platform && $course->venue_type === 'hybrid')
                                            <p class="mt-3"><strong class="text-white">Online Platform:</strong>
                                                {{ $course->online_platform }}</p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="info-card rounded-xl p-6 mb-8">
                                    <h4 class="font-bold text-white mb-4">Online Course</h4>
                                    <div class="text-sm text-white/70 space-y-2">
                                        <p><strong class="text-white">Platform:</strong>
                                            {{ $course->online_platform ?? 'To be announced' }}</p>
                                        <p>Join from anywhere with an internet connection</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Tags -->
                            <div class="pt-6 border-t border-white/10">
                                <h4 class="font-bold text-white mb-4">Course Tags</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($course->tags as $tag)
                                        <span class="tag-item px-3 py-2 rounded-full text-sm">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer id="contact" class="bg-black border-t border-gray-800 py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                                <span class="text-black font-bold text-sm mono">A</span>
                            </div>
                            <span class="text-xl font-semibold mono">AMEX Training Institute</span>
                        </div>
                        <p class="text-gray-400">Empowering corporate training through intelligent management solutions.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Platform</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">Features</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Security</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Support</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Company</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Privacy</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Terms</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                    <p>&copy; 2025 Amex Training Institute. All rights reserved.</p>
                </div>
            </div>
        </footer>

    </div>

    <script>
        // Enhanced tab switching with animations
        document.addEventListener('alpine:init', () => {
            Alpine.data('courseDetail', () => ({
                activeTab: 'overview',

                switchTab(tab) {
                    const currentContent = document.querySelector('.tab-content.active');
                    if (currentContent) {
                        currentContent.style.opacity = '0';
                        currentContent.style.transform = 'translateY(10px)';

                        setTimeout(() => {
                            currentContent.classList.remove('active');
                            this.activeTab = tab;

                            setTimeout(() => {
                                const newContent = document.querySelector('.tab-content.active');
                                if (newContent) {
                                    newContent.style.opacity = '1';
                                    newContent.style.transform = 'translateY(0)';
                                }
                            }, 50);
                        }, 200);
                    } else {
                        this.activeTab = tab;
                    }
                }
            }));
        });


        // Email functionality
        function sendEmailToInstructor() {
            const courseTitle = '{{ $course->title }}';
            const lecturerEmail = '{{ $course->lecturer_email }}';
            const lecturerName = '{{ $course->lecturer_name ?? "Lecturer" }}';
            const studentName = '{{ auth()->user()->name ?? "Student" }}';
            const studentEmail = '{{ auth()->user()->email ?? "student@example.com" }}';

            // Validate lecturer email exists
            if (!lecturerEmail || lecturerEmail === '') {
                alert('Lecturer email not available for this course. Please contact course administration.');
                return;
            }

            const subject = encodeURIComponent(`Inquiry about ${courseTitle} course`);
            const body = encodeURIComponent(`Dear ${lecturerName},

I hope this email finds you well. I am writing to inquire about the "${courseTitle}" course that you are teaching.

I would like to know more about:
- Course prerequisites and preparation materials
- Assessment methods and grading criteria
- Availability of additional resources or support
- Any specific requirements for the course
- Office hours or consultation availability

Please let me know if you have any availability to discuss this course in more detail.

Best regards,
${studentName}
${studentEmail}

Course Details:
- Course: ${courseTitle}
- Duration: {{ $course->duration_weeks ?? 8 }} weeks
- Difficulty: {{ ucfirst($course->difficulty_level ?? 'advanced') }}
- Start Date: {{ date('M j, Y', strtotime($course->start_date ?? '2024-03-15')) }}
- Enrollment: {{ $course->enrollment_count ?? 24 }}/{{ $course->max_participants ?? 30 }} students
`);

            // Try to open Gmail first, then fallback to default email client
            const gmailUrl = `https://mail.google.com/mail/?view=cm&to=${lecturerEmail}&su=${subject}&body=${body}`;
            const mailtoUrl = `mailto:${lecturerEmail}?subject=${subject}&body=${body}`;

            // Open Gmail in a new tab
            const gmailWindow = window.open(gmailUrl, '_blank');

            // Fallback to mailto if Gmail doesn't open (after a short delay)
            setTimeout(() => {
                if (!gmailWindow || gmailWindow.closed) {
                    window.location.href = mailtoUrl;
                }
            }, 1000);
        }

        // Smooth scroll behavior for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Enhanced enrollment button interactions
        document.querySelectorAll('.enroll-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                if (this.textContent.includes('Enroll') || this.textContent.includes('Request')) {
                    e.preventDefault();

                    // Add loading animation
                    const originalText = this.textContent;
                    const originalHTML = this.innerHTML;

                    this.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-current inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                `;
                    this.style.opacity = '0.8';

                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.style.opacity = '1';

                        // Show success message (you would integrate with your backend here)
                        this.innerHTML = `
                        <svg class="w-5 h-5 mr-2 inline-block" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L3.293 9.293a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Success!
                    `;

                        setTimeout(() => {
                            this.innerHTML = originalHTML;
                        }, 2000);
                    }, 2000);
                }
            });
        });




        // Parallax effect for hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroImage = document.querySelector('.hero-image img');
            if (heroImage) {
                const speed = scrolled * 0.1;
                heroImage.style.transform = `translateY(${speed}px) scale(1.1)`;
            }
        });

        // Add entrance animations on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.glass-card, .info-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            observer.observe(el);
        });

        // Enhanced hover effects for interactive elements
        document.querySelectorAll('.tag-item').forEach(tag => {
            tag.addEventListener('mouseenter', function () {
                this.style.transform = 'scale(1.05)';
            });

            tag.addEventListener('mouseleave', function () {
                this.style.transform = 'scale(1)';
            });
        });

        // Add ripple effect to buttons
        function createRipple(event) {
            const button = event.currentTarget;
            const circle = document.createElement('span');
            const diameter = Math.max(button.clientWidth, button.clientHeight);
            const radius = diameter / 2;

            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
            circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
            circle.classList.add('ripple');

            const ripple = button.getElementsByClassName('ripple')[0];
            if (ripple) {
                ripple.remove();
            }

            button.appendChild(circle);
        }

        // Add ripple styles
        const rippleStyle = document.createElement('style');
        rippleStyle.textContent = `
        .ripple {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        button {
            position: relative;
            overflow: hidden;
        }
    `;
        document.head.appendChild(rippleStyle);

        // Apply ripple effect to buttons
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', createRipple);
        });

        // Dynamic progress indicator for course completion
        function updateProgressIndicator() {
            const enrolled = {{ $course->enrollment_count }};
            const maxParticipants = {{ $course->max_participants }};
            const percentage = (enrolled / maxParticipants) * 100;

            const progressBar = document.createElement('div');
            progressBar.className = 'mt-2 w-full bg-white/10 rounded-full h-2';
            progressBar.innerHTML = `
            <div class="bg-gradient-to-r from-white to-white/80 h-2 rounded-full transition-all duration-1000" 
                 style="width: ${percentage}%"></div>
        `;

            const enrollmentInfo = document.querySelector('.flex.justify-between:has(.text-white\\/60:contains("Enrolled"))');
            if (enrollmentInfo && !enrollmentInfo.nextElementSibling?.classList.contains('mt-2')) {
                enrollmentInfo.insertAdjacentElement('afterend', progressBar);
            }
        }

        // Initialize progress indicator
        document.addEventListener('DOMContentLoaded', updateProgressIndicator);
    </script>

</body>

</html>