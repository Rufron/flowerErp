<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FloriQ') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-pink-50">
        
        <!-- Logo -->
        <div class="mb-6">
            <a href="/" class="flex flex-col items-center">
                <!-- Flower Icon -->
                <svg class="w-16 h-16 text-pink-500 mb-2" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 3C12 3 9 5 9 8C9 11 12 13 12 13C12 13 15 11 15 8C15 5 12 3 12 3Z"/>
                    <path d="M12 13C12 13 14 15 14 18C14 21 12 22 12 22C12 22 10 21 10 18C10 15 12 13 12 13Z"/>
                    <circle cx="12" cy="10" r="2" fill="white"/>
                </svg>
                <span class="text-2xl font-semibold text-gray-800">FloriQ</span>
            </a>
        </div>

        <!-- Auth Card - White with pink accent -->
        <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-lg rounded-lg border border-pink-100">
            {{ $slot }}
        </div>
    </div>
</body>
</html>