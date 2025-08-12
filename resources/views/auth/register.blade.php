<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-harvest-green">Create Your Account</h2>
        <p class="text-gray-600 mt-2">Join HarvestInn to manage your farm effectively</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="your.email@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Create a strong password" />
            
            <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters long</p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" 
                            required autocomplete="new-password"
                            placeholder="Re-enter your password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms of Service -->
        <div class="block mt-5">
            <label for="terms" class="inline-flex items-center">
                <input id="terms" type="checkbox" class="rounded border-gray-300 text-harvest-green shadow-sm focus:ring-harvest-green" name="terms" required>
                <span class="ms-2 text-sm text-gray-600">
                    I agree to the <a href="#" class="text-harvest-green hover:underline">Terms of Service</a> and <a href="#" class="text-harvest-green hover:underline">Privacy Policy</a>
                </span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-8">
            <a class="text-sm text-harvest-green hover:text-harvest-green-dark hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-harvest-green mb-4 sm:mb-0" href="{{ route('login') }}">
                {{ __('Already have an account?') }}
            </a>

            <x-primary-button class="w-full sm:w-auto px-8 py-3 justify-center font-bold btn-visible">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
