<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMEX Training Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #ffffff 0%, #e5e7eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(255, 255, 255, 0.1);
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .pulse-glow {
            animation: pulse-glow 2s infinite;
        }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(255, 255, 255, 0.3); }
            50% { box-shadow: 0 0 30px rgba(255, 255, 255, 0.5); }
        }
        
        .slide-in {
            animation: slideIn 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(30px);
        }
        
        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .staggered-1 { animation-delay: 0.1s; }
        .staggered-2 { animation-delay: 0.2s; }
        .staggered-3 { animation-delay: 0.3s; }
        .staggered-4 { animation-delay: 0.4s; }
        
        .progress-bar {
            background: linear-gradient(90deg, #ffffff 0%, #e5e7eb 100%);
            height: 4px;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #f3f4f6 0%, #ffffff 100%);
            animation: progress-fill 2s ease-out forwards;
            width: 0%;
        }
        
        @keyframes progress-fill {
            to { width: var(--progress-width); }
        }
    </style>
</head>
<body class="bg-black text-white min-h-screen">
    <!-- Simple Header with Home Button -->
    <div class="bg-black border-b border-gray-800 sticky top-0 z-50 backdrop-blur-lg bg-opacity-90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-white rounded-md flex items-center justify-center">
                        <span class="text-black font-bold text-lg">A</span>
                    </div>
                    <span class="text-xl font-semibold text-white">AMEX Training Institute</span>
                </div>
               <nav>
                    <div class="hidden md:flex items-center space-x-8">
                         <a href="#features" class="text-gray-300 hover:text-white transition-colors"></a>
                         <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ url('/home') }}" class="text-gray-300 hover:text-white transition-colors">Home</a>
                        @auth
                            <!-- Show user menu when logged in -->
                            <div class="relative group">
                                <button class="text-gray-300 hover:text-white transition-colors flex items-center space-x-2">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-700 rounded-t-lg">Dashboard</a>
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-700">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-700 rounded-b-lg">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Show login/register when not logged in -->
                            <a href="{{ route('login') }}" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-lg transition-colors">Login</a>
                            <a href="{{ route('register') }}" class="bg-white text-black hover:bg-gray-200 px-4 py-2 rounded-lg font-medium transition-colors hover-glow">Get Started</a>
                        @endauth
                    </div>
                    <button class="md:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </nav>

            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center slide-in staggered-1">
                <h1 class="text-5xl md:text-7xl font-bold gradient-text mb-6 floating-animation">
                    Training Dashboard
                </h1>
                <h2 class="text-3xl md:text-4xl font-semibold text-white mb-4 slide-in staggered-2">
                    Welcome, {{ Auth::user()->name }}!
                </h2>
                <p class="text-xl md:text-2xl text-gray-300 mb-8 slide-in staggered-3">
                    Elevate your skills with our comprehensive training programs.<br>
                    Expert-led, industry-focused, and designed for success.
                </p>
            </div>
        </div>
        
        <!-- Animated Background Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 border border-gray-700 rounded-full opacity-20 floating-animation"></div>
        <div class="absolute top-40 right-20 w-16 h-16 border border-gray-600 rounded-lg opacity-30 floating-animation" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 left-1/4 w-12 h-12 border border-gray-800 rounded-full opacity-25 floating-animation" style="animation-delay: 4s;"></div>
    </div>

    <!-- Dashboard Cards -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- My Courses Card -->
            <div class="bg-gray-900 border border-gray-800 p-8 rounded-xl card-hover slide-in staggered-2 cursor-pointer" onclick="navigateToSection('courses')">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-2xl font-semibold text-white">My Courses</h4>
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-400 mb-6">View and manage your enrolled training programs</p>
             
               
                <button class="mt-4 text-white hover:text-gray-300 transition-colors inline-flex items-center">
                    View My Courses
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
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
                    <p class="text-gray-400">Empowering corporate training through intelligent management solutions.</p>
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


    <script>
        // Animation for counting numbers
        function animateCounter(element, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const currentValue = Math.floor(progress * (end - start) + start);
                element.textContent = currentValue;
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Initialize counters when page loads
        window.addEventListener('load', () => {
            setTimeout(() => {
                animateCounter(document.getElementById('totalHours'), 0, 247, 2000);
                animateCounter(document.getElementById('completedCourses'), 0, 15, 2000);
                animateCounter(document.getElementById('skillsLearned'), 0, 32, 2000);
                animateCounter(document.getElementById('rankPosition'), 0, 156, 2000);
            }, 500);
        });

        // Navigation functions
        function goHome() {
            // In Laravel, redirect to home route
            window.location.href = '/home';
            // Or use: return redirect()->route('home');
        }

        function navigateToSection(section) {
            console.log(`Navigating to ${section} section...`);
            // In Laravel, these would be actual routes
            switch(section) {
                case 'courses':
                    // window.location.href = '/courses';
                    alert('Redirecting to courses page... (In Laravel: return redirect()->route("courses"))');
                    break;
                case 'schedule':
                    // window.location.href = '/schedule';
                    alert('Redirecting to schedule page... (In Laravel: return redirect()->route("schedule"))');
                    break;
                case 'certificates':
                    // window.location.href = '/certificates';
                    alert('Redirecting to certificates page... (In Laravel: return redirect()->route("certificates"))');
                    break;
            }
        }

        // Dynamic greeting based on time - removed since we're using Laravel Auth
        // The greeting is now handled by Laravel Blade templating

        // Add hover effects to cards
        document.querySelectorAll('.card-hover').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.borderColor = '#374151';
            });
            card.addEventListener('mouseleave', () => {
                card.style.borderColor = '#1f2937';
            });
        });

        // Update this JavaScript in your dashboard.index view

function navigateToSection(section) {
    console.log(`Navigating to ${section} section...`);
    
    switch(section) {
        case 'courses':
            // Redirect to the new trainee my-courses page
            window.location.href = '/trainee/my-courses';
            break;
        case 'schedule':
            // You can implement this later for viewing schedules
            window.location.href = '/trainee/schedule';
            // Or for now, redirect to my-courses
            window.location.href = '/trainee/my-courses';
            break;
        case 'certificates':
            // You can implement this later for certificates
            window.location.href = '/trainee/certificates';
            // Or for now, redirect to my-courses  
            window.location.href = '/trainee/my-courses';
            break;
        default:
            window.location.href = '/trainee/dashboard';
            break;
    }
}
    </script>
</body>
</html>