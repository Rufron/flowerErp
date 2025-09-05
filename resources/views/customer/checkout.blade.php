@extends('layouts.checkout')
<div class="p-8 bg-white rounded-2xl shadow-lg max-w-3xl mx-auto mt-8">
    <!-- Header -->
    <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center">
        🛍️ <span class="ml-2">Checkout</span>
    </h2>

    <!-- Cart Summary -->
    <!-- Checkout Table -->
    <table class="w-full border">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody data-order-table></tbody>
    </table>

    <!-- Subtotal -->
    <div class="text-right mt-4">
        <strong>Subtotal: </strong>
        <span data-order-subtotal>$0.00</span>
    </div>

    <!-- Place Order Button -->
    <div class="mt-6 text-right">
        <button data-order-place class="bg-pink-600 text-white px-6 py-2 rounded-lg">
            Place Order
        </button>
    </div>




    {{-- <!-- Payment Method -->
    <div class="mb-8 border-b pb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Method</h3>
        <div class="space-y-3">
            <label class="flex items-center space-x-3 cursor-pointer">
                <input type="radio" name="payment" class="text-pink-600 focus:ring-pink-500" checked>
                <span class="text-gray-700">Cash on Delivery</span>
            </label>
            <label class="flex items-center space-x-3 cursor-pointer">
                <input type="radio" name="payment" class="text-pink-600 focus:ring-pink-500">
                <span class="text-gray-700">Credit/Debit Card</span>
            </label>
        </div>
    </div> --}}

    {{-- <!-- Place Order Button -->
    <a href="{{ route('order.success') }}"
        class="block w-full text-center px-6 py-3 bg-pink-600 text-white font-semibold rounded-lg shadow-md hover:bg-pink-700 hover:shadow-lg transition data-order-place">
        Place Order
    </a> --}}
</div>


<!-- Scripts -->
<script src="/js/store.js"></script>
<script src="/js/order/order.js"></script>
