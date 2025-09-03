<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Courses - AMEX Training</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        .status-pending {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }
        
        .status-approved {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }
        
        .status-rejected {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        .reference-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            transition: all 0.3s ease;
        }
        
        .reference-input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.4);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            color: #000;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="text-white min-h-screen">
    <!-- Navigation -->
    <div class="bg-black/80 backdrop-blur-lg border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-white rounded-md flex items-center justify-center">
                        <span class="text-black font-bold text-lg">A</span>
                    </div>
                    <span class="text-xl font-semibold">AMEX Training</span>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="/dashboard" class="text-gray-300 hover:text-white transition-colors">Dashboard</a>
                    <a href="#" class="text-white font-medium">My Courses</a>
                    <span class="text-gray-400">{{ auth()->user()->name ?? 'User' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8 animate-fade-in">
            <h1 class="text-4xl font-bold mb-2 bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                My Courses
            </h1>
            <p class="text-gray-400 text-lg">Manage your enrolled courses and activate new ones</p>
        </div>

        <!-- Success/Error Messages -->
        <div class="mb-6 space-y-4">
            <!-- Success Message -->
            <div id="successMessage" class="hidden bg-green-900/20 border border-green-500/30 text-green-400 px-6 py-4 rounded-xl">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L3.293 9.293a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span id="successText">Course activated successfully!</span>
                </div>
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="hidden bg-red-900/20 border border-red-500/30 text-red-400 px-6 py-4 rounded-xl">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span id="errorText">Invalid reference ID. Please check and try again.</span>
                </div>
            </div>
        </div>

        <!-- Reference ID Activation Card -->
        <div class="glass-card rounded-2xl p-8 mb-8 animate-fade-in">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Activate Course</h2>
                    <p class="text-gray-400">Enter your reference ID to activate an enrolled course</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="15 7a2 2 0 012 2m-2-2l-2.5-2.5a2 2 0 000-2.828l-.793-.793a2 2 0 00-2.828 0L7.5 3.5a2 2 0 000 2.828l.793.793a2 2 0 002.828 0L13 5l2 2zm-2 2l-2.5 2.5a2 2 0 000 2.828l.793.793a2 2 0 002.828 0L17.5 13.5a2 2 0 000-2.828l-.793-.793a2 2 0 00-2.828 0L12 12l-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <form id="activationForm" class="space-y-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            id="reference_id" 
                            name="reference_id"
                            placeholder="Enter Reference ID (e.g., AMX25081512345)"
                            class="reference-input w-full px-4 py-3 rounded-xl text-lg font-mono"
                            maxlength="13"
                            required
                        >
                        <p class="text-gray-500 text-sm mt-2">
                            Format: AMX + Date + 4 digits (13 characters total)
                        </p>
                    </div>
                    <button 
                        type="submit" 
                        class="btn-primary px-8 py-3 rounded-xl font-bold whitespace-nowrap"
                    >
                        Activate Course
                    </button>
                </div>
            </form>
        </div>

        <!-- Course Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="glass-card rounded-xl p-6 text-center animate-fade-in">
                <div class="text-3xl font-bold text-white mb-2">3</div>
                <div class="text-gray-400">Total Enrollments</div>
            </div>
            <div class="glass-card rounded-xl p-6 text-center animate-fade-in">
                <div class="text-3xl font-bold text-green-400 mb-2">2</div>
                <div class="text-gray-400">Active Courses</div>
            </div>
            <div class="glass-card rounded-xl p-6 text-center animate-fade-in">
                <div class="text-3xl font-bold text-yellow-400 mb-2">1</div>
                <div class="text-gray-400">Pending</div>
            </div>
            <div class="glass-card rounded-xl p-6 text-center animate-fade-in">
                <div class="text-3xl font-bold text-blue-400 mb-2">1</div>
                <div class="text-gray-400">Completed</div>
            </div>
        </div>

        <!-- Enrolled Courses List -->
        <div class="glass-card rounded-2xl p-8 animate-fade-in">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white">My Enrolled Courses</h2>
                <a href="/courses" class="text-blue-400 hover:text-blue-300 transition-colors">
                    Browse More Courses →
                </a>
            </div>

            <div class="space-y-4">
                <!-- Sample Course 1 - Approved -->
                <div class="bg-white/5 border border-white/10 rounded-xl p-6 hover:bg-white/8 transition-all">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-xl font-semibold text-white">Web Development Fundamentals</h3>
                                <span class="status-approved text-sm px-3 py-1 rounded-full font-medium">Active</span>
                            </div>
                            <p class="text-gray-400 mb-3">Learn the basics of HTML, CSS, and JavaScript to build modern websites.</p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Reference ID:</span>
                                    <span class="text-white font-mono">AMX2508151234</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Lecturer:</span>
                                    <span class="text-white">Dr. Sarah Johnson</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Duration:</span>
                                    <span class="text-white">8 weeks</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Enrolled:</span>
                                    <span class="text-white">Aug 15, 2025</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 ml-4">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                Access Course
                            </button>
                            <button class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sample Course 2 - Pending -->
                <div class="bg-white/5 border border-white/10 rounded-xl p-6 hover:bg-white/8 transition-all">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-xl font-semibold text-white">Data Science with Python</h3>
                                <span class="status-pending text-sm px-3 py-1 rounded-full font-medium">Pending Activation</span>
                            </div>
                            <p class="text-gray-400 mb-3">Master data analysis, visualization, and machine learning using Python.</p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Reference ID:</span>
                                    <span class="text-white font-mono">AMX2508155678</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Lecturer:</span>
                                    <span class="text-white">Prof. Michael Chen</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Duration:</span>
                                    <span class="text-white">12 weeks</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Enrolled:</span>
                                    <span class="text-white">Aug 15, 2025</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 ml-4">
                            <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                Activate with ID
                            </button>
                            <button class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sample Course 3 - Completed -->
                <div class="bg-white/5 border border-white/10 rounded-xl p-6 hover:bg-white/8 transition-all opacity-75">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-xl font-semibold text-white">Digital Marketing Basics</h3>
                                <span class="bg-blue-900/20 border border-blue-500/30 text-blue-400 text-sm px-3 py-1 rounded-full font-medium">Completed</span>
                            </div>
                            <p class="text-gray-400 mb-3">Introduction to digital marketing strategies and social media management.</p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Reference ID:</span>
                                    <span class="text-white font-mono">AMX2507209012</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Lecturer:</span>
                                    <span class="text-white">Ms. Emily Davis</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Duration:</span>
                                    <span class="text-white">6 weeks</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Completed:</span>
                                    <span class="text-white">Aug 10, 2025</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 ml-4">
                            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                View Certificate
                            </button>
                            <button class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                Course Materials
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="hidden text-center py-12">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">No courses found</h3>
                    <p class="text-gray-400 mb-6">You haven't enrolled in any courses yet. Start learning today!</p>
                    <a href="/courses" class="btn-primary px-6 py-3 rounded-xl font-bold">
                        Browse Courses
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('activationForm');
            const referenceInput = document.getElementById('reference_id');
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');

            // Format reference ID as user types
            referenceInput.addEventListener('input', function(e) {
                let value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                
                // Limit to 13 characters
                if (value.length > 13) {
                    value = value.substring(0, 13);
                }
                
                e.target.value = value;
            });

            // Handle form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const referenceId = referenceInput.value.trim();
                
                // Validate format
                const isValidFormat = /^AMX\d{10}$/.test(referenceId);
                
                if (!isValidFormat) {
                    showError('Invalid reference ID format. Please enter a valid reference ID.');
                    return;
                }

                // Simulate activation (replace with actual AJAX call to your Laravel backend)
                simulateActivation(referenceId);
            });

            function simulateActivation(referenceId) {
                // Show loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Activating...';
                submitBtn.disabled = true;

                // Real AJAX call to Laravel backend
                fetch('/trainee/activate-course-ajax', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        reference_id: referenceId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Reset button
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;

                    if (data.success) {
                        showSuccess(data.message);
                        referenceInput.value = '';
                        // Refresh page to show updated course list
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    // Reset button
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                    showError('Something went wrong. Please try again.');
                    console.error('Error:', error);
                });
            }

            function showSuccess(message) {
                document.getElementById('successText').textContent = message;
                successMessage.classList.remove('hidden');
                errorMessage.classList.add('hidden');
                
                setTimeout(() => {
                    successMessage.classList.add('hidden');
                }, 5000);
            }

            function showError(message) {
                document.getElementById('errorText').textContent = message;
                errorMessage.classList.remove('hidden');
                successMessage.classList.add('hidden');
                
                setTimeout(() => {
                    errorMessage.classList.add('hidden');
                }, 5000);
            }

            // Handle course action buttons
            document.addEventListener('click', function(e) {
                if (e.target.matches('.bg-yellow-600, .bg-yellow-700')) {
                    // Auto-fill reference ID for pending activation
                    const courseCard = e.target.closest('.bg-white\\/5');
                    const referenceId = courseCard.querySelector('.font-mono').textContent;
                    referenceInput.value = referenceId;
                    referenceInput.focus();
                    
                    // Scroll to activation form
                    document.querySelector('.glass-card').scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            });
        });
    </script>
</body>
</html>