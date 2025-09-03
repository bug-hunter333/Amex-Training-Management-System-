<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Successful - AMEX Training Institute</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-black min-h-screen">
    <!-- Header -->
    <div class="bg-gray-900 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <div class="text-2xl font-bold text-white">AMEX Training Institute</div>
                </div>
                <div class="text-sm text-gray-400">
                    {{ now()->format('F j, Y') }}
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Success Header -->
        <div class="text-center mb-12">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            
            <h1 class="text-4xl font-bold text-white mb-4">
                Enrollment Successful
            </h1>
            <p class="text-xl text-gray-300 mb-6">
                Your application has been successfully submitted
            </p>
            
            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Application ID: #ENR-{{ str_pad($enrollment->id ?? '000001', 6, '0', STR_PAD_LEFT) }}
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid lg:grid-cols-3 gap-8 mb-12">
            
            <!-- Course Information -->
            <div class="lg:col-span-2">
                <div class="bg-gray-900 rounded-lg shadow-lg border border-gray-700 p-8">
                    <h2 class="text-2xl font-semibold text-white mb-6">Course Information</h2>
                    
                    <div class="space-y-6">
                        <div class="border-l-4 border-blue-500 pl-4">
                            <p class="text-sm font-medium text-gray-400 uppercase tracking-wide">Course Title</p>
                            <p class="text-xl font-semibold text-white mt-1">
                                {{ $enrollment->course->title ?? 'Advanced Digital Marketing Strategy' }}
                            </p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-gray-800 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-400">Duration</p>
                                <p class="text-lg font-semibold text-white mt-1">
                                    {{ $enrollment->course->duration_weeks ?? '12' }} weeks
                                </p>
                            </div>
                            <div class="bg-gray-800 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-400">Course Fee</p>
                                <p class="text-lg font-semibold text-white mt-1">
                                    ${{ number_format($enrollment->course->price ?? 2500, 0) }}
                                </p>
                            </div>
                            <div class="bg-gray-800 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-400">Instructor</p>
                                <p class="text-lg font-semibold text-white mt-1">
                                    {{ $enrollment->course->lecturer_name ?? 'Dr. Sarah Johnson' }}
                                </p>
                            </div>
                            <div class="bg-gray-800 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-400">Class Size</p>
                                <p class="text-lg font-semibold text-white mt-1">
                                    {{ $enrollment->course->max_participants ?? '25' }} students
                                </p>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-700 pt-6">
                            <h3 class="text-lg font-semibold text-white mb-3">Course Description</h3>
                            <p class="text-gray-300 leading-relaxed">
                                {{ $enrollment->course->description ?? 'This comprehensive course covers advanced digital marketing strategies including SEO, SEM, social media marketing, content marketing, and analytics. Students will learn to develop and implement effective digital marketing campaigns.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Summary -->
            <div class="space-y-6">
                <div class="bg-gray-900 rounded-lg shadow-lg border border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Application Summary</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-400">Submitted</p>
                            <p class="text-sm text-white mt-1">
                                {{ $enrollment->formatted_enrollment_date ?? now()->format('F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-400">Status</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                {{ ucfirst($enrollment->status ?? 'Under Review') }}
                            </span>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-400">Email Address</p>
                            <p class="text-sm text-white mt-1">
                                {{ $enrollment->trainee_email ?? 'student@example.com' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-blue-900 rounded-lg border border-blue-700 p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Need Help?</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:admissions@amextraining.com" class="text-blue-300 hover:text-blue-200">
                                admissions@amextraining.com
                            </a>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <a href="tel:+15551234567" class="text-blue-300 hover:text-blue-200">
                                +1 (555) 123-4567
                            </a>
                        </div>
                        <p class="text-gray-300 text-xs mt-3">
                            Office Hours: Monday - Friday, 9 AM - 5 PM EST
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-gray-900 rounded-lg shadow-lg border border-gray-700 p-8 mb-8">
            <h2 class="text-2xl font-semibold text-white mb-6">Next Steps</h2>
            
            <div class="grid md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-2">Confirmation Email</h3>
                    <p class="text-xs text-gray-400">Check your email for enrollment confirmation and reference number</p>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-900 text-green-300 border border-green-700">
                            Completed
                        </span>
                    </div>
                </div>

                  <div class="text-center">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-2">Course Access</h3>
                    <p class="text-xs text-gray-400">you can access to course using your reference ID</p>
                    <div class="mt-2">
                       <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-900 text-green-300 border border-green-700">
                            Completed
                        </span>
                    </div>
                </div>
                




                <div class="text-center">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-2">Application Review</h3>
                    <p class="text-xs text-gray-400">Our team will review your application within 2-3  Hours</p>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-900 text-yellow-300 border border-yellow-700">
                            In Progress
                        </span>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-2">Approval & Payment</h3>
                    <p class="text-xs text-gray-400">Receive approval notification with payment instructions</p>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-800 text-gray-400 border border-gray-600">
                            Pending
                        </span>
                    </div>
                </div>
                
              
            </div>
        </div>

        <!-- Important Notes -->
        <div class="bg-amber-900 border border-amber-700 rounded-lg p-6 mb-8">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-amber-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="text-sm font-semibold text-amber-300 mb-2">Important Information</h3>
                    <ul class="text-sm text-amber-200 space-y-1">
                        <li>• Check your email regularly for updates and communications</li>
                        <li>• No payment is required until your application is approved</li>
                        <li>• Keep your contact information up to date</li>
                        <li>• Applications are processed in the order received</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('courses.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:ring-offset-black transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Browse More Courses
            </a>
            
            <a href="{{ route('dashboard', $enrollment ?? '#') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-600 text-base font-medium rounded-md text-gray-300 bg-gray-800 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 focus:ring-offset-black transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View  Course Dashboard
            </a>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-gray-900 text-white py-8 mt-16 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-4">AMEX Training Institute</h3>
                <p class="text-gray-400 text-sm mb-4">
                    Empowering professionals through excellence in education
                </p>
                <div class="flex justify-center space-x-6 text-sm text-gray-400">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <span>•</span>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                    <span>•</span>
                    <a href="#" class="hover:text-white transition-colors">Support</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>