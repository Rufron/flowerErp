@extends('layouts.app')

@section('content')
@include('customer.categories')
<div class="p-4 bg-gradient-to-r from-pink-100 via-purple-100 to-yellow-100 rounded-xl shadow mt-6" id="product-list">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">

        <!-- Flower Card -->
        <div class="relative bg-white rounded-xl shadow-md overflow-hidden transform hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
            <!-- Decorative petals -->
            <div class="absolute -top-2 -left-2 w-8 h-8 bg-pink-200 rounded-full opacity-70"></div>
            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-yellow-200 rounded-full opacity-70"></div>

            <img src="https://images.pexels.com/photos/53141/rose-red-blossom-bloom-53141.jpeg"
                 alt="Roses"
                 class="w-full h-32 object-cover rounded-t-xl transform hover:scale-105 transition duration-500">

            <div class="p-3 text-center">
                <h5 class="text-base font-semibold text-gray-800">🌹 Red Roses</h5>
                <p class="text-pink-600 font-medium mb-2 text-sm">$25</p>

                <button
                    class="add-to-cart inline-block px-3 py-1.5 bg-gradient-to-r from-pink-500 to-red-500 text-white text-sm font-medium rounded-full shadow hover:from-red-500 hover:to-pink-500 transform hover:scale-105 transition duration-300"
                    data-id="1" data-name="Rose" data-price="25">
                    Add to Cart
                </button>
            </div>
        </div>

        <!-- Flower Card -->
        <div class="relative bg-white rounded-xl shadow-md overflow-hidden transform hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-purple-200 rounded-full opacity-70"></div>
            <div class="absolute -bottom-2 -left-2 w-10 h-10 bg-green-200 rounded-full opacity-70"></div>

            <img src="https://images.pexels.com/photos/350349/pexels-photo-350349.jpeg"
                 alt="Tulips"
                 class="w-full h-32 object-cover rounded-t-xl transform hover:scale-105 transition duration-500">

            <div class="p-3 text-center">
                <h5 class="text-base font-semibold text-gray-800">🌷 Tulips</h5>
                <p class="text-pink-600 font-medium mb-2 text-sm">$15</p>

                <button
                    class="add-to-cart inline-block px-3 py-1.5 bg-gradient-to-r from-yellow-400 to-pink-500 text-white text-sm font-medium rounded-full shadow hover:from-pink-500 hover:to-yellow-400 transform hover:scale-105 transition duration-300"
                    data-id="2" data-name="Tulip" data-price="15">
                    Add to Cart
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
