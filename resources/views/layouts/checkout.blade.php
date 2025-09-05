<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  @vite('resources/css/app.css') <!-- Tailwind is still here -->
</head>
<body class="bg-gray-100">
  <main class="min-h-screen flex items-center justify-center">
    @yield('content')
  </main>
  <script src="{{ asset('js/store.js') }}"></script>
</body>
</html>
