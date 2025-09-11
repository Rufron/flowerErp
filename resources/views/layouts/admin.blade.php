{{-- This will display the admin layout --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="flex">
        <!-- Sidebar -->
        <aside
            class="sticky top-0 z-20 w-64 bg-gradient-to-b from-pink-50 to-white shadow-xl h-screen p-6 flex flex-col">
            <!-- Branding -->
            <div class="flex items-center gap-2 mb-10">
                <span class="text-3xl">🌸</span>
                <h2 class="text-2xl font-extrabold text-pink-600 tracking-tight">Flower Admin</h2>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2 flex-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 py-2.5 px-4 rounded-lg text-gray-700 font-medium hover:bg-pink-100 hover:text-pink-700 transition">
                    <span>📊</span> Dashboard
                </a>
                <a href="{{ route('admin.inventory.index') }}"
                    class="flex items-center gap-3 py-2.5 px-4 rounded-lg text-gray-700 font-medium hover:bg-pink-100 hover:text-pink-700 transition">
                    <span>🌼</span> Inventory
                </a>
                {{-- <a href="#"
                    class="flex items-center gap-3 py-2.5 px-4 rounded-lg text-gray-700 font-medium hover:bg-pink-100 hover:text-pink-700 transition">
                    <span>🛒</span> Orders
                </a> --}}
                <a href="{{ route('admin.employees.index') }}"
                    class="flex items-center gap-3 py-2.5 px-4 rounded-lg text-gray-700 font-medium hover:bg-pink-100 hover:text-pink-700 transition">
                    <span> 👥</span> Employees
                </a>
            </nav>

            <!-- Footer -->
            <div class="mt-8 border-t pt-4 text-sm text-gray-500">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 py-2.5 px-4 rounded-lg text-red-600 font-medium hover:bg-red-100 transition">
                        🚪 Logout
                    </button>
                </form>
                <p class="mt-4 text-xs text-gray-400">© 2025 Flower Admin</p>
            </div>
        </aside>


        <!-- Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>

</html>
