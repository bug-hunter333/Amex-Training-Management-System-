<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Trainees - Trainer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-black">
        <div class="container mx-auto px-6 py-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Manage Trainees</h1>
                    <p class="text-gray-300">Review and manage trainee enrollments across your courses</p>
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
                            @foreach(Auth::user()->courses ?? [] as $course)
                                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Filter by Status</label>
                        <select name="status" class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white focus:border-blue-400 transition-all">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Search Trainee</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Name or email..."
                               class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:border-blue-400 transition-all">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition-colors">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm">Total Enrollments</p>
                            <p class="text-2xl font-bold text-white">{{ $enrollments->total() }}</p>
                        </div>
                        <div class="bg-blue-500/20 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm">Approved</p>
                            <p class="text-2xl font-bold text-green-400">{{ $enrollments->where('status', 'approved')->count() }}</p>
                        </div>
                        <div class="bg-green-500/20 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm">Pending</p>
                            <p class="text-2xl font-bold text-yellow-400">{{ $enrollments->where('status', 'pending')->count() }}</p>
                        </div>
                        <div class="bg-yellow-500/20 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm">Rejected</p>
                            <p class="text-2xl font-bold text-red-400">{{ $enrollments->where('status', 'rejected')->count() }}</p>
                        </div>
                        <div class="bg-red-500/20 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrollments Table -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 overflow-hidden">
                <div class="p-6 border-b border-white/10">
                    <h2 class="text-xl font-semibold text-white">Trainee Enrollments</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/5">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Trainee</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Course</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Enrolled Date</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Progress</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($enrollments as $enrollment)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mr-4">
                                                <span class="text-white font-semibold text-sm">
                                                    {{ strtoupper(substr($enrollment->trainee_name, 0, 2)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="text-white font-medium">{{ $enrollment->trainee_name }}</div>
                                                <div class="text-gray-400 text-sm">{{ $enrollment->trainee_email }}</div>
                                                @if($enrollment->trainee_phone)
                                                    <div class="text-gray-500 text-xs">{{ $enrollment->trainee_phone }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-white font-medium">{{ $enrollment->course->title }}</div>
                                        <div class="text-gray-400 text-sm">{{ ucfirst($enrollment->course->category) }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ 
                                            $enrollment->status === 'approved' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 
                                            ($enrollment->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30') 
                                        }}">
                                            {{ ucfirst($enrollment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-300 text-sm">
                                        {{ $enrollment->enrollment_date ? $enrollment->enrollment_date->format('M j, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-700 rounded-full h-2 mr-3">
                                                <div class="bg-blue-500 h-2 rounded-full" 
                                                     style="width: {{ $enrollment->progress_percentage ?? 0 }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-300">{{ $enrollment->progress_percentage ?? 0 }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            @if($enrollment->status === 'pending')
                                                <form method="POST" action="{{ route('trainer.trainees.update-status', $enrollment) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" 
                                                            class="bg-green-500/20 text-green-400 px-3 py-1 rounded-md text-sm hover:bg-green-500/30 transition-colors">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('trainer.trainees.update-status', $enrollment) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" 
                                                            class="bg-red-500/20 text-red-400 px-3 py-1 rounded-md text-sm hover:bg-red-500/30 transition-colors">
                                                        Reject
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <!-- Remove Trainee -->
                                            <form method="POST" action="{{ route('trainer.trainees.remove', $enrollment) }}" class="inline"
                                                  onsubmit="return confirm('Are you sure you want to remove this trainee? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-500/20 text-red-400 px-3 py-1 rounded-md text-sm hover:bg-red-500/30 transition-colors">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="text-gray-500 mb-4">
                                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-white mb-2">No trainees found</h3>
                                        <p class="text-gray-400">No enrollments match your current filters.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($enrollments->hasPages())
                    <div class="px-6 py-4 border-t border-white/10">
                        {{ $enrollments->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>