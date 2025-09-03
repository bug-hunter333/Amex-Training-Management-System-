<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Session</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('trainer.sessions.index') }}" 
                       class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Edit Session</h1>
                        <p class="mt-2 text-gray-600">Update session details</p>
                    </div>
                </div>
            </div>

            <!-- Current Session Info Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-blue-800">Current Session Status</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p><strong>Course:</strong> {{ $session->course->title }}</p>
                            <p><strong>Current Status:</strong> 
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($session->status == 'scheduled') bg-yellow-100 text-yellow-800
                                    @elseif($session->status == 'ongoing') bg-green-100 text-green-800
                                    @elseif($session->status == 'completed') bg-blue-100 text-blue-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($session->status) }}
                                </span>
                            </p>
                            <p><strong>Date:</strong> {{ $session->session_date->format('M d, Y') }} at {{ $session->start_time->format('g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <form action="{{ route('trainer.sessions.update', $session) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Course Selection (Read-only display) -->
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                            <div class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-gray-700">
                                {{ $session->course->title }}
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Course cannot be changed after session creation</p>
                        </div>

                        <!-- Session Title -->
                        <div class="lg:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Session Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" required
                                   value="{{ old('title', $session->title) }}"
                                   placeholder="e.g., Introduction to React Components"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Topic -->
                        <div class="lg:col-span-2">
                            <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">
                                Topic/Subject
                            </label>
                            <input type="text" name="topic" id="topic"
                                   value="{{ old('topic', $session->topic) }}"
                                   placeholder="e.g., React Fundamentals"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('topic')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Schedule Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Schedule Information</h3>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Session Date -->
                            <div>
                                <label for="session_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Session Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="session_date" id="session_date" required
                                       value="{{ old('session_date', $session->session_date->format('Y-m-d')) }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('session_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Time -->
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Start Time <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="start_time" id="start_time" required
                                       value="{{ old('start_time', $session->start_time->format('H:i')) }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('start_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Time -->
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    End Time <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="end_time" id="end_time" required
                                       value="{{ old('end_time', $session->end_time->format('H:i')) }}"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('end_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Session Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Session Details</h3>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Session Type -->
                            <div>
                                <label for="session_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Session Type <span class="text-red-500">*</span>
                                </label>
                                <select name="session_type" id="session_type" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select type...</option>
                                    <option value="live" {{ old('session_type', $session->session_type) == 'live' ? 'selected' : '' }}>Live Session</option>
                                    <option value="recorded" {{ old('session_type', $session->session_type) == 'recorded' ? 'selected' : '' }}>Recorded Session</option>
                                    <option value="assignment" {{ old('session_type', $session->session_type) == 'assignment' ? 'selected' : '' }}>Assignment</option>
                                    <option value="quiz" {{ old('session_type', $session->session_type) == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                </select>
                                @error('session_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="scheduled" {{ old('status', $session->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="ongoing" {{ old('status', $session->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ old('status', $session->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status', $session->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Meeting Link -->
                            <div>
                                <label for="meeting_link" class="block text-sm font-medium text-gray-700 mb-2">
                                    Meeting Link
                                </label>
                                <input type="url" name="meeting_link" id="meeting_link"
                                       value="{{ old('meeting_link', $session->meeting_link) }}"
                                       placeholder="https://zoom.us/j/..."
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('meeting_link')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Session Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  placeholder="Describe what will be covered in this session..."
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $session->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Materials -->
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Session Materials
                        </label>
                        <p class="text-sm text-gray-500 mb-4">Add links to materials, resources, or documents for this session.</p>
                        
                        <div id="materials-container">
                            @if(old('materials') || $session->materials)
                                @php
                                    $materials = old('materials', $session->materials ?? []);
                                @endphp
                                @foreach($materials as $material)
                                    <div class="material-item flex items-center space-x-2 mb-3">
                                        <input type="text" name="materials[]" 
                                               value="{{ $material }}"
                                               placeholder="Enter material link or description..."
                                               class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <button type="button" onclick="removeMaterial(this)" 
                                                class="text-red-600 hover:text-red-800 p-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="material-item flex items-center space-x-2 mb-3">
                                    <input type="text" name="materials[]" 
                                           placeholder="Enter material link or description..."
                                           class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <button type="button" onclick="removeMaterial(this)" 
                                            class="text-red-600 hover:text-red-800 p-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                        
                        <button type="button" onclick="addMaterial()" 
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 hover:text-blue-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Another Material
                        </button>
                    </div>

                    <!-- Notes -->
                    <div class="mb-8">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Trainer Notes
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                                  placeholder="Add any private notes for this session..."
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes', $session->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('trainer.sessions.index') }}" 
                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            
                            <!-- Quick Action Buttons -->
                            @if($session->status == 'scheduled' && $session->isToday())
                                <form action="{{ route('trainer.sessions.start', $session) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Start Session
                                    </button>
                                </form>
                            @endif

                            @if($session->status == 'ongoing')
                                <form action="{{ route('trainer.sessions.complete', $session) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Mark Complete
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Session
                        </button>
                    </div>
                </form>
            </div>

            <!-- Danger Zone -->
            @if($session->status != 'completed')
            <div class="mt-8 bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-red-800">Danger Zone</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>These actions cannot be undone. Please proceed with caution.</p>
                        </div>
                        <div class="mt-4 flex space-x-4">
                            @if($session->status != 'cancelled')
                            <form action="{{ route('trainer.sessions.cancel', $session) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to cancel this session?')"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 bg-red-100 border border-red-300 rounded-lg hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Cancel Session
                                </button>
                            </form>
                            @endif
                            
                            <form action="{{ route('trainer.sessions.destroy', $session) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this session? This action cannot be undone.')"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 bg-red-100 border border-red-300 rounded-lg hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Delete Session
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        function addMaterial() {
            const container = document.getElementById('materials-container');
            const materialItem = document.createElement('div');
            materialItem.className = 'material-item flex items-center space-x-2 mb-3';
            materialItem.innerHTML = `
                <input type="text" name="materials[]" 
                       placeholder="Enter material link or description..."
                       class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <button type="button" onclick="removeMaterial(this)" 
                        class="text-red-600 hover:text-red-800 p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            `;
            container.appendChild(materialItem);
        }

        function removeMaterial(button) {
            const container = document.getElementById('materials-container');
            if (container.children.length > 1) {
                button.closest('.material-item').remove();
            }
        }

        // Show/hide meeting link based on session type
        document.getElementById('session_type').addEventListener('change', function() {
            const meetingLinkContainer = document.getElementById('meeting_link').closest('div');
            if (this.value === 'live') {
                meetingLinkContainer.style.display = 'block';
            } else {
                meetingLinkContainer.style.display = 'none';
            }
        });

        // Initialize meeting link visibility
        document.addEventListener('DOMContentLoaded', function() {
            const sessionType = document.getElementById('session_type').value;
            const meetingLinkContainer = document.getElementById('meeting_link').closest('div');
            if (sessionType !== 'live') {
                meetingLinkContainer.style.display = 'none';
            }
        });
    </script>
</body>
</html>