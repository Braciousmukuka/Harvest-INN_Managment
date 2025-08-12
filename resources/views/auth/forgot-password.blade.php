<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-harvest-green">Reset Your Password</h2>
        <p class="text-gray-600 mt-4 mb-6">
            {{ __('Enter your email address and we will send you a link to reset your password.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="your.email@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a href="{{ route('login') }}" class="text-sm text-harvest-green hover:text-harvest-green-dark hover:underline">
                {{ __('Back to Login') }}
            </a>

            <x-primary-button>
                {{ __('Send Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
