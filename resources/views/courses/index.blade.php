<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Courses - AMEX Training Institute</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
        }
        
        .course-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .course-card:hover {
            transform: translateY(-8px) scale(1.02);
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
        }
        
        .filter-btn {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
        }
        
        .filter-btn.active {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            color: #000;
            border-color: #ffffff;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }
        
        .filter-btn:hover:not(.active) {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }
        
        .search-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            backdrop-filter: blur(10px);
        }
        
        .search-input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }
        
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .badge-featured {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
        }
        
        .badge-mandatory {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        
        .stats-container {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .course-image {
            background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%);
        }
        
        .enroll-btn {
            background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            color: #000;
            transition: all 0.3s ease;
        }
        
        .enroll-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }
        
        .details-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        .details-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }
        
        .hero-section {
            background: linear-gradient(135deg, rgba(0,0,0,0.9) 0%, rgba(26,26,26,0.8) 100%);
            backdrop-filter: blur(20px);
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
        
        .grid-animate {
            animation: gridFadeIn 1s ease-out forwards;
        }
        
        @keyframes gridFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="min-h-screen text-white">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-black/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <span class="text-black font-bold text-sm">A</span>
                    </div>
                    <span class="text-xl font-semibold">AMEX Training Institute</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-white/70 hover:text-white transition-colors">Home</a>
                  
                    <a href="#contact" class="text-white/70 hover:text-white transition-colors">Contact</a>
                    <a href="#" class="text-white transition-colors font-medium">Courses</a>

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
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section pt-32 pb-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <div class="animate-fade-in">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-white to-white/80 bg-clip-text text-transparent">
                    Professional<br>
                    <span class="text-4xl md:text-6xl">Courses That We Offer</span>
                </h1>
                <p class="text-xl text-white/70 mb-12 max-w-3xl mx-auto leading-relaxed">
                    Elevate your skills with our comprehensive training programs. 
                    Expert-led, industry-focused, and designed for success.
                </p>
            </div>
            
        
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <div class="bg-white/5 backdrop-blur-md rounded-2xl border border-white/10 p-8 mb-12 animate-fade-in">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <input 
                            type="text" 
                            id="searchInput"
                            placeholder="Search courses..."
                            class="search-input w-full pl-12 pr-4 py-4 rounded-xl focus:outline-none transition-all"
                        >
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Filters -->
                <div class="flex flex-wrap gap-3">
                    <button class="filter-btn active px-6 py-3 rounded-xl text-sm font-medium" data-filter="all">
                        All Courses
                    </button>
                    <button class="filter-btn px-6 py-3 rounded-xl text-sm font-medium" data-filter="featured">
                        Featured
                    </button>
                    <button class="filter-btn px-6 py-3 rounded-xl text-sm font-medium" data-filter="mandatory">
                        Mandatory
                    </button>
                    <button class="filter-btn px-6 py-3 rounded-xl text-sm font-medium" data-filter="beginner">
                        Beginner
                    </button>
                    <button class="filter-btn px-6 py-3 rounded-xl text-sm font-medium" data-filter="intermediate">
                        Intermediate
                    </button>
                    <button class="filter-btn px-6 py-3 rounded-xl text-sm font-medium" data-filter="advanced">
                        Advanced
                    </button>
                </div>
            </div>
        </div>

        <!-- Courses Grid -->
        <div id="coursesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 grid-animate">
            <!-- Sample Course Card (PHP template structure) -->
            @foreach($courses as $course)
            <div class="course-card rounded-2xl overflow-hidden" 
                 data-tags="{{ strtolower(str_replace('-', ' ', $course->category)) }},{{ $course->is_featured ? 'featured' : '' }},{{ $course->is_mandatory ? 'mandatory' : '' }},{{ strtolower($course->difficulty_level) }},{{ implode(',', array_map('strtolower', $course->tags ?? [])) }}">
                
                <!-- Course Image -->
                <div class="course-image h-48 relative overflow-hidden">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    
                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex gap-2">
                        @if($course->is_featured)
                            <span class="badge-featured text-black px-3 py-1 rounded-full text-xs font-semibold">Featured</span>
                        @endif
                        @if($course->is_mandatory)
                            <span class="badge-mandatory text-white px-3 py-1 rounded-full text-xs font-semibold">Mandatory</span>
                        @endif
                    </div>

                    <!-- Course Type Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="bg-white/20 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-medium capitalize">
                            {{ str_replace('-', ' ', $course->course_type) }}
                        </span>
                    </div>

                    <!-- Course Title and Category -->
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-bold mb-1">{{ $course->title }}</h3>
                        <p class="text-sm text-white/80 capitalize">{{ str_replace('-', ' ', $course->category) }}</p>
                    </div>
                </div>

                <!-- Course Content -->
                <div class="p-6">
                    <!-- Description -->
                    <p class="text-white/70 mb-6 leading-relaxed line-clamp-3">
                        {{ Str::limit($course->description, 120) }}
                    </p>

                    <!-- Course Details -->
                    <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                        <div class="flex items-center text-white/60">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $course->duration_weeks }} weeks
                        </div>
                        <div class="flex items-center text-white/60">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            {{ ucfirst($course->difficulty_level) }}
                        </div>
                        <div class="flex items-center text-white/60">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ $course->enrollment_count }}/{{ $course->max_participants }}
                        </div>
                        <div class="flex items-center text-white/60">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            {{ number_format($course->average_rating, 1) }} ({{ $course->total_reviews }})
                        </div>
                    </div>

                    <!-- Tags -->
                    @if($course->tags && count($course->tags) > 0)
                    <div class="mb-6">
                        <div class="flex flex-wrap gap-2">
                            @foreach(array_slice($course->tags, 0, 3) as $tag)
                                <span class="bg-white/10 text-white/80 px-3 py-1 rounded-full text-xs backdrop-blur-md">{{ $tag }}</span>
                            @endforeach
                            @if(count($course->tags) > 3)
                                <span class="text-white/50 text-xs px-3 py-1">+{{ count($course->tags) - 3 }} more</span>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Price and Action -->
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-2xl font-bold text-white">${{ number_format($course->price, 0) }}</span>
                            @if($course->requires_approval)
                                <p class="text-xs text-yellow-400">Approval required</p>
                            @endif
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('courses.show', $course->slug) }}" 
                               class="details-btn px-4 py-2 rounded-lg text-sm font-medium">
                                Details
                            </a>
                            @if(!$course->requires_approval && $course->enrollment_count < $course->max_participants)
                                <button class="enroll-btn px-6 py-2 rounded-lg text-sm font-bold">
                                    Enroll Now
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Schedule Info -->
                    @if($course->schedule)
                    <div class="pt-4 border-t border-white/10 text-xs text-white/50">
                        <div class="mb-1">
                            <strong class="text-white/70">Schedule:</strong> 
                            {{ implode(', ', $course->schedule['days'] ?? []) }} 
                            {{ $course->schedule['time'] ?? '' }}
                        </div>
                        <div>
                            <strong class="text-white/70">Starts:</strong> {{ date('M j, Y', strtotime($course->start_date)) }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="text-center py-16 hidden">
            <div class="text-white/30 mb-6">
                <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">No courses found</h3>
            <p class="text-white/60 text-lg">Try adjusting your search or filter criteria.</p>
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
        // Enhanced Filter and Search functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const searchInput = document.getElementById('searchInput');
        const coursesGrid = document.getElementById('coursesGrid');
        const emptyState = document.getElementById('emptyState');
        const courseCards = document.querySelectorAll('.course-card');

        let currentFilter = 'all';
        let currentSearch = '';

        // Add entrance animations
        function animateCards() {
            courseCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                }, index * 100);
            });
        }

        // Initialize animations
        document.addEventListener('DOMContentLoaded', () => {
            animateCards();
        });

        // Filter button event listeners
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Update active state with smooth transition
                filterButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.style.transform = 'scale(1)';
                });
                button.classList.add('active');
                button.style.transform = 'scale(1.05)';
                
                setTimeout(() => {
                    button.style.transform = 'scale(1)';
                }, 150);
                
                currentFilter = button.getAttribute('data-filter');
                filterCourses();
            });
        });

        // Enhanced search input with debouncing
        let searchTimeout;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearch = e.target.value.toLowerCase();
                filterCourses();
            }, 300);
        });

        function filterCourses() {
            let visibleCount = 0;

            courseCards.forEach((card, index) => {
                const tags = card.getAttribute('data-tags').toLowerCase();
                const title = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                
                const matchesFilter = currentFilter === 'all' || tags.includes(currentFilter);
                const matchesSearch = currentSearch === '' || 
                    title.includes(currentSearch) || 
                    description.includes(currentSearch) ||
                    tags.includes(currentSearch);

                if (matchesFilter && matchesSearch) {
                    card.style.display = 'block';
                    // Animate in
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 50);
                    visibleCount++;
                } else {
                    // Animate out
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });

            // Show/hide empty state with animation
            setTimeout(() => {
                if (visibleCount === 0) {
                    coursesGrid.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    emptyState.style.opacity = '0';
                    setTimeout(() => {
                        emptyState.style.opacity = '1';
                    }, 50);
                } else {
                    emptyState.classList.add('hidden');
                    coursesGrid.classList.remove('hidden');
                }
            }, 300);
        }

        // Enhanced hover effects for course cards
        courseCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Smooth scroll for anchor links
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

        // Parallax effect for hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-section');
            const speed = scrolled * 0.5;
            parallax.style.transform = `translateY(${speed}px)`;
        });

        // Add loading states for enroll buttons
        document.querySelectorAll('.enroll-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.textContent.includes('Enroll')) {
                    e.preventDefault();
                    const originalText = this.textContent;
                    this.textContent = 'Enrolling...';
                    this.style.opacity = '0.7';
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.opacity = '1';
                        // Here you would typically handle the actual enrollment
                    }, 2000);
                }
            });
        });
    </script>
</body>
</html>