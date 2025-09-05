

<div class="p-6 bg-white rounded-2xl shadow mb-6">
  <h3 class="text-xl font-semibold text-gray-800 mb-3">🛒 Your Cart</h3>

  <!-- JS will dynamically insert items here -->
  <ul data-cart-list class="space-y-2 mb-4"></ul>

  <a href="{{ route('checkout') }}"
     data-cart-checkout
     class="inline-block w-full text-center px-6 py-2 bg-pink-600 text-white font-medium rounded-lg shadow hover:bg-pink-700 transition">
    Checkout
  </a>
</div>

