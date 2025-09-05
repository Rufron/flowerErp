@extends('layouts.app')

@section('content')
@include('customer.categories')
<div class="p-6">
    <h1 class="text-2xl font-bold text-pink-600">🛍️ Shop Flowers</h1>
    <p class="mt-2 text-gray-600">Browse and add flowers to your cart.</p>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 border rounded-xl shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold text-pink-700">Roses</h2>
            <p class="text-gray-700">Beautiful roses for all occasions.</p>
            <button class="mt-3 px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                Add to Cart
            </button>
        </div>

        <div class="p-4 border rounded-xl shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold text-pink-700">Tulips</h2>
            <p class="text-gray-700">Beautiful tulips for all occasions.</p>
            <button class="mt-3 px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                Add to Cart
            </button>
        </div>

        <div class="p-4 border rounded-xl shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold text-pink-700">Lilies</h2>
            <p class="text-gray-700">Beautiful lilies for all occasions.</p>
            <button class="mt-3 px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                Add to Cart
            </button>
        </div>
    </div>
</div>
@endsection
