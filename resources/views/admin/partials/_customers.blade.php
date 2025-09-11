<h3 class="mt-8 text-xl font-semibold text-gray-800 flex items-center gap-2">
    👥 Customers Overview
</h3>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
    <!-- Recent Signups -->
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <h5 class="text-sm font-medium text-gray-500">Recent Signups</h5>

        <ul class="mt-4 space-y-3">
            @forelse ($recentSignups as $user)
                <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="text-gray-700">{{ $user->name }}</span>
                    <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li class="p-3 text-gray-500">No recent signups</li>
            @endforelse
        </ul>
    </div>


    <!-- Top Buyers -->
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <h5 class="text-sm font-medium text-gray-500">Top Buyers</h5>

        <ul class="mt-4 space-y-3">
            @forelse ($topBuyers as $buyer)
                <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="text-gray-700">{{ $buyer->name }}</span>
                    <span class="font-semibold text-green-600">
                        ${{ number_format($buyer->total_spent, 2) }}
                    </span>
                </li>
            @empty
                <li class="p-3 text-gray-500">No buyers yet</li>
            @endforelse
        </ul>
    </div>

</div>
