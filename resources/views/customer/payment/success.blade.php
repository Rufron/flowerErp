@extends('layouts.checkout')

@section('content')
<div class="bg-white shadow-lg rounded-2xl p-8 max-w-lg text-center mx-auto mt-20">
  <h1 class="text-2xl font-bold text-green-600 mb-4">🎉 Order Confirmed!</h1>
  <p class="text-gray-700 mb-2">Thank you for your purchase.</p>
  <p id="order-id" class="text-sm text-gray-500">
    @if(isset($order))
      Order ID: #{{ $order->id }}
    @endif
  </p>

  <div id="order-summary" class="mt-6 text-left">
    @if(isset($order))
      <h2 class="text-lg font-semibold mb-3">Order Summary</h2>
      <ul class="space-y-2">
        @foreach($order->items as $it)
          <li class="flex justify-between border-b pb-1">
            <span>{{ $it->qty }}× {{ $it->name }}</span>
            <span>${{ number_format($it->price * $it->qty, 2) }}</span>
          </li>
        @endforeach
      </ul>
      <p class="mt-4 font-bold">Total: ${{ number_format($order->subtotal, 2) }}</p>
    @endif
  </div>

  <a href="{{ route('customer.dashboard') ?? '/dasboard' }}"
     class="inline-block mt-6 bg-pink-600 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-700">
    Continue Shopping
  </a>
</div>
@endsection

@push('scripts')
<script>
  // existing client-side fallback: read order from localStorage if order not passed server-side
  (function () {
    if (document.getElementById('order-summary').children.length > 0) return; // server-side already rendered

    const params = new URLSearchParams(window.location.search);
    const orderId = params.get("orderId");

    if (orderId) {
      const orders = JSON.parse(localStorage.getItem("flower_orders_v1") || "[]");
      const order = orders.find(o => String(o.id) === orderId);

      if (order) {
        document.getElementById("order-id").textContent = `Order ID: #${order.id}`;
        const summary = document.getElementById("order-summary");

        let html = `
          <h2 class="text-lg font-semibold mb-3">Order Summary</h2>
          <ul class="space-y-2">
        `;
        order.items.forEach(item => {
          html += `
            <li class="flex justify-between border-b pb-1">
              <span>${item.qty}× ${item.name}</span>
              <span>$${(item.price * item.qty).toFixed(2)}</span>
            </li>
          `;
        });
        html += `</ul>
          <p class="mt-4 font-bold">Total: $${order.subtotal.toFixed(2)}</p>
        `;
        summary.innerHTML = html;
      }
    }
  })();
</script>
@endpush
