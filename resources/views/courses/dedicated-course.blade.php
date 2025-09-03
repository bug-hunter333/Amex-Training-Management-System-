<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $enrollment->course->title }} - My Course - AMEX Training Institute</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        }
        
        .session-card {
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .session-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
        
        .session-card.completed {
            background: rgba(34, 197, 94, 0.05);
            border-color: rgba(34, 197, 94, 0.2);
        }
        
        .session-card.upcoming {
            background: rgba(59, 130, 246, 0.05);
            border-color: rgba(59, 130, 246, 0.2);
        }
        
        .session-card.live {
            background: rgba(239, 68, 68, 0.05);
            border-color: rgba(239, 68, 68, 0.2);
            animation: pulse 2s infinite;
        }
        
        .material-item {
            transition: all 0.3s ease;
        }
        
        .material-item:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(10px);
        }
        
        .progress-ring {
            transform: rotate(-90deg);
        }
        
        .progress-ring-circle {
            transition: stroke-dashoffset 0.35s;
            transform: rotate(0deg);
            transform-origin: 50% 50%;
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
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        .animate-slide-up {
            animation: slideUp 0.8s ease-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .live-indicator {
            animation: blink 1s infinite;
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.3; }
        }
    </style>
</head>
<body class="text-white min-h-screen">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-40 bg-black/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <span class="text-black font-bold text-sm">A</span>
                    </div>
                    <span class="text-xl font-semibold">AMEX Training Institute</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('courses.index') }}" class="text-white/70 hover:text-white transition-colors">Courses</a>
                    <a href="{{ route('dashboard') }}" class="text-white/70 hover:text-white transition-colors">Dashboard</a>
                    @auth
                        <div class="relative group">
                            <button class="text-gray-300 hover:text-white transition-colors flex items-center space-x-2">
                                <span>{{ Auth::user()->name ?? 'Student' }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-700">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-700 rounded-b-lg">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-20 pb-12 min-h-screen" x-data="{ activeTab: 'overview' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Course Header -->
            <div class="glass-card rounded-2xl p-8 mb-8 animate-fade-in">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-900/80 text-green-300 border border-green-700/50 backdrop-blur-sm">
                                Reference ID: {{ $enrollment->reference_id ?? 'AMX2401011234' }}
                            </div>
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-900/80 text-blue-300 border border-blue-700/50 backdrop-blur-sm">
                                {{ ucfirst($enrollment->status ?? 'approved') }}
                            </div>
                        </div>
                        <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $enrollment->course->title ?? 'Full Stack Development' }}</h1>
                        <p class="text-white/70 text-lg mb-6">{{ $enrollment->course->description ?? 'Comprehensive course covering modern web development technologies including React, Node.js, and databases.' }}</p>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                            <div>
                                <div class="text-2xl font-bold text-white">{{ $enrollment->course->duration_weeks ?? '12' }}</div>
                                <div class="text-white/60 text-sm">Weeks</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">{{ $enrollment->course->duration_hours ?? '120' }}</div>
                                <div class="text-white/60 text-sm">Hours</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">24</div>
                                <div class="text-white/60 text-sm">Sessions</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">35%</div>
                                <div class="text-white/60 text-sm">Progress</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:w-48 flex flex-col items-center">
                        <div class="relative w-32 h-32 mb-4">
                            <svg class="w-32 h-32 progress-ring" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="40" stroke="rgba(255,255,255,0.1)" stroke-width="8" fill="transparent"/>
                                <circle cx="50" cy="50" r="40" stroke="#ffffff" stroke-width="8" fill="transparent" 
                                        stroke-dasharray="251.2" stroke-dashoffset="163.28" 
                                        class="progress-ring-circle"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-2xl font-bold">35%</span>
                            </div>
                        </div>
                        <p class="text-white/60 text-sm text-center">Course Completion</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="glass-card rounded-2xl overflow-hidden mb-8 animate-slide-up">
                <div class="border-b border-white/10">
                    <nav class="flex space-x-8 px-6 overflow-x-auto">
                        <button @click="activeTab = 'overview'"
                                :class="activeTab === 'overview' ? 'active' : ''"
                                class="tab-button whitespace-nowrap py-4 px-2 font-medium text-sm focus:outline-none">
                            Overview
                        </button>
                        <button @click="activeTab = 'sessions'"
                                :class="activeTab === 'sessions' ? 'active' : ''"
                                class="tab-button whitespace-nowrap py-4 px-2 font-medium text-sm focus:outline-none">
                            Sessions
                        </button>
                        <button @click="activeTab = 'materials'"
                                :class="activeTab === 'materials' ? 'active' : ''"
                                class="tab-button whitespace-nowrap py-4 px-2 font-medium text-sm focus:outline-none">
                            Materials
                        </button>
                        <button @click="activeTab = 'assignments'"
                                :class="activeTab === 'assignments' ? 'active' : ''"
                                class="tab-button whitespace-nowrap py-4 px-2 font-medium text-sm focus:outline-none">
                            Assignments
                        </button>
                        <button @click="activeTab = 'progress'"
                                :class="activeTab === 'progress' ? 'active' : ''"
                                class="tab-button whitespace-nowrap py-4 px-2 font-medium text-sm focus:outline-none">
                            Progress
                        </button>
                    </nav>
                </div>

                <div class="p-8">
                    <!-- Overview Tab -->
                    <div x-show="activeTab === 'overview'" x-transition:enter.duration.300ms>
                        <div class="grid lg:grid-cols-2 gap-8">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-6">Course Information</h3>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-white/60">Instructor:</span>
                                        <span class="font-medium text-white">{{ $enrollment->course->lecturer_name ?? 'Dr. Sarah Johnson' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-white/60">Start Date:</span>
                                        <span class="font-medium text-white">{{ date('M j, Y', strtotime($enrollment->course->start_date ?? '2024-03-15')) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-white/60">End Date:</span>
                                        <span class="font-medium text-white">{{ date('M j, Y', strtotime($enrollment->course->end_date ?? '2024-06-07')) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-white/60">Platform:</span>
                                        <span class="font-medium text-white">{{ $enrollment->course->online_platform ?? 'Microsoft Teams' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-white/60">Certificate:</span>
                                        <span class="font-medium text-white">{{ str_replace('-', ' ', ucfirst($enrollment->course->certificate_type ?? 'completion-certificate')) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-xl font-bold text-white mb-6">Learning Objectives</h3>
                                <ul class="space-y-3">
                                    @foreach($enrollment->course->learning_objectives ?? [
                                        'Master modern web development frameworks',
                                        'Build full-stack applications',
                                        'Understand database design and management',
                                        'Deploy applications to cloud platforms',
                                        'Implement best practices in coding'
                                    ] as $objective)
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-white/80">{{ $objective }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Sessions Tab -->
                    <div x-show="activeTab === 'sessions'" x-transition:enter.duration.300ms>
                        <h3 class="text-xl font-bold text-white mb-6">Upcoming Sessions</h3>
                        <div class="grid gap-6">
                            <!-- Live Session -->
                            <div class="session-card live glass-card rounded-xl p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-3 h-3 bg-red-500 rounded-full live-indicator"></div>
                                        <h4 class="text-lg font-semibold text-white">Session 8: React Advanced Patterns</h4>
                                        <span class="px-2 py-1 bg-red-500 text-white text-xs rounded-full">LIVE NOW</span>
                                    </div>
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        Join Session
                                    </button>
                                </div>
                                <p class="text-white/70 mb-4">Advanced React patterns including render props, HOCs, and custom hooks.</p>
                                <div class="flex items-center space-x-6 text-sm text-white/60">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ date('M j, Y') }} • 2:00 PM - 4:00 PM
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        24 participants
                                    </div>
                                </div>
                            </div>

                            <!-- Upcoming Sessions -->
                            <div class="session-card upcoming glass-card rounded-xl p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-white">Session 9: Node.js and Express</h4>
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        Set Reminder
                                    </button>
                                </div>
                                <p class="text-white/70 mb-4">Building backend APIs with Node.js and Express framework.</p>
                                <div class="flex items-center space-x-6 text-sm text-white/60">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ date('M j, Y', strtotime('+3 days')) }} • 2:00 PM - 4:00 PM
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Pre-reading available
                                    </div>
                                </div>
                            </div>

                            <div class="session-card upcoming glass-card rounded-xl p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-white">Session 10: Database Integration</h4>
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        Set Reminder
                                    </button>
                                </div>
                                <p class="text-white/70 mb-4">Connecting your application to databases with MongoDB and PostgreSQL.</p>
                                <div class="flex items-center space-x-6 text-sm text-white/60">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ date('M j, Y', strtotime('+7 days')) }} • 2:00 PM - 4:00 PM
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Workshop session
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Materials Tab -->
                    <div x-show="activeTab === 'materials'" x-transition:enter.duration.300ms>
                        <h3 class="text-xl font-bold text-white mb-6">Course Materials</h3>
                        <div class="grid lg:grid-cols-2 gap-8">
                            <div>
                                <h4 class="text-lg font-semibold text-white mb-4">Course Resources</h4>
                                <div class="space-y-3">
                                    @foreach([
                                        ['Course Handbook & Syllabus', 'pdf', '2.4 MB'],
                                        ['Setup Guide & Prerequisites', 'pdf', '1.8 MB'],
                                        ['Code Templates & Boilerplates', 'zip', '15.2 MB'],
                                        ['Reference Materials', 'pdf', '3.1 MB'],
                                        ['Video Lectures Playlist', 'link', 'External']
                                    ] as $material)
                                        <div class="material-item flex items-center justify-between p-4 rounded-xl border border-white/10">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                                    @if($material[1] === 'pdf')
                                                        <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @elseif($material[1] === 'zip')
                                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-medium text-white">{{ $material[0] }}</p>
                                                    <p class="text-sm text-white/60">{{ $material[2] }}</p>
                                                </div>
                                            </div>
                                            <button class="text-blue-400 hover:text-blue-300 font-medium text-sm transition-colors">
                                                Download
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-lg font-semibold text-white mb-4">Session Recordings</h4>
                                <div class="space-y-3">
                                    @foreach([
                                        ['Session 7: React Hooks Deep Dive', '1:45:32', 'completed'],
                                        ['Session 6: State Management', '2:12:15', 'completed'],
                                        ['Session 5: Component Lifecycle', '1:58:43', 'completed'],
                                        ['Session 4: React Router', '1:32:18', 'completed'],
                                        ['Session 3: JSX and Components', '2:05:27', 'completed']
                                    ] as $recording)
                                        <div class="material-item flex items-center justify-between p-4 rounded-xl border border-white/10">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-white">{{ $recording[0] }}</p>
                                                    <p class="text-sm text-white/60">Duration: {{ $recording[1] }}</p>
                                                </div>
                                            </div>
                                            <button class="text-blue-400 hover:text-blue-300 font-medium text-sm transition-colors">
                                                Watch
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Assignments Tab -->
                    <div x-show="activeTab === 'assignments'" x-transition:enter.duration.300ms>
                        <h3 class="text-xl font-bold text-white mb-6">Assignments & Projects</h3>
                        <div class="space-y-6">
                            @foreach([
                                ['name' => 'Final Project: Full Stack E-commerce App', 'due' => 'Due in 12 days', 'status' => 'in_progress', 'points' => '100 pts'],
                                ['name' => 'Assignment 4: API Integration', 'due' => 'Due in 5 days', 'status' => 'pending', 'points' => '50 pts'],
                                ['name' => 'Assignment 3: React Components', 'due' => 'Submitted', 'status' => 'completed', 'points' => '45/50 pts'],
                                ['name' => 'Assignment 2: JavaScript Fundamentals', 'due' => 'Submitted', 'status' => 'completed', 'points' => '48/50 pts'],
                                ['name' => 'Assignment 1: HTML/CSS Portfolio', 'due' => 'Submitted', 'status' => 'completed', 'points' => '50/50 pts']
                            ] as $assignment)
                                <div class="glass-card rounded-xl p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-semibold text-white">{{ $assignment['name'] }}</h4>
                                        @if($assignment['status'] === 'completed')
                                            <span class="px-3 py-1 bg-green-900/80 text-green-300 border border-green-700/50 rounded-full text-sm">
                                                Completed
                                            </span>
                                        @elseif($assignment['status'] === 'in_progress')
                                            <span class="px-3 py-1 bg-yellow-900/80 text-yellow-300 border border-yellow-700/50 rounded-full text-sm">
                                                In Progress
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-blue-900/80 text-blue-300 border border-blue-700/50 rounded-full text-sm">
                                                Pending
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-white/60">{{ $assignment['due'] }}</span>
                                        <span class="font-medium text-white">{{ $assignment['points'] }}</span>
                                    </div>
                                    @if($assignment['status'] !== 'completed')
                                        <div class="mt-4 flex space-x-3">
                                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors">
                                                {{ $assignment['status'] === 'in_progress' ? 'Continue' : 'Start Assignment' }}
                                            </button>
                                            <button class="border border-white/20 text-white hover:bg-white/5 px-4 py-2 rounded-lg font-medium text-sm transition-colors">
                                                View Details
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Progress Tab -->
                    <div x-show="activeTab === 'progress'" x-transition:enter.duration.300ms>
                        <h3 class="text-xl font-bold text-white mb-6">Learning Progress</h3>
                        <div class="grid lg:grid-cols-2 gap-8">
                            <div>
                                <h4 class="text-lg font-semibold text-white mb-4">Overall Progress</h4>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <span class="text-white/80">Course Completion</span>
                                            <span class="font-medium text-white">35%</span>
                                        </div>
                                        <div class="w-full bg-white/10 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-blue-500 to-blue-400 h-2 rounded-full" style="width: 35%"></div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <span class="text-white/80">Assignments</span>
                                            <span class="font-medium text-white">3/5 Completed</span>
                                        </div>
                                        <div class="w-full bg-white/10 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-green-500 to-green-400 h-2 rounded-full" style="width: 60%"></div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="flex justify-between mb-2">
                                            <span class="text-white/80">Session Attendance</span>
                                            <span class="font-medium text-white">7/8 Attended</span>
                                        </div>
                                        <div class="w-full bg-white/10 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-purple-500 to-purple-400 h-2 rounded-full" style="width: 87%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-lg font-semibold text-white mb-4">Achievements</h4>
                                <div class="space-y-3">
                                    @foreach([
                                        ['Perfect Attendance Week 1', '🎯'],
                                        ['First Assignment Submitted', '📝'],
                                        ['Active Participant', '💬'],
                                        ['Quick Learner', '⚡']
                                    ] as $achievement)
                                        <div class="flex items-center space-x-3 p-3 rounded-lg bg-white/5">
                                            <span class="text-2xl">{{ $achievement[1] }}</span>
                                            <span class="font-medium text-white">{{ $achievement[0] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize progress ring animation
        document.addEventListener('DOMContentLoaded', function() {
            const progressRing = document.querySelector('.progress-ring-circle');
            const progress = 35; // This would come from your backend
            const circumference = 2 * Math.PI * 40; // radius = 40
            const strokeDashoffset = circumference - (progress / 100) * circumference;
            
            progressRing.style.strokeDashoffset = strokeDashoffset;
        });

        // Tab switching with animation
        document.addEventListener('alpine:init', () => {
            Alpine.data('coursePage', () => ({
                activeTab: 'overview'
            }));
        });
    </script>

</body>
</html>