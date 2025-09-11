<h3 class="mt-8 mb-4 text-xl font-semibold text-gray-800 flex items-center gap-2">
  📦 Orders Overview
</h3>

<div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full border-collapse text-left text-gray-700">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-sm font-medium text-gray-500">#</th>
          <th class="px-6 py-3 text-sm font-medium text-gray-500">Customer</th>
          <th class="px-6 py-3 text-sm font-medium text-gray-500">Flower(s)</th>
          <th class="px-6 py-3 text-sm font-medium text-gray-500">Status</th>
          <th class="px-6 py-3 text-sm font-medium text-gray-500">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4">#{{ $order->id }}</td>
            <td class="px-6 py-4">{{ $order->customer->name ?? 'Guest' }}</td>
            <td class="px-6 py-4">
              @foreach($order->items as $item)
                <span class="block">{{ $item->product->name }} (x{{ $item->qty }})</span>
              @endforeach
            </td>
            <td class="px-6 py-4">
              @if($order->status === 'pending')
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                  Pending
                </span>
              @elseif($order->status === 'processing')
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                  Processing
                </span>
              @elseif($order->status === 'completed')
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                  Completed
                </span>
              @elseif($order->status === 'cancelled')
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                  Cancelled
                </span>
              @endif
            </td>
            <td class="px-6 py-4 space-x-2">
              <form method="POST" action="{{ route('admin.orders.update', [$order->id, 'status' => 'processing']) }}" class="inline">
                @csrf
                @method('PATCH')
                <button class="px-3 py-1 rounded-lg bg-green-100 text-green-700 hover:bg-green-200 text-sm font-medium">
                  Approve
                </button>
              </form>

              <form method="POST" action="{{ route('admin.orders.update', [$order->id, 'status' => 'completed']) }}" class="inline">
                @csrf
                @method('PATCH')
                <button class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 text-sm font-medium">
                  Ship
                </button>
              </form>

              <form method="POST" action="{{ route('admin.orders.update', [$order->id, 'status' => 'cancelled']) }}" class="inline">
                @csrf
                @method('PATCH')
                <button class="px-3 py-1 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 text-sm font-medium">
                  Cancel
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">
              No orders found
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Pagination -->
<div class="mt-4">
  {{ $orders->links() }}
</div>
