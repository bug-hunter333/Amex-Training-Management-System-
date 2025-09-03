<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMEX Training Institute - Home</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            animation: slideDown 0.5s ease-out;
        }
        
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid #10b981;
            color: #10b981;
        }
        
        .alert-info {
            background-color: rgba(59, 130, 246, 0.1);
            border: 1px solid #3b82f6;
            color: #3b82f6;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .hero-animation {
            animation: fadeInUp 1s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .btn-primary {
            background: white;
            color: black;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.1);
        }
        
        .btn-secondary {
            background: transparent;
            border: 2px solid white;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: white;
            color: black;
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-black text-white min-h-screen">
    <!-- Header -->
    <nav class="bg-black border-b border-gray-800 sticky top-0 z-50 backdrop-blur-lg bg-opacity-90">
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
                        <a href="#features" class="text-gray-300 hover:text-white transition-colors">Features</a>
                        <a href="#about" class="text-gray-300 hover:text-white transition-colors">About</a>
                        <a href="#contact" class="text-gray-300 hover:text-white transition-colors">Contact</a>
                        <a href="#courses" class="text-gray-300 hover:text-white transition-colors">Courses</a>

                        @auth
                            <!-- Show user menu when logged in -->
                            <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition-colors">Dashboard</a>
                            <a href="{{ route('profile.show') }}" class="text-gray-300 hover:text-white transition-colors">Profile</a>
                        @else
                            <!-- Show login/register when not logged in -->
                            <a href="{{ route('login') }}" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-lg transition-colors">Login</a>
                            <a href="{{ route('register') }}" class="bg-white text-black hover:bg-gray-200 px-4 py-2 rounded-lg font-medium transition-colors">Get Started</a>
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
    </nav>

    <!-- Alert Messages Container -->
    <div id="alertContainer" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        @if(session('success'))
            <div class="alert alert-success">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold">Success!</h4>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('logout_message'))
            <div class="alert alert-info">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <div>
                        <h4 class="font-semibold">Logged Out Successfully</h4>
                        <p>{{ session('logout_message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold">Information</h4>
                        <p>{{ session('info') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center hero-animation">
                <h1 class="text-6xl md:text-8xl font-bold gradient-text mb-8">
                    Welcome to AMEX Training
                </h1>
                <p class="text-2xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed">
                    Transform your career with world-class training programs designed for excellence. 
                    Join thousands of professionals who have elevated their skills with us.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16">
                    @guest
                        <a href="{{ route('register') }}" class="btn-primary px-8 py-4 rounded-lg text-xl font-semibold inline-flex items-center space-x-2">
                            <span>Get Started Today</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="#courses" class="btn-secondary px-8 py-4 rounded-lg text-xl font-semibold">
                            Explore Courses
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-primary px-8 py-4 rounded-lg text-xl font-semibold inline-flex items-center space-x-2">
                            <span>Go to Dashboard</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('profile.show') }}" class="btn-secondary px-8 py-4 rounded-lg text-xl font-semibold">
                            Manage Profile
                        </a>
                    @endguest
                </div>

                @auth
                    <div class="bg-gray-900 border border-gray-700 rounded-xl p-6 max-w-md mx-auto">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-green-400 font-medium">Currently Logged In</span>
                        </div>
                        <p class="text-gray-300">Welcome back, <span class="text-white font-semibold">{{ Auth::user()->name }}</span>!</p>
                        <p class="text-gray-400 text-sm">{{ Auth::user()->email }}</p>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Animated Background Elements -->
        <div class="absolute top-24 left-12 w-20 h-20 border border-gray-700 rounded-full opacity-20 floating"></div>
        <div class="absolute top-40 right-20 w-16 h-16 border border-gray-600 rounded-lg opacity-30 floating" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 left-1/4 w-12 h-12 border border-gray-800 rounded-full opacity-25 floating" style="animation-delay: 4s;"></div>
        <div class="absolute bottom-40 right-1/3 w-8 h-8 bg-white opacity-10 rounded-full floating" style="animation-delay: 1s;"></div>
    </div>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold text-white mb-6">Why Choose AMEX Training?</h2>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                    Experience world-class training with industry experts and cutting-edge curriculum
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-black border border-gray-800 rounded-xl p-8 hover:border-gray-600 transition-colors">
                    <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 text-center">Fast Track Learning</h3>
                    <p class="text-gray-400 text-center">Accelerated programs designed to get you job-ready in record time.</p>
                </div>
                
                <div class="bg-black border border-gray-800 rounded-xl p-8 hover:border-gray-600 transition-colors">
                    <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 text-center">Expert Instructors</h3>
                    <p class="text-gray-400 text-center">Learn from industry professionals with years of real-world experience.</p>
                </div>
                
                <div class="bg-black border border-gray-800 rounded-xl p-8 hover:border-gray-600 transition-colors">
                    <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 text-center">Certified Programs</h3>
                    <p class="text-gray-400 text-center">Earn industry-recognized certifications that employers value.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black border-t border-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-2 mb-6">
                        <div class="w-10 h-10 bg-white rounded-md flex items-center justify-center">
                            <span class="text-black font-bold text-xl">A</span>
                        </div>
                        <span class="text-2xl font-semibold text-white">AMEX Training Institute</span>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">
                        Empowering professionals with world-class training and certification programs. 
                        Transform your career with us today.
                    </p>
                    @if(session('success') || session('logout_message'))
                        <div class="bg-gray-900 border border-green-800 rounded-lg p-4">
                            <p class="text-green-400 text-sm">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Session ended successfully. Thank you for using AMEX Training!
                            </p>
                        </div>
                    @endif
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#courses" class="text-gray-400 hover:text-white transition-colors">Courses</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                        @guest
                            <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors">Login</a></li>
                        @endguest
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-500">&copy; 2024 AMEX Training Institute. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Auto-hide alerts after 8 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.animation = 'slideUp 0.5s ease-out forwards';
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 8000);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add slideUp animation for alerts
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideUp {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateY(-20px);
                }
            }
        `;
        document.head.appendChild(style);

        // Welcome message for returning users
        @if(session('logout_message'))
            setTimeout(() => {
                console.log('User successfully logged out and redirected to home page');
            }, 1000);
        @endif

        // Add intersection observer for animations
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

        // Observe elements for scroll animations
        document.querySelectorAll('.hero-animation, .floating').forEach(el => {
            observer.observe(el);
        });

        console.log('AMEX Training Institute - Home page loaded successfully');
    </script>
</body>
</html>