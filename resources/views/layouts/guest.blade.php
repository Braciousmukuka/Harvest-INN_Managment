<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Prevent Caching During Development -->
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">

        <title>{{ config('app.name', 'HarvestInn') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-white to-gray-100">
            <div class="mb-4">
                <a href="/">
                    <img src="{{ asset('Harvest.svg') }}" alt="HarvestInn Logo" class="h-24">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-4 px-8 py-8 bg-white shadow-lg overflow-hidden sm:rounded-lg border border-harvest-gold/30">
                {{ $slot }}
            </div>
            
            <div class="mt-6 text-center text-gray-600 text-sm">
                &copy; {{ date('Y') }} HarvestInn. All rights reserved.
            </div>
        </div>
    </body>
</html>
