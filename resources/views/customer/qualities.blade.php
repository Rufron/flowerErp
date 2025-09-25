<div class="max-w-7xl mx-auto px-4">
    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6">
        @foreach ($products as $product)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
                {{-- <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                    class="h-48 w-full object-cover rounded-t-xl" > --}}
                    <img src="{{ asset('storage/products/' . basename($product->image)) }}" alt="{{ $product->name }}"
    class="h-48 w-full object-cover rounded-t-xl">


                <div class="p-4 flex flex-col items-center">
                    <h5 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h5>
                    <p class="text-pink-600 font-bold mb-3">$25</p>

                    @if (auth()->check())
                        <button
                            class="add-to-cart px-4 py-2 bg-pink-500 text-white rounded-full shadow hover:bg-pink-600"
                            data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="25"
                            data-qty="1">
                            Add to Cart
                        </button>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 bg-pink-500 text-white rounded-full shadow hover:bg-pink-600">
                            Login to Buy
                        </a>
                    @endif


                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination Controls -->
    <div class="flex justify-center mt-6">
        {{ $products->links() }}
    </div>
</div>
