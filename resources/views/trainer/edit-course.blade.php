<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course - Trainer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-8">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold">
                            A
                        </div>
                        <span class="ml-3 text-xl font-semibold text-gray-900">AMEX Trainer Portal</span>
                    </div>
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('trainer.dashboard') }}" class="text-gray-600 hover:text-gray-900 transition-colors">
                            <i class="fas fa-chart-line mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('trainer.courses') }}" class="text-blue-600 font-medium">
                            <i class="fas fa-book mr-2"></i>Courses
                        </a>
                        <a href="{{ route('trainer.trainees') }}" class="text-gray-600 hover:text-gray-900 transition-colors">
                            <i class="fas fa-users mr-2"></i>Trainees
                        </a>
                        <a href="{{ route('trainer.sessions') }}" class="text-gray-600 hover:text-gray-900 transition-colors">
                            <i class="fas fa-calendar mr-2"></i>Sessions
                        </a>
                        <a href="{{ route('trainer.feedback') }}" class="text-gray-600 hover:text-gray-900 transition-colors">
                            <i class="fas fa-comments mr-2"></i>Feedback
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bell text-lg"></i>
                    </button>
                    <div class="flex items-center space-x-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=ffffff" 
                             alt="Profile" class="w-8 h-8 rounded-full">
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Course</h1>
                    <p class="text-gray-600 mt-2">Update course information and settings</p>
                </div>
                <a href="{{ route('trainer.courses') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Courses
                </a>
            </div>
        </div>

        <!-- Edit Course Form -->
        <form action="{{ route('trainer.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Basic Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course Title *</label>
                        <input type="text" name="title" value="{{ old('title', $course->title) }}" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course Description *</label>
                        <textarea name="description" rows="4" required 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $course->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select name="category" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="hybrid" {{ old('venue_type', $course->venue_type) === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                        @error('venue_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Physical Venue Fields -->
                    <div id="physical_venue_fields" class="space-y-4" style="display: {{ old('venue_type', $course->venue_type) === 'physical' || old('venue_type', $course->venue_type) === 'hybrid' ? 'block' : 'none' }}">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Venue Name</label>
                            <input type="text" name="venue_name" value="{{ old('venue_name', $course->venue_name) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Venue Address</label>
                            <textarea name="venue_address" rows="2" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('venue_address', $course->venue_address) }}</textarea>
                        </div>
                    </div>

                    <!-- Online Platform Field -->
                    <div id="online_platform_field" style="display: {{ old('venue_type', $course->venue_type) === 'online' || old('venue_type', $course->venue_type) === 'hybrid' ? 'block' : 'none' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Online Platform</label>
                        <select name="online_platform" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Platform</option>
                            <option value="zoom" {{ old('online_platform', $course->online_platform) === 'zoom' ? 'selected' : '' }}>Zoom</option>
                            <option value="teams" {{ old('online_platform', $course->online_platform) === 'teams' ? 'selected' : '' }}>Microsoft Teams</option>
                            <option value="webex" {{ old('online_platform', $course->online_platform) === 'webex' ? 'selected' : '' }}>Cisco Webex</option>
                            <option value="google-meet" {{ old('online_platform', $course->online_platform) === 'google-meet' ? 'selected' : '' }}>Google Meet</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Schedule -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Schedule</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Training Days</label>
                        <div class="space-y-2">
                            @php $scheduleDays = old('schedule_days', $course->schedule['days'] ?? []); @endphp
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <label class="flex items-center">
                                    <input type="checkbox" name="schedule_days[]" value="{{ $day }}" 
                                           {{ in_array($day, $scheduleDays) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Training Time</label>
                        <input type="text" name="schedule_time" value="{{ old('schedule_time', $course->schedule['time'] ?? '') }}" 
                               placeholder="e.g., 10:00-12:00" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Course Content -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Course Content</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course Outline</label>
                        <textarea name="course_outline" rows="6" 
                                  placeholder="Detailed week-by-week breakdown of the course content..." 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('course_outline', $course->course_outline) }}</textarea>
                    </div>

                    <!-- Prerequisites -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prerequisites</label>
                        <div id="prerequisites-container">
                            @php $prerequisites = old('prerequisites', $course->prerequisites ?? []); @endphp
                            @if(count($prerequisites) > 0)
                                @foreach($prerequisites as $index => $prerequisite)
                                    <div class="flex items-center space-x-2 mb-2 prerequisite-item">
                                        <input type="text" name="prerequisites[]" value="{{ $prerequisite }}" 
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <button type="button" onclick="removeItem(this)" 
                                                class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center space-x-2 mb-2 prerequisite-item">
                                    <input type="text" name="prerequisites[]" 
                                           placeholder="Enter a prerequisite..." 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <button type="button" onclick="removeItem(this)" 
                                            class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" onclick="addPrerequisite()" 
                                class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add Prerequisite
                        </button>
                    </div>

                    <!-- Learning Objectives -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Learning Objectives</label>
                        <div id="objectives-container">
                            @php $objectives = old('learning_objectives', $course->learning_objectives ?? []); @endphp
                            @if(count($objectives) > 0)
                                @foreach($objectives as $index => $objective)
                                    <div class="flex items-center space-x-2 mb-2 objective-item">
                                        <input type="text" name="learning_objectives[]" value="{{ $objective }}" 
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <button type="button" onclick="removeItem(this)" 
                                                class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center space-x-2 mb-2 objective-item">
                                    <input type="text" name="learning_objectives[]" 
                                           placeholder="Enter a learning objective..." 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <button type="button" onclick="removeItem(this)" 
                                            class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" onclick="addObjective()" 
                                class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add Objective
                        </button>
                    </div>
                </div>
            </div>

            <!-- Materials & Resources -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Materials & Resources</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Materials -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course Materials</label>
                        <div id="materials-container">
                            @php $materials = old('materials', $course->materials ?? []); @endphp
                            @if(count($materials) > 0)
                                @foreach($materials as $index => $material)
                                    <div class="flex items-center space-x-2 mb-2 material-item">
                                        <input type="text" name="materials[]" value="{{ $material }}" 
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <button type="button" onclick="removeItem(this)" 
                                                class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center space-x-2 mb-2 material-item">
                                    <input type="text" name="materials[]" 
                                           placeholder="Enter course material..." 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <button type="button" onclick="removeItem(this)" 
                                            class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" onclick="addMaterial()" 
                                class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add Material
                        </button>
                    </div>

                    <!-- Resources -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Additional Resources</label>
                        <div id="resources-container">
                            @php $resources = old('resources', $course->resources ?? []); @endphp
                            @if(count($resources) > 0)
                                @foreach($resources as $index => $resource)
                                    <div class="flex items-center space-x-2 mb-2 resource-item">
                                        <input type="text" name="resources[]" value="{{ $resource }}" 
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <button type="button" onclick="removeItem(this)" 
                                                class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center space-x-2 mb-2 resource-item">
                                    <input type="text" name="resources[]" 
                                           placeholder="Enter additional resource..." 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <button type="button" onclick="removeItem(this)" 
                                            class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" onclick="addResource()" 
                                class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add Resource
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tags & Targeting -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Tags & Target Audience</h3>
                
                <div class="space-y-6">
                    <!-- Tags -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course Tags</label>
                        <div id="tags-container">
                            @php $tags = old('tags', $course->tags ?? []); @endphp
                            @if(count($tags) > 0)
                                @foreach($tags as $index => $tag)
                                    <div class="flex items-center space-x-2 mb-2 tag-item">
                                        <input type="text" name="tags[]" value="{{ $tag }}" 
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <button type="button" onclick="removeItem(this)" 
                                                class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center space-x-2 mb-2 tag-item">
                                    <input type="text" name="tags[]" 
                                           placeholder="Enter a tag..." 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <button type="button" onclick="removeItem(this)" 
                                            class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" onclick="addTag()" 
                                class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add Tag
                        </button>
                    </div>

                    <!-- Target Departments -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Target Departments</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @php $targetDepts = old('target_departments', $course->target_departments ?? []); @endphp
                            @foreach(['IT', 'HR', 'Finance', 'Marketing', 'Sales', 'Operations', 'Legal', 'Executive', 'All Departments'] as $dept)
                                <label class="flex items-center">
                                    <input type="checkbox" name="target_departments[]" value="{{ $dept }}" 
                                           {{ in_array($dept, $targetDepts) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $dept }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Target Levels -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Target Levels</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            @php $targetLevels = old('target_levels', $course->target_levels ?? []); @endphp
                            @foreach(['junior', 'mid', 'senior', 'executive'] as $level)
                                <label class="flex items-center">
                                    <input type="checkbox" name="target_levels[]" value="{{ $level }}" 
                                           {{ in_array($level, $targetLevels) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ ucfirst($level) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Course Settings</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="draft" {{ old('status', $course->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $course->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status', $course->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    <div class="space-y-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active', $course->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Course is Active</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" name="is_featured" value="1" 
                                   {{ old('is_featured', $course->is_featured) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Featured Course</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" name="is_mandatory" value="1" 
                                   {{ old('is_mandatory', $course->is_mandatory) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Mandatory Course</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" name="requires_approval" value="1" 
                                   {{ old('requires_approval', $course->requires_approval) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Requires Approval</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('trainer.courses') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" name="action" value="save_draft" 
                            class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Save as Draft
                    </button>
                    <button type="submit" name="action" value="publish" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-rocket mr-2"></i>Update & Publish
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Toggle venue fields based on venue type
        function toggleVenueFields() {
            const venueType = document.getElementById('venue_type').value;
            const physicalFields = document.getElementById('physical_venue_fields');
            const onlineField = document.getElementById('online_platform_field');
            
            if (venueType === 'physical') {
                physicalFields.style.display = 'block';
                onlineField.style.display = 'none';
            } else if (venueType === 'online') {
                physicalFields.style.display = 'none';
                onlineField.style.display = 'block';
            } else if (venueType === 'hybrid') {
                physicalFields.style.display = 'block';
                onlineField.style.display = 'block';
            } else {
                physicalFields.style.display = 'none';
                onlineField.style.display = 'none';
            }
        }

        // Dynamic field management functions
        function addPrerequisite() {
            const container = document.getElementById('prerequisites-container');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2 prerequisite-item';
            div.innerHTML = `
                <input type="text" name="prerequisites[]" 
                       placeholder="Enter a prerequisite..." 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="button" onclick="removeItem(this)" 
                        class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function addObjective() {
            const container = document.getElementById('objectives-container');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2 objective-item';
            div.innerHTML = `
                <input type="text" name="learning_objectives[]" 
                       placeholder="Enter a learning objective..." 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="button" onclick="removeItem(this)" 
                        class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function addMaterial() {
            const container = document.getElementById('materials-container');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2 material-item';
            div.innerHTML = `
                <input type="text" name="materials[]" 
                       placeholder="Enter course material..." 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="button" onclick="removeItem(this)" 
                        class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function addResource() {
            const container = document.getElementById('resources-container');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2 resource-item';
            div.innerHTML = `
                <input type="text" name="resources[]" 
                       placeholder="Enter additional resource..." 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="button" onclick="removeItem(this)" 
                        class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function addTag() {
            const container = document.getElementById('tags-container');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2 tag-item';
            div.innerHTML = `
                <input type="text" name="tags[]" 
                       placeholder="Enter a tag..." 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="button" onclick="removeItem(this)" 
                        class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function removeItem(button) {
            button.closest('.flex').remove();
        }

        // Initialize venue fields on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleVenueFields();
        });
    </script>
</body>
</html> 