<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
        <p class="text-sm text-gray-500 mt-1">Join FloriQ</p>
    </div>

    <!-- SINGLE FORM - NOT MULTIPLE -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500"
                placeholder="John Doe">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500"
                placeholder="your@email.com">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500"
                placeholder="••••••••">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500"
                placeholder="••••••••">
        </div>

        <!-- Terms -->
        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="terms" required class="rounded border-gray-300 text-pink-500 focus:ring-pink-500">
                <span class="ml-2 text-sm text-gray-600">
                    I agree to the <a href="#" class="text-pink-600 hover:text-pink-500">Terms</a> and <a href="#" class="text-pink-600 hover:text-pink-500">Privacy Policy</a>
                </span>
            </label>
        </div>


        <!-- Submit Button -->
        <button type="submit" class="w-full bg-pink-500 text-white py-2 px-4 rounded-lg hover:bg-pink-600 transition font-medium">
            Create Account
        </button>

        <!-- Google sign in -->
         <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Or sign up with</span>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('auth.google.redirect') }}" 
                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                        <!-- Same Google SVG as above -->
                    </svg>
                    Sign up with Google
                </a>
            </div>
        </div>

        <!-- Login Link -->
        <p class="mt-4 text-center text-sm text-gray-600">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-pink-600 hover:text-pink-500 font-medium">
                Sign in
            </a>
        </p>
    </form>
</x-guest-layout>