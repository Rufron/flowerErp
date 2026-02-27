<div class="max-w-7xl mx-auto px-4">
    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6">
        @foreach ($products as $product)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
                <!-- Make image clickable to detail page -->
                <a href="{{ route('customer.product.detail', $product->id) }}" class="block">
                    <img src="{{ asset('storage/products/' . basename($product->image)) }}" 
                         alt="{{ $product->name }}"
                         class="h-48 w-full object-cover rounded-t-xl hover:opacity-90 transition">
                         
                </a>

                <!-- <div>
                    <div style="display: none;">
                        Product ID: {{ $product->id }}<br>
                        Raw image: {{ $product->image }}<br>
                        Basename: {{ basename($product->image) }}<br>
                        Full URL: {{ asset('storage/products/' . basename($product->image)) }}
                    </div>
                    
                    <img src="{{ asset('storage/products/' . basename($product->image)) }}" 
                        alt="{{ $product->name }}"
                        onerror="this.onerror=null; console.log('Failed to load: ' + this.src);">
                </div> -->
                
                <div class="p-4 flex flex-col items-center">
                    <h5 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h5>
                    <p class="text-pink-600 font-bold mb-3">${{ number_format($product->price ?? 25, 2) }}</p>

                    <!-- Simple link to detail page -->
                    <a href="{{ route('customer.product.detail', $product->id) }}"
                        class="w-full px-4 py-2 bg-pink-500 text-white rounded-full shadow hover:bg-pink-600 text-center">
                        View Details
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination Controls -->
    <div class="flex justify-center mt-6">
        {{ $products->links() }}
    </div>
</div>