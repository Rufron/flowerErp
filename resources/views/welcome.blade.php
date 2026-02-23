<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Flower Shop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <!-- Top Bar -->
    <header class="bg-white shadow sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
           
            <!-- Branding -->
            <a href="{{ url('/') }}" class="text-2xl font-bold text-pink-600 flex items-center gap-2">
                 <!-- logo -->
                <svg class="h-9 w-auto fill-current text-pink-500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C12 2 9 4 9 7C9 9 12 11 12 11C12 11 15 9 15 7C15 4 12 2 12 2Z"/>
                    <path d="M12 11C12 11 14 13 14 16C14 19 12 21 12 21C12 21 10 19 10 16C10 13 12 11 12 11Z"/>
                    <circle cx="12" cy="9" r="2" fill="white"/>
                </svg>

                Floriq  Shop
            </a>

            <!-- Auth Links -->
            <div class="space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="px-4 py-2 bg-pink-500 text-white rounded-lg shadow hover:bg-pink-600">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-4 py-2 bg-pink-500 text-white rounded-lg shadow hover:bg-pink-600">
                                Sign up
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero (slider) -->
    @include('customer.hero')

    <!-- Featured (search + filter) -->
    @include('customer.featured')

    <!-- Product Grid (qualities) -->
    <section class="max-w-7xl mx-auto px-6 py-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Our Flowers</h2>
        @include('customer.qualities')
    </section>

</body>
</html>
