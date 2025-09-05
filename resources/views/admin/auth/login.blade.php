<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto mt-20 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-4">
                <label class="block font-medium">Email</label>
                <input type="email" name="email"
                       class="w-full border p-2 rounded focus:outline-none focus:ring focus:ring-blue-300"
                       required>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Password</label>
                <input type="password" name="password"
                       class="w-full border p-2 rounded focus:outline-none focus:ring focus:ring-blue-300"
                       required>
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Login
            </button>
        </form>
    </div>
</body>
</html>
