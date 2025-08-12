<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-harvest-green">Reset Password</h2>
        <p class="text-gray-600 mt-2">Create a new password for your account</p>
    </div>
    
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Enter your new password" />
            <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters long</p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Re-enter your new password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a href="{{ route('login') }}" class="text-sm text-harvest-green hover:text-harvest-green-dark hover:underline">
                {{ __('Back to Login') }}
            </a>
            
            <x-primary-button class="px-8 py-3">
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
