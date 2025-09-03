<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course - Trainer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-black">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <a href="#" class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-4xl font-bold text-white">Create New Course</h1>
                    <p class="text-gray-300">Build a comprehensive training course for your trainees</p>
                </div>
            </div>
        </div>

        <!-- Error Display -->
        <div id="errorDisplay" class="hidden bg-red-500/10 border border-red-500/20 rounded-lg p-4 mb-6">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-red-400 font-medium" id="errorMessage"></span>
            </div>
        </div>

        <!-- Course Creation Form -->
        <form action="#" method="POST" class="space-y-8" id="courseForm">
            
            <!-- Basic Information -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Basic Information
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Course Title -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Course Title *</label>
                        <input type="text" name="title" required 
                               class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                               placeholder="Enter course title...">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
                        <select name="category" required 
                                class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all">
                            <option value="">Select Category</option>
                            <option value="technical">Technical</option>
                            <option value="leadership">Leadership</option>
                            <option value="compliance">Compliance</option>
                            <option value="soft-skills">Soft Skills</option>
                            <option value="business">Business</option>
                            <option value="safety">Safety</option>
                        </select>
                    </div>

                    <!-- Course Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Course Type *</label>
                        <select name="course_type" required 
                                class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all">
                            <option value="">Select Type</option>
                            <option value="in-person">In-Person</option>
                            <option value="online">Online</option>
                            <option value="hybrid">Hybrid</option>
                        </select>
                    </div>

                    <!-- Difficulty Level -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Difficulty Level *</label>
                        <select name="difficulty_level" required 
                                class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all">
                            <option value="">Select Level</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                            <option value="expert">Expert</option>
                            <option value="essential">Essential</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Price ($) *</label>
                        <input type="number" name="price" required min="0" step="0.01"
                               class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                               placeholder="0.00">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Course Description *</label>
                        <textarea name="description" required rows="4"
                                  class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                                  placeholder="Describe what this course covers..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Duration & Capacity -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Duration & Capacity
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Duration (Weeks) *</label>
                        <input type="number" name="duration_weeks" required min="1"
                               class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                               placeholder="8">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Duration (Hours) *</label>
                        <input type="number" name="duration_hours" required min="1"
                               class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                               placeholder="40">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Max Participants *</label>
                        <input type="number" name="max_participants" required min="1"
                               class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                               placeholder="25">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Min Participants *</label>
                        <input type="number" name="min_participants" required min="1"
                               class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                               placeholder="5">
                    </div>
                </div>
            </div>

            <!-- Schedule & Dates -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Schedule & Dates
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Enrollment Start Date *</label>
                        <input type="datetime-local" name="enrollment_start_date" required
                               class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Enrollment End Date *</label>
                        <input type="datetime-local" name="enrollment_end_date" required
                               class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Course Start Date *</label>
                        <input type="datetime-local" name="start_date" required
                               class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Course End Date *</label>
                        <input type="datetime-local" name="end_date" required
                               class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all">
                    </div>
                </div>

                <!-- Date Validation Hints -->
                <div class="mt-4 p-4 bg-blue-500/10 rounded-lg border border-blue-500/20">
                    <div class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-sm text-blue-300">
                            <p class="font-medium mb-1">Date Requirements:</p>
                            <ul class="space-y-1 text-xs">
                                <li>• Enrollment start date must be before enrollment end date</li>
                                <li>• Course start date must be after enrollment start date</li>
                                <li>• Course end date must be after course start date</li>
                                <li>• Enrollment should typically end before or on course start date</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Schedule Days & Time -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-300 mb-4">Weekly Schedule</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Days of the Week</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="flex items-center space-x-2 text-sm text-gray-300">
                                    <input type="checkbox" name="schedule[days][]" value="Monday"
                                           class="rounded bg-white/5 border-white/20 text-blue-500 focus:ring-blue-400 focus:ring-2">
                                    <span>Monday</span>
                                </label>
                                <label class="flex items-center space-x-2 text-sm text-gray-300">
                                    <input type="checkbox" name="schedule[days][]" value="Tuesday"
                                           class="rounded bg-white/5 border-white/20 text-blue-500 focus:ring-blue-400 focus:ring-2">
                                    <span>Tuesday</span>
                                </label>
                                <label class="flex items-center space-x-2 text-sm text-gray-300">
                                    <input type="checkbox" name="schedule[days][]" value="Wednesday"
                                           class="rounded bg-white/5 border-white/20 text-blue-500 focus:ring-blue-400 focus:ring-2">
                                    <span>Wednesday</span>
                                </label>
                                <label class="flex items-center space-x-2 text-sm text-gray-300">
                                    <input type="checkbox" name="schedule[days][]" value="Thursday"
                                           class="rounded bg-white/5 border-white/20 text-blue-500 focus:ring-blue-400 focus:ring-2">
                                    <span>Thursday</span>
                                </label>
                                <label class="flex items-center space-x-2 text-sm text-gray-300">
                                    <input type="checkbox" name="schedule[days][]" value="Friday"
                                           class="rounded bg-white/5 border-white/20 text-blue-500 focus:ring-blue-400 focus:ring-2">
                                    <span>Friday</span>
                                </label>
                                <label class="flex items-center space-x-2 text-sm text-gray-300">
                                    <input type="checkbox" name="schedule[days][]" value="Saturday"
                                           class="rounded bg-white/5 border-white/20 text-blue-500 focus:ring-blue-400 focus:ring-2">
                                    <span>Saturday</span>
                                </label>
                                <label class="flex items-center space-x-2 text-sm text-gray-300">
                                    <input type="checkbox" name="schedule[days][]" value="Sunday"
                                           class="rounded bg-white/5 border-white/20 text-blue-500 focus:ring-blue-400 focus:ring-2">
                                    <span>Sunday</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Time</label>
                            <input type="text" name="schedule[time]" placeholder="e.g., 09:00-17:00"
                                   class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Venue Information -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Venue Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Venue Type *</label>
                        <select name="venue_type" required 
                                class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all">
                            <option value="">Select Venue Type</option>
                            <option value="physical">Physical Location</option>
                            <option value="online">Online</option>
                            <option value="hybrid">Hybrid</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Venue Name</label>
                        <input type="text" name="venue_name"
                               class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                               placeholder="Training Center A">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Venue Address</label>
                        <textarea name="venue_address" rows="3"
                                  class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                                  placeholder="Full address of the venue..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Prerequisites & Learning Objectives -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Prerequisites & Learning Objectives
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Prerequisites</label>
                        <div id="prerequisitesContainer">
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="text" name="prerequisites[]" 
                                       class="flex-1 bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                                       placeholder="Enter prerequisite...">
                                <button type="button" onclick="addPrerequisite()" 
                                        class="bg-blue-500/20 text-blue-400 px-3 py-2 rounded-lg hover:bg-blue-500/30 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Learning Objectives</label>
                        <div id="objectivesContainer">
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="text" name="learning_objectives[]" 
                                       class="flex-1 bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                                       placeholder="Enter learning objective...">
                                <button type="button" onclick="addObjective()" 
                                        class="bg-green-500/20 text-green-400 px-3 py-2 rounded-lg hover:bg-green-500/30 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materials & Resources -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Materials & Resources
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Course Materials</label>
                        <div id="materialsContainer">
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="text" name="materials[]" 
                                       class="flex-1 bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                                       placeholder="Enter material...">
                                <button type="button" onclick="addMaterial()" 
                                        class="bg-purple-500/20 text-purple-400 px-3 py-2 rounded-lg hover:bg-purple-500/30 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Additional Resources</label>
                        <div id="resourcesContainer">
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="text" name="resources[]" 
                                       class="flex-1 bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                                       placeholder="Enter resource...">
                                <button type="button" onclick="addResource()" 
                                        class="bg-orange-500/20 text-orange-400 px-3 py-2 rounded-lg hover:bg-orange-500/30 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tags -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Tags</label>
                    <div id="tagsContainer">
                        <div class="flex items-center space-x-2 mb-2">
                            <input type="text" name="tags[]" 
                                   class="flex-1 bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                                   placeholder="Enter tag...">
                            <button type="button" onclick="addTag()" 
                                    class="bg-teal-500/20 text-teal-400 px-3 py-2 rounded-lg hover:bg-teal-500/30 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Settings -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Course Settings
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="requires_approval" value="1"
                               class="rounded bg-white/5 border-white/20 text-blue-500 focus:ring-blue-400 focus:ring-2">
                        <div>
                            <label class="text-sm font-medium text-gray-300">Requires Approval</label>
                            <p class="text-xs text-gray-500">Enrollments need manual approval</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="is_featured" value="1"
                               class="rounded bg-white/5 border-white/20 text-blue-500 focus:ring-blue-400 focus:ring-2">
                        <div>
                            <label class="text-sm font-medium text-gray-300">Featured Course</label>
                            <p class="text-xs text-gray-500">Display prominently on course list</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="is_mandatory" value="1"
                               class="rounded bg-white/5 border-white/20 text-blue-500 focus:ring-blue-400 focus:ring-2">
                        <div>
                            <label class="text-sm font-medium text-gray-300">Mandatory Course</label>
                            <p class="text-xs text-gray-500">Required for certain employees</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6">
                <a href="#" class="bg-gray-500/20 hover:bg-gray-500/30 text-gray-300 font-medium py-3 px-6 rounded-lg transition-all duration-300">
                    Cancel
                </a>
                
                <div class="flex space-x-4">
                    <button type="submit" name="action" value="draft"
                            class="bg-gray-600/20 hover:bg-gray-600/30 text-gray-300 font-medium py-3 px-6 rounded-lg transition-all duration-300">
                        Save as Draft
                    </button>
                    <button type="submit" name="action" value="publish"
                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25">
                        Create Course
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Function to display error messages
        function showError(message) {
            const errorDisplay = document.getElementById('errorDisplay');
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.textContent = message;
            errorDisplay.classList.remove('hidden');
            
            // Scroll to error message
            errorDisplay.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                errorDisplay.classList.add('hidden');
            }, 5000);
        }

        // Function to hide error messages
        function hideError() {
            const errorDisplay = document.getElementById('errorDisplay');
            errorDisplay.classList.add('hidden');
        }

        // Real-time date validation
        function validateDates() {
            const enrollmentStartDate = new Date(document.querySelector('input[name="enrollment_start_date"]').value);
            const enrollmentEndDate = new Date(document.querySelector('input[name="enrollment_end_date"]').value);
            const courseStartDate = new Date(document.querySelector('input[name="start_date"]').value);
            const courseEndDate = new Date(document.querySelector('input[name="end_date"]').value);
            const now = new Date();

            // Clear previous error styles
            document.querySelectorAll('input[type="datetime-local"]').forEach(input => {
                input.classList.remove('border-red-400', 'ring-red-400');
            });

            let isValid = true;
            let errorMessage = '';

            // Check if enrollment start date is in the past
            if (enrollmentStartDate && enrollmentStartDate < now) {
                errorMessage = 'Enrollment start date cannot be in the past';
                document.querySelector('input[name="enrollment_start_date"]').classList.add('border-red-400', 'ring-red-400');
                isValid = false;
            }

            // Check enrollment dates order
            if (enrollmentStartDate && enrollmentEndDate && enrollmentStartDate >= enrollmentEndDate) {
                errorMessage = 'Enrollment end date must be after enrollment start date';
                document.querySelector('input[name="enrollment_end_date"]').classList.add('border-red-400', 'ring-red-400');
                isValid = false;
            }

            // Check if course start date is before enrollment start date
            if (courseStartDate && enrollmentStartDate && courseStartDate < enrollmentStartDate) {
                errorMessage = 'Course start date should not be before enrollment start date';
                document.querySelector('input[name="start_date"]').classList.add('border-red-400', 'ring-red-400');
                isValid = false;
            }

            // Check course dates order
            if (courseStartDate && courseEndDate && courseStartDate >= courseEndDate) {
                errorMessage = 'Course end date must be after course start date';
                document.querySelector('input[name="end_date"]').classList.add('border-red-400', 'ring-red-400');
                isValid = false;
            }

            // Show/hide error message
            if (!isValid && errorMessage) {
                showError(errorMessage);
            } else {
                hideError();
            }

            return isValid;
        }

        // Add event listeners for real-time validation
        document.querySelectorAll('input[type="datetime-local"]').forEach(input => {
            input.addEventListener('change', validateDates);
            input.addEventListener('blur', validateDates);
        });

        function addPrerequisite() {
            const container = document.getElementById('prerequisitesContainer');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2';
            div.innerHTML = `
                <input type="text" name="prerequisites[]" 
                       class="flex-1 bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                       placeholder="Enter prerequisite...">
                <button type="button" onclick="this.parentElement.remove()" 
                        class="bg-red-500/20 text-red-400 px-3 py-2 rounded-lg hover:bg-red-500/30 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        }

        function addObjective() {
            const container = document.getElementById('objectivesContainer');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2';
            div.innerHTML = `
                <input type="text" name="learning_objectives[]" 
                       class="flex-1 bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                       placeholder="Enter learning objective...">
                <button type="button" onclick="this.parentElement.remove()" 
                        class="bg-red-500/20 text-red-400 px-3 py-2 rounded-lg hover:bg-red-500/30 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        }

        function addMaterial() {
            const container = document.getElementById('materialsContainer');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2';
            div.innerHTML = `
                <input type="text" name="materials[]" 
                       class="flex-1 bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                       placeholder="Enter material...">
                <button type="button" onclick="this.parentElement.remove()" 
                        class="bg-red-500/20 text-red-400 px-3 py-2 rounded-lg hover:bg-red-500/30 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        }

        function addResource() {
            const container = document.getElementById('resourcesContainer');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2';
            div.innerHTML = `
                <input type="text" name="resources[]" 
                       class="flex-1 bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                       placeholder="Enter resource...">
                <button type="button" onclick="this.parentElement.remove()" 
                        class="bg-red-500/20 text-red-400 px-3 py-2 rounded-lg hover:bg-red-500/30 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        }

        function addTag() {
            const container = document.getElementById('tagsContainer');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2';
            div.innerHTML = `
                <input type="text" name="tags[]" 
                       class="flex-1 bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all"
                       placeholder="Enter tag...">
                <button type="button" onclick="this.parentElement.remove()" 
                        class="bg-red-500/20 text-red-400 px-3 py-2 rounded-lg hover:bg-red-500/30 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        }

        // Form validation on submit
        document.getElementById('courseForm').addEventListener('submit', function(e) {
            const enrollmentStartDate = new Date(document.querySelector('input[name="enrollment_start_date"]').value);
            const enrollmentEndDate = new Date(document.querySelector('input[name="enrollment_end_date"]').value);
            const courseStartDate = new Date(document.querySelector('input[name="start_date"]').value);
            const courseEndDate = new Date(document.querySelector('input[name="end_date"]').value);
            const now = new Date();

            let isValid = true;
            let errorMessage = '';

            // Validate enrollment start date is not in the past
            if (enrollmentStartDate < now) {
                errorMessage = 'Enrollment start date cannot be in the past';
                isValid = false;
            }

            // Validate enrollment dates order
            if (enrollmentStartDate >= enrollmentEndDate) {
                errorMessage = 'Enrollment end date must be after enrollment start date';
                isValid = false;
            }

            // Validate course start date is after enrollment start
            if (courseStartDate < enrollmentStartDate) {
                errorMessage = 'Course start date should be after enrollment start date';
                isValid = false;
            }

            // Validate course dates order
            if (courseStartDate >= courseEndDate) {
                errorMessage = 'Course end date must be after course start date';
                isValid = false;
            }

            // Validate participant numbers
            const maxParticipants = parseInt(document.querySelector('input[name="max_participants"]').value);
            const minParticipants = parseInt(document.querySelector('input[name="min_participants"]').value);

            if (minParticipants >= maxParticipants) {
                errorMessage = 'Maximum participants must be greater than minimum participants';
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                showError(errorMessage);
                return false;
            }

            // If validation passes, hide any existing errors
            hideError();
            return true;
        });

        // Set minimum datetime for enrollment start to current datetime
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const currentDateTime = now.toISOString().slice(0, 16);
            document.querySelector('input[name="enrollment_start_date"]').min = currentDateTime;
        });
    </script>
</body>
</html>