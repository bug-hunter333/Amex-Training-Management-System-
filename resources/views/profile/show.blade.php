<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMEX Training - Profile</title>
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
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(255, 255, 255, 0.1);
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
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
        .staggered-5 { animation-delay: 0.5s; }
        
        .form-input {
            background: #111827;
            border: 1px solid #374151;
            color: white;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            border-color: #ffffff;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
            outline: none;
        }
        
        .btn-primary {
            background: white;
            color: black;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
        }
        
        .btn-primary:disabled {
            opacity: 0.6;
            transform: none;
            cursor: not-allowed;
        }
        
        .btn-danger {
            background: #dc2626;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            background: #b91c1c;
            transform: translateY(-2px);
        }
        
        .btn-danger:disabled {
            opacity: 0.6;
            transform: none;
            cursor: not-allowed;
        }
        
        .profile-avatar {
            background: linear-gradient(135deg, #ffffff 0%, #e5e7eb 100%);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            animation: slideDown 0.3s ease-out;
        }
        
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid #10b981;
            color: #10b981;
        }
        
        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid #ef4444;
            color: #ef4444;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            animation: fadeIn 0.3s ease-out;
        }
        
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: #1f2937;
            border: 1px solid #374151;
            border-radius: 0.75rem;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            animation: slideUp 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
                       <a href="{{ url('/home') }}" class="text-gray-300 hover:text-white transition-colors">Home</a>
                       

                        @auth
                            <!-- Show user menu when logged in -->
                            <div class="relative">
                                <button id="userMenuButton" class="text-gray-300 hover:text-white transition-colors flex items-center space-x-2">
                                    <span>{{ Auth::user()->name }}</span>
                 
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-700 rounded-t-lg">Dashboard</a>
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-gray-700">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
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

    <!-- Profile Header -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center slide-in staggered-1">
                <div class="w-32 h-32 profile-avatar rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-16 h-16 text-black" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold gradient-text mb-4">
                    Profile Settings
                </h1>
                <p class="text-xl text-gray-300 mb-8">
                    Manage your account information and preferences
                </p>
            </div>
        </div>
        
        <!-- Animated Background Elements -->
        <div class="absolute top-20 left-10 w-16 h-16 border border-gray-700 rounded-full opacity-20 floating-animation"></div>
        <div class="absolute top-32 right-20 w-12 h-12 border border-gray-600 rounded-lg opacity-30 floating-animation" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-10 left-1/4 w-10 h-10 border border-gray-800 rounded-full opacity-25 floating-animation" style="animation-delay: 4s;"></div>
    </div>

    <!-- Alert Messages Container -->
    <div id="alertContainer" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Profile Forms -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        <!-- Update Profile Information -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 slide-in staggered-2 card-hover">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-white">Profile Information</h3>
                    <p class="text-gray-400">Update your account's profile information and email address</p>
                </div>
            </div>
            
            <form id="profileForm" action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-input w-full px-4 py-3 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-input w-full px-4 py-3 rounded-lg" required>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary px-6 py-3 rounded-lg font-medium">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Update Password -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 slide-in staggered-3 card-hover">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-white">Update Password</h3>
                    <p class="text-gray-400">Ensure your account is using a long, random password to stay secure</p>
                </div>
            </div>
            
            <form id="passwordForm" action="{{ route('profile.password.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Current Password</label>
                    <input type="password" name="current_password" class="form-input w-full px-4 py-3 rounded-lg" placeholder="Enter current password" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                        <input type="password" name="password" class="form-input w-full px-4 py-3 rounded-lg" placeholder="Enter new password" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-input w-full px-4 py-3 rounded-lg" placeholder="Confirm new password" required>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary px-6 py-3 rounded-lg font-medium">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Two Factor Authentication -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 slide-in staggered-4 card-hover">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-white">Two Factor Authentication</h3>
                    <p class="text-gray-400">Add additional security to your account using two factor authentication</p>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                <div>
                    <p class="text-white font-medium">Two Factor Authentication</p>
                    <p class="text-gray-400 text-sm">Status: 
                        <span class="{{ Auth::user()->two_factor_secret ? 'text-green-400' : 'text-red-400' }}">
                            {{ Auth::user()->two_factor_secret ? 'Enabled' : 'Disabled' }}
                        </span>
                    </p>
                </div>
                @if(Auth::user()->two_factor_secret)
                    <form action="{{ route('profile.two-factor.disable') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger px-4 py-2 rounded-lg font-medium">
                            Disable 2FA
                        </button>
                    </form>
                @else
                    <form action="{{ route('profile.two-factor.enable') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary px-4 py-2 rounded-lg font-medium">
                            Enable 2FA
                        </button>
                    </form>
                @endif
            </div>

            @if(Auth::user()->two_factor_secret && session('two_factor_qr_code'))
                <div class="mt-6 p-4 bg-gray-800 rounded-lg">
                    <h4 class="text-lg font-semibold text-white mb-4">Setup Instructions</h4>
                    <p class="text-gray-300 mb-4">Scan this QR code with your authenticator app:</p>
                    <div class="bg-white p-4 rounded-lg inline-block">
                        <img src="{{ session('two_factor_qr_code') }}" alt="2FA QR Code" class="max-w-xs">
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-300 mb-2">Recovery Codes (save these in a safe place):</p>
                        <div class="bg-gray-700 p-4 rounded-lg">
                            @if(Auth::user()->two_factor_recovery_codes)
                                @foreach(Auth::user()->recoveryCodes() as $code)
                                    <code class="block text-green-400">{{ $code }}</code>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Browser Sessions -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 slide-in staggered-5 card-hover">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-white">Browser Sessions</h3>
                    <p class="text-gray-400">Manage and logout your active sessions on other browsers and devices</p>
                </div>
            </div>
            
            <div class="space-y-4" id="sessionsContainer">
                <!-- Sessions will be loaded here -->
                <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        </div>
                        <div>
                            <p class="text-white font-medium">Current Session</p>
                            <p class="text-gray-400 text-sm">{{ request()->userAgent() }}</p>
                        </div>
                    </div>
                    <span class="text-green-400 text-sm">Active</span>
                </div>
                
                <div class="flex justify-end mt-6">
                    <form action="{{ route('profile.sessions.destroy') }}" method="POST">
                        @csrf
                        <button type="button" onclick="logoutOtherSessions()" class="btn-danger px-6 py-3 rounded-lg font-medium">
                            Logout Other Sessions
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="bg-gray-900 border border-red-800 rounded-xl p-8 slide-in staggered-5 card-hover">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-white">Delete Account</h3>
                    <p class="text-gray-400">Permanently delete your account and all associated data</p>
                </div>
            </div>
            
            <div class="bg-red-900 bg-opacity-20 border border-red-800 rounded-lg p-4 mb-6">
                <p class="text-red-300 text-sm">
                    <strong>Warning:</strong> This action cannot be undone. This will permanently delete your account and remove your data from our servers.
                </p>
            </div>
            
            <div class="flex justify-end">
                <button onclick="confirmDelete()" class="btn-danger px-6 py-3 rounded-lg font-medium">
                    Delete Account
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3 class="text-2xl font-bold text-white mb-4">Confirm Account Deletion</h3>
            <p class="text-gray-300 mb-6">
                Are you sure you want to delete your account? This action cannot be undone and will permanently remove all your data.
            </p>
            
            <form id="deleteForm" action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Enter your password to confirm:
                    </label>
                    <input type="password" name="password" class="form-input w-full px-4 py-3 rounded-lg" placeholder="Enter your password" required>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeDeleteModal()" class="btn-primary px-6 py-3 rounded-lg font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="btn-danger px-6 py-3 rounded-lg font-medium">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sessions Password Modal -->
    <div id="sessionsModal" class="modal">
        <div class="modal-content">
            <h3 class="text-2xl font-bold text-white mb-4">Logout Other Sessions</h3>
            <p class="text-gray-300 mb-6">
                Please enter your password to confirm you would like to logout all of your other browser sessions.
            </p>
            
            <form id="sessionsForm" action="{{ route('profile.sessions.destroy') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Password:
                    </label>
                    <input type="password" name="password" class="form-input w-full px-4 py-3 rounded-lg" placeholder="Enter your password" required>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeSessionsModal()" class="btn-primary px-6 py-3 rounded-lg font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="btn-danger px-6 py-3 rounded-lg font-medium">
                        Logout Other Sessions
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Set up CSRF token for AJAX requests
        window.Laravel = {
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        // Modal functions
        function confirmDelete() {
            document.getElementById('deleteModal').classList.add('show');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('show');
        }

        function logoutOtherSessions() {
            document.getElementById('sessionsModal').classList.add('show');
        }

        function closeSessionsModal() {
            document.getElementById('sessionsModal').classList.remove('show');
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
            }
        });

        // Enhanced form handling with better UI feedback
        function handleFormSubmission(formId, successMessage) {
            const form = document.getElementById(formId);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            
            form.addEventListener('submit', function(e) {
                submitButton.textContent = 'Processing...';
                submitButton.disabled = true;
                
                // If this is an AJAX form, handle it here
                // For now, let the form submit normally
            });
        }

        // Initialize form handlers
        handleFormSubmission('profileForm', 'Profile updated successfully!');
        handleFormSubmission('passwordForm', 'Password updated successfully!');

        // Add hover effects to form inputs
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', () => {
                input.style.transform = 'translateY(-2px)';
            });
            input.addEventListener('blur', () => {
                input.style.transform = 'translateY(0)';
            });
        });

        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.animation = 'slideUp 0.3s ease-out forwards';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        });

        // User dropdown functionality
        const userMenuButton = document.getElementById('userMenuButton');
        const userDropdown = document.getElementById('userDropdown');
        
        if (userMenuButton && userDropdown) {
            userMenuButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!userDropdown.contains(e.target) && !userMenuButton.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }

       // Add smooth scrolling to page
        document.documentElement.style.scrollBehavior = 'smooth';
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
