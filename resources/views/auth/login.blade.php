<x-guest-layout>
    <div class="min-h-screen bg-black text-white flex items-center justify-center">
        <div class="max-w-md w-full mx-auto p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mx-auto mb-4">
                    <span class="text-black font-bold text-xl mono">A</span>
                </div>
                <h1 class="text-2xl font-bold mono">AMEX Training Institute</h1>
                <p class="text-gray-400 mt-2">Sign in to your account</p>
            </div>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" class="text-white" />
                    <x-input id="email" class="block mt-1 w-full bg-gray-800 border-gray-700 text-white" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div>
                    <x-label for="password" value="{{ __('Password') }}" class="text-white" />
                    <x-input id="password" class="block mt-1 w-full bg-gray-800 border-gray-700 text-white" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="flex items-center">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-300">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-400 hover:text-white" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-button class="ml-4 bg-white text-black hover:bg-gray-200">
                        {{ __('Log in') }}
                    </x-button>
                </div>

                <div class="text-center">
                    <p class="text-gray-400">Don't have an account? 
                        <a href="{{ route('register') }}" class="text-white hover:underline">Sign up</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>