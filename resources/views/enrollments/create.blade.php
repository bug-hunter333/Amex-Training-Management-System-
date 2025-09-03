<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll in {{ $course->title }} - AMEX Training Institute</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
        
        .form-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
            outline: none;
        }
        
        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .form-input:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .form-select:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
            outline: none;
        }
        
        .form-select option {
            background: #1a1a1a;
            color: #ffffff;
        }
        
        .submit-btn {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            color: #000;
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }
        
        .submit-btn:disabled {
            opacity: 0.7;
            transform: none;
            cursor: not-allowed;
        }
        
        .back-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateY(-1px);
        }
        
        .success-alert {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
            backdrop-filter: blur(10px);
        }
        
        .error-text {
            color: #ef4444;
        }
        
        .nav-glass {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .course-info-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .section-divider {
            border-color: rgba(255, 255, 255, 0.1);
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
        
        .form-group {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
        .form-group:nth-child(5) { animation-delay: 0.5s; }
        .form-group:nth-child(6) { animation-delay: 0.6s; }
        
        .floating-label {
            position: relative;
        }
        
        .floating-label input:focus + label,
        .floating-label input:not(:placeholder-shown) + label,
        .floating-label textarea:focus + label,
        .floating-label textarea:not(:placeholder-shown) + label,
        .floating-label select:focus + label,
        .floating-label select:not([value=""]) + label {
            transform: translateY(-1.5rem) scale(0.8);
            color: #ffffff;
        }
        
        .floating-label label {
            position: absolute;
            left: 0.75rem;
            top: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
            pointer-events: none;
            background: linear-gradient(to right, rgba(0,0,0,0.8), rgba(0,0,0,0.8));
            padding: 0 0.25rem;
        }
        
        .progress-bar {
            background: rgba(255, 255, 255, 0.1);
            height: 4px;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .progress-fill {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            height: 100%;
            transition: width 0.3s ease;
        }
        
        .step-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .step-indicator.active {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            color: #000;
        }
        
        .step-indicator.completed {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
        }
    </style>
</head>
<body class="text-white min-h-screen">



    <div class="pt-20 pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="text-center mb-12 animate-fade-in">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-white to-white/80 bg-clip-text text-transparent">
                    Course Enrollment
                </h1>
                <p class="text-white/70 text-lg">Complete your registration to secure your spot in this professional training program</p>
            </div>

            <!-- Progress Indicator -->
            <div class="mb-8 animate-slide-up">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="step-indicator active">1</div>
                        <span class="text-white/80 font-medium">Personal Information</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="step-indicator">2</div>
                        <span class="text-white/60">Experience</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="step-indicator">3</div>
                        <span class="text-white/60">Confirmation</span>
                    </div>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 33%"></div>
                </div>
            </div>

            <!-- Course Information -->
            <div class="course-info-card rounded-2xl p-8 mb-8 animate-slide-up">
                <h2 class="text-2xl font-bold text-white mb-6">{{ $course->title }}</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 text-white/80">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <p class="text-white/60 text-sm">Lecturer</p>
                            <p class="font-semibold">{{ $course->lecturer_name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-white/60 text-sm">Duration</p>
                            <p class="font-semibold">{{ $course->duration_weeks }} weeks</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        <div>
                            <p class="text-white/60 text-sm">Price</p>
                            <p class="font-semibold">${{ number_format($course->price, 0) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <div>
                            <p class="text-white/60 text-sm">Max Students</p>
                            <p class="font-semibold">{{ $course->max_participants }}</p>
                        </div>
                    </div>
                </div>
                <p class="mt-6 text-white/70 leading-relaxed">{{ $course->description }}</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="success-alert rounded-xl px-6 py-4 mb-8 animate-fade-in">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L3.293 9.293a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Enrollment Form -->
            <div class="glass-card rounded-2xl p-8 animate-slide-up">
                <h2 class="text-2xl font-bold text-white mb-8">Enrollment Application</h2>
                
                <form action="{{ route('enrollment.store') }}" method="POST" class="space-y-8" id="enrollmentForm">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                    <!-- Personal Information -->
                    <div class="section-divider border-b pb-8">
                        <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Personal Information
                        </h3>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <div class="floating-label">
                                    <input type="text" id="trainee_name" name="trainee_name" 
                                           class="form-input w-full px-4 py-3 rounded-xl"
                                           placeholder=" " value="{{ old('trainee_name') }}" required>
                                    <label for="trainee_name">Full Name *</label>
                                </div>
                                @error('trainee_name')
                                    <p class="error-text text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="floating-label">
                                    <input type="email" id="trainee_email" name="trainee_email" 
                                           class="form-input w-full px-4 py-3 rounded-xl"
                                           placeholder=" " value="{{ old('trainee_email') }}" required>
                                    <label for="trainee_email">Email Address *</label>
                                </div>
                                @error('trainee_email')
                                    <p class="error-text text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="floating-label">
                                    <input type="tel" id="trainee_phone" name="trainee_phone" 
                                           class="form-input w-full px-4 py-3 rounded-xl"
                                           placeholder=" " value="{{ old('trainee_phone') }}" required>
                                    <label for="trainee_phone">Phone Number *</label>
                                </div>
                                @error('trainee_phone')
                                    <p class="error-text text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="floating-label">
                                    <input type="date" id="date_of_birth" name="date_of_birth" 
                                           class="form-input w-full px-4 py-3 rounded-xl"
                                           value="{{ old('date_of_birth') }}" required>
                                    <label for="date_of_birth">Date of Birth *</label>
                                </div>
                                @error('date_of_birth')
                                    <p class="error-text text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="floating-label">
                                    <select id="gender" name="gender" 
                                            class="form-select w-full px-4 py-3 rounded-xl"
                                            required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <label for="gender">Gender *</label>
                                </div>
                                @error('gender')
                                    <p class="error-text text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="floating-label">
                                    <select id="education_level" name="education_level" 
                                            class="form-select w-full px-4 py-3 rounded-xl"
                                            required>
                                        <option value="">Select Education Level</option>
                                        <option value="High School" {{ old('education_level') == 'High School' ? 'selected' : '' }}>High School</option>
                                        <option value="Associate Degree" {{ old('education_level') == 'Associate Degree' ? 'selected' : '' }}>Associate Degree</option>
                                        <option value="Bachelor's Degree" {{ old('education_level') == 'Bachelor\'s Degree' ? 'selected' : '' }}>Bachelor's Degree</option>
                                        <option value="Master's Degree" {{ old('education_level') == 'Master\'s Degree' ? 'selected' : '' }}>Master's Degree</option>
                                        <option value="PhD" {{ old('education_level') == 'PhD' ? 'selected' : '' }}>PhD</option>
                                    </select>
                                    <label for="education_level">Education Level *</label>
                                </div>
                                @error('education_level')
                                    <p class="error-text text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 form-group">
                            <div class="floating-label">
                                <textarea id="trainee_address" name="trainee_address" rows="4"
                                          class="form-input w-full px-4 py-3 rounded-xl resize-none"
                                          placeholder=" " required>{{ old('trainee_address') }}</textarea>
                                <label for="trainee_address">Complete Address *</label>
                            </div>
                            @error('trainee_address')
                                <p class="error-text text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Experience Section -->
                    <div class="form-group">
                        <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Experience & Background
                        </h3>
                        
                        <div class="floating-label">
                            <textarea id="previous_experience" name="previous_experience" rows="6"
                                      class="form-input w-full px-4 py-3 rounded-xl resize-none"
                                      placeholder=" ">{{ old('previous_experience') }}</textarea>
                            <label for="previous_experience">Previous Experience (Optional)</label>
                        </div>
                        <p class="text-white/50 text-sm mt-2">Please describe any relevant experience, skills, or background related to this course</p>
                        @error('previous_experience')
                            <p class="error-text text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Section -->
                    <div class="pt-8 section-divider border-t">
                        <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                            <a href="{{ url()->previous() }}" 
                               class="back-btn w-full sm:w-auto px-8 py-4 rounded-xl text-center font-medium transition-all">
                                ← Back to Course
                            </a>
                            <button type="submit" id="submitBtn"
                                    class="submit-btn w-full sm:w-auto px-12 py-4 rounded-xl font-bold text-lg transition-all">
                                Submit Enrollment
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal (Optional Enhancement) -->
    <div id="successModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
        <div class="glass-card rounded-2xl p-8 max-w-md mx-4 text-center">
            <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L3.293 9.293a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Enrollment Submitted!</h3>
            <p class="text-white/70 mb-6">Your application has been received. We'll contact you soon with further details.</p>
            <button onclick="closeModal()" class="submit-btn px-6 py-3 rounded-xl font-medium">
                Continue
            </button>
        </div>
    </div>

    <script>
       // Enhanced form functionality - FIXED VERSION
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('enrollmentForm');
    const submitBtn = document.getElementById('submitBtn');
    const progressFill = document.querySelector('.progress-fill');
    const stepIndicators = document.querySelectorAll('.step-indicator');
    
    // Form validation and enhancement
    form.addEventListener('submit', function(e) {
        // Remove e.preventDefault() to allow actual form submission
        // e.preventDefault(); // COMMENTED OUT
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-current inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Submitting...
        `;
        
        // Update progress to show submission
        progressFill.style.width = '100%';
        stepIndicators.forEach((indicator, index) => {
            indicator.classList.add('completed');
            indicator.innerHTML = '✓';
        });
        
        // The form will now actually submit to the server
        // No need for setTimeout or modal - let Laravel handle the response
    });
    
    // Real-time form validation
    const requiredInputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let filledCount = 0;
    
    function updateProgress() {
        filledCount = 0;
        requiredInputs.forEach(input => {
            if (input.value.trim() !== '') {
                filledCount++;
            }
        });
        
        const progressPercentage = Math.min((filledCount / requiredInputs.length) * 100, 100);
        progressFill.style.width = progressPercentage + '%';
        
        // Update step indicators based on progress
        if (progressPercentage >= 30) {
            stepIndicators[0].classList.add('completed');
            stepIndicators[0].innerHTML = '✓';
            stepIndicators[1].classList.add('active');
        }
        if (progressPercentage >= 80) {
            stepIndicators[1].classList.add('completed');
            stepIndicators[1].innerHTML = '✓';
            stepIndicators[2].classList.add('active');
        }
    }
    
    // Add event listeners for real-time progress
    requiredInputs.forEach(input => {
        input.addEventListener('input', updateProgress);
        input.addEventListener('change', updateProgress);
    });
    
    // Enhanced floating labels
    const floatingInputs = document.querySelectorAll('.floating-label input, .floating-label textarea, .floating-label select');
    
    floatingInputs.forEach(input => {
        // Check if input has value on page load
        if (input.value.trim() !== '') {
            input.classList.add('has-value');
        }
        
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
            if (this.value.trim() !== '') {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });
    });
    
    // Input validation styling
    const inputs = document.querySelectorAll('.form-input, .form-select');
    inputs.forEach(input => {
        input.addEventListener('invalid', function() {
            this.style.borderColor = '#ef4444';
            this.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
        });
        
        input.addEventListener('input', function() {
            if (this.checkValidity()) {
                this.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                this.style.boxShadow = 'none';
            }
        });
    });
    
    // Phone number formatting
    const phoneInput = document.getElementById('trainee_phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length >= 6) {
                value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
            } else if (value.length >= 3) {
                value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
            }
            this.value = value;
        });
    }
    
    // Auto-resize textarea
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
    
    // Initialize progress
    updateProgress();
});
    </script>

</body>
</html>