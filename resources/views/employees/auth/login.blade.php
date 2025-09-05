<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Login</title>
  @vite('resources/css/app.css') {{-- make sure Tailwind is included --}}
</head>
<body class="bg-gray-50">

  <div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow p-8">
      <h1 class="text-2xl font-bold text-gray-800 text-center">Employee Login</h1>
      <p class="text-sm text-gray-500 text-center mt-1">Sign in to manage products & orders</p>

      @if ($errors->any())
        <div class="mt-4 rounded-lg bg-red-50 text-red-700 p-3 text-sm">
          {{ $errors->first() }}
        </div>
      @endif

      <form class="mt-6 space-y-4" method="POST" action="{{ route('employees.login.submit') }}">
        @csrf
        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" value="{{ old('email') }}"
                class="mt-1 w-full rounded-lg border-gray-300 focus:ring-pink-500 focus:border-pink-500"
                required autofocus>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" name="password"
                class="mt-1 w-full rounded-lg border-gray-300 focus:ring-pink-500 focus:border-pink-500"
                required>
        </div>

        <div class="flex items-center justify-between">
          <label class="inline-flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="remember" class="rounded border-gray-300">
            Remember me
          </label>
        </div>

        <button type="submit"
                class="w-full inline-flex justify-center rounded-lg bg-pink-600 px-4 py-2.5 font-medium text-white hover:bg-pink-700 transition">
          Sign In
        </button>
      </form>

      <div class="mt-6 text-center">
        <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:underline">← Back to site</a>
      </div>
    </div>
  </div>

</body>
</html>
