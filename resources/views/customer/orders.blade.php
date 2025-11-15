<h3 class="mt-8 text-xl font-bold text-gray-800 flex items-center gap-2">
  📦 Recent Orders
</h3>

<div class="mt-6 overflow-hidden rounded-xl border border-gray-200 shadow-md">
  <table class="min-w-full text-sm text-left">
    <thead class="bg-gray-100 text-gray-700">
      <tr>
        <th class="px-6 py-3 font-semibold">Order ID</th>
        <th class="px-6 py-3 font-semibold">Items</th>
        <th class="px-6 py-3 font-semibold">Total</th>
        <th class="px-6 py-3 font-semibold">Date</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
      @forelse($orders as $order)
        <tr class="hover:bg-gray-50 transition">
          <td class="px-6 py-4 font-medium text-gray-800">
            #{{ $order->id }}
          </td>
          <td class="px-6 py-4 text-gray-600">
            @foreach($order->items as $item)
              <span class="block">
                {{ $item->product->name ?? 'Unknown product'}}
                <span class="text-gray-500 text-xs">(x{{ $item->qty }})</span>
              </span>
            @endforeach
          </td>
          <td class="px-6 py-4 font-semibold text-green-600">
            $ {{ number_format($order->subtotal, 2) }}
          </td>
          <td class="px-6 py-4 text-gray-500">
            {{ $order->created_at->format('M d, Y H:i') }}
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="px-6 py-4 text-center text-gray-500 italic">
            No orders yet
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
