<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Berry Dashboard CSS -->
        <link href="{{ asset('assets/css/plugins/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/fonts/tabler-icons.min.css') }}" rel="stylesheet">
        
        <!-- Feather Icons -->
        <link href="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.css" rel="stylesheet">
        
        <!-- Page specific styles -->
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow border-b border-harvest-gold/20">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            
            <!-- Flash Messages -->
            @include('components.flash-messages')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        <!-- Berry Dashboard JS -->
        <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/pcoded.js') }}"></script>
        
        <!-- Feather Icons JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.js"></script>
        <script>
            // Initialize Feather icons globally
            document.addEventListener('DOMContentLoaded', function() {
                feather.replace();
            });
        </script>
        
        <!-- Page specific scripts -->
        @stack('scripts')
    </body>
</html>