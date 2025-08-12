<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-harvest-green">Welcome Back</h2>
        <p class="text-gray-600 mt-2">Log in to access your HarvestInn dashboard</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="your.email@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="Enter your password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-5">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-harvest-green shadow-sm focus:ring-harvest-green" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-8">
            @if (Route::has('password.request'))
                <a class="text-sm text-harvest-green hover:text-harvest-green-dark hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-harvest-green mb-4 sm:mb-0" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="w-full sm:w-auto px-8 py-3 justify-center font-bold btn-visible">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        
        <div class="mt-8 text-center pt-5 border-t border-gray-200">
            <p class="text-sm text-gray-600">Don't have an account? 
                <a href="{{ route('register') }}" class="text-harvest-green hover:text-harvest-green-dark hover:underline font-medium">
                    {{ __('Register now') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
