<div class="p-6 bg-white rounded-2xl shadow mt-6" id="product-list">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">🌼 Featured Flowers</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <!-- Flower Card -->
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
            <img src="/images/rose.jpg" alt="Roses" class="w-full h-40 object-cover">
            <div class="p-4 text-center">
                <h5 class="text-lg font-semibold text-gray-800">Red Roses</h5>
                <p class="text-pink-600 font-medium mb-3">$25</p>
                {{-- <a href="#"
                    class="inline-block px-4 py-2 border border-pink-500 text-pink-500 rounded-lg hover:bg-pink-500 hover:text-white transition  js-add-to-cart"
                    data-id="1" data-name="Red Roses" data-price="25" data-image="/images/rose.jpg">
                    Add to Cart
            </a> --}}
             <button class="add-to-cart inline-block px-4 py-2 border border-pink-500 text-pink-500 rounded-lg hover:bg-pink-500 hover:text-white transition" data-id="1" data-name="Rose" data-price="10">Add to Cart</button>
            </div>
        </div>

        <!-- Repeat more flower cards -->
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
            <img src="/images/tulip.jpg" alt="Tulips" class="w-full h-40 object-cover">
            <div class="p-4 text-center">
                <h5 class="text-lg font-semibold text-gray-800">Tulips</h5>
                <p class="text-pink-600 font-medium mb-3">$15</p>
                {{-- <a href="#"
                    class="inline-block px-4 py-2 border border-pink-500 text-pink-500 rounded-lg hover:bg-pink-500 hover:text-white transition  js-add-to-cart"
                    data-id="2" data-name="Tulips" data-price="15" data-image="/images/tulip.jpg">
                    Add to Cart
            </a> --}}
            <button class="add-to-cart inline-block px-4 py-2 border border-pink-500 text-pink-500 rounded-lg hover:bg-pink-500 hover:text-white transition" data-id="2" data-name="Tulip" data-price="15">Add to Cart</button>
            </div>
        </div>


        <!-- Add more flowers as needed -->
    </div>
</div>
