<div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Total Orders -->
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <h4 class="text-sm font-medium text-gray-500">Total Orders Today</h4>
            <span class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                📦
            </span>
        </div>
        <p class="mt-3 text-3xl font-bold text-gray-800">{{ $totalOrdersToday }}</p>
    </div>


    <!-- Revenue -->
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <h4 class="text-sm font-medium text-gray-500">Revenue Today</h4>
            <span class="p-2 bg-green-100 text-green-600 rounded-lg">
                💰
            </span>
        </div>
        <p class="mt-3 text-3xl font-bold text-gray-800">
            ${{ number_format($totalRevenueToday, 2) }}
        </p>
    </div>


    <!-- Customers -->
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <h4 class="text-sm font-medium text-gray-500">Total Customers</h4>
            <span class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                👥
            </span>
        </div>
        <p class="mt-3 text-3xl font-bold text-gray-800">
            {{ number_format($totalCustomers) }}
        </p>
    </div>


    <!-- Low Stock -->
    {{-- <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <h4 class="text-sm font-medium text-gray-500">Low Stock Flowers</h4>
            <span class="p-2 bg-red-100 text-red-600 rounded-lg">
                ⚠️
            </span>
        </div>
        <p class="mt-3 text-3xl font-bold text-gray-800">8</p>
    </div> --}}
</div>
