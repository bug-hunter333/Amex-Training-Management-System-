<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amex Training Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Your existing styles remain the same */
        body {
            font-family: 'Inter', sans-serif;
        }
        .mono {
            font-family: 'JetBrains Mono', monospace;
        }
        .gradient-text {
            background: linear-gradient(135deg, #ffffff 0%, #a1a1aa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        .grid-pattern {
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        .typewriter {
            overflow: hidden;
            border-right: 3px solid #ffffff;
            white-space: nowrap;
            animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
        }

        
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: #ffffff; }
        }
        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="bg-black text-white overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-black/80 backdrop-blur-md border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <span class="text-black font-bold text-sm mono">A</span>
                    </div>
                    <span class="text-xl font-semibold mono">AMEX Training Institute</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#courses" class="text-gray-300 hover:text-white transition-colors">Home</a>
                    <a href="#features" class="text-gray-300 hover:text-white transition-colors">Features</a>
                    <a href="#about" class="text-gray-300 hover:text-white transition-colors">About</a>
                    <a href="#contact" class="text-gray-300 hover:text-white transition-colors">Contact</a>
                    <a href="{{ route('courses.index') }}" class="text-gray-300 hover:text-white transition-colors">Courses</a>
                    
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
            </div>
        </div>
    </nav>

    <!-- Rest of your HTML content remains the same -->
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center grid-pattern">
        <!-- Your existing hero content -->
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/50 to-black"></div>
        <div class="relative z-10 max-w-6xl mx-auto px-6 lg:px-8 text-center">
            <div class="floating">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 gradient-text">
                    Training
                    <br>
                    <span class="typewriter mono">Management</span>
                </h1>
            </div>
            <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                Revolutionize your corporate training with our intelligent management system. 
                Streamlined, efficient, and built for the future.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-black px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-200 transition-all hover-glow">
                        Go to Dashboard →
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-black px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-200 transition-all hover-glow">
                        Start Training →
                    </a>
                @endauth
                <button class="border border-gray-600 px-8 py-4 rounded-lg font-semibold text-lg hover:border-white transition-colors">
                    Watch Demo
                </button>
            </div>
            
            <!-- Your existing stats section -->
            <div class="grid grid-cols-3 gap-8 mt-16 max-w-2xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl font-bold mono pulse-slow">500+</div>
                    <div class="text-gray-400 text-sm">Training Programs</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold mono pulse-slow">10K+</div>
                    <div class="text-gray-400 text-sm">Employees Trained</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold mono pulse-slow">95%</div>
                    <div class="text-gray-400 text-sm">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </section>

     <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-900/50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 mono">System Features</h2>
                <p class="text-gray-400 text-lg">Powerful tools designed for modern training management</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-800/50 p-8 rounded-xl border border-gray-700 card-hover">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Multi-Role Access</h3>
                    <p class="text-gray-400">Seamless login and registration for trainers, trainees, and administrators with role-based permissions.</p>
                </div>
                
                <div class="bg-gray-800/50 p-8 rounded-xl border border-gray-700 card-hover">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a2 2 0 11-4 0 2 2 0 014 0zM8 11a2 2 0 11-4 0 2 2 0 014 0zm8 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Smart Scheduling</h3>
                    <p class="text-gray-400">Intelligent training program scheduling with venue management and conflict resolution.</p>
                </div>
                
                <div class="bg-gray-800/50 p-8 rounded-xl border border-gray-700 card-hover">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Program Management</h3>
                    <p class="text-gray-400">Create, upload, and manage comprehensive training programs with prerequisites and detailed information.</p>
                </div>
                
                <div class="bg-gray-800/50 p-8 rounded-xl border border-gray-700 card-hover">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Easy Registration</h3>
                    <p class="text-gray-400">One-click registration for employees to join training programs that match their requirements.</p>
                </div>
                
                <div class="bg-gray-800/50 p-8 rounded-xl border border-gray-700 card-hover">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Feedback System</h3>
                    <p class="text-gray-400">Comprehensive feedback collection from both trainees and trainers for continuous improvement.</p>
                </div>
                
                <div class="bg-gray-800/50 p-8 rounded-xl border border-gray-700 card-hover">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Analytics & Reports</h3>
                    <p class="text-gray-400">Real-time analytics and detailed reports to track training effectiveness and employee progress.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 mono">How It Works</h2>
                <p class="text-gray-400 text-lg">Simple steps to transform your training management</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-white text-black rounded-full flex items-center justify-center mx-auto mb-6 mono font-bold text-xl">1</div>
                    <h3 class="text-xl font-semibold mb-3">Register</h3>
                    <p class="text-gray-400">Create your account as a trainer, trainee, or administrator</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white text-black rounded-full flex items-center justify-center mx-auto mb-6 mono font-bold text-xl">2</div>
                    <h3 class="text-xl font-semibold mb-3">Browse</h3>
                    <p class="text-gray-400">Explore available training programs and find the perfect match</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white text-black rounded-full flex items-center justify-center mx-auto mb-6 mono font-bold text-xl">3</div>
                    <h3 class="text-xl font-semibold mb-3">Enroll</h3>
                    <p class="text-gray-400">Register for training sessions with just one click</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white text-black rounded-full flex items-center justify-center mx-auto mb-6 mono font-bold text-xl">4</div>
                    <h3 class="text-xl font-semibold mb-3">Learn</h3>
                    <p class="text-gray-400">Attend sessions and provide feedback for continuous improvement</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gray-900/50">
        <div class="max-w-4xl mx-auto text-center px-6 lg:px-8">
            <h2 class="text-4xl font-bold mb-6 mono">Ready to Transform Your Training?</h2>
            <p class="text-xl text-gray-300 mb-8">Join thousands of companies already using our platform to enhance employee development.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-white text-black px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-200 transition-all hover-glow">
                    Start Free Trial
                </button>
                <button class="border border-gray-600 px-8 py-4 rounded-lg font-semibold text-lg hover:border-white transition-colors">
                    Schedule Demo
                </button>
            </div>
        </div>
    </section>

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


    <!-- Your existing JavaScript -->
    <script>
        // Your existing JavaScript code remains the same
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.classList.add('bg-black/90');
            } else {
                nav.classList.remove('bg-black/90');
            }
        });

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

        document.querySelectorAll('.card-hover').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>