@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="md:flex">
            <!-- Product Image -->
            <div class="md:w-1/2 p-6">
                <img src="{{ asset('storage/products/' . basename($product->image)) }}" 
                     alt="{{ $product->name }}"
                     class="w-full h-96 object-cover rounded-xl shadow-md">
            </div>

            <!-- Product Details -->
            <div class="md:w-1/2 p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>
                
                <!-- Price -->
                <div class="mb-6">
                    <span class="text-2xl font-bold text-pink-600">
                        ${{ number_format($product->price ?? 25, 2) }}
                    </span>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">About this Flower</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $product->description ?? 'Beautiful fresh flower perfect for any occasion.' }}
                    </p>
                </div>

                <!-- Stock Status -->
                <div class="mb-8">
                    @if($product->stock > 0)
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-800 font-medium">
                        ✓ In Stock - Ready to Ship
                    </div>
                    @else
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-red-100 text-red-800 font-medium">
                        ✗ Out of Stock
                    </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                @if($product->stock > 0)
                <div class="space-y-4">
                    <!-- Buy Now Button - Add to cart and redirect to checkout -->
                    <button type="button"
                            class="buy-now-btn w-full px-6 py-4 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition font-medium text-center text-lg"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price ?? 25 }}"
                            data-qty="1">
                        Buy Now
                    </button>
                    
                    <!-- Add to Cart Button - Add to cart only -->
                    <button type="button"
                            class="add-to-cart-detail w-full px-6 py-3 border-2 border-pink-600 text-pink-600 rounded-lg hover:bg-pink-50 transition font-medium"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price ?? 25 }}"
                            data-qty="1">
                        Add to Cart
                    </button>
                </div>
                @endif

                <!-- Back to Products -->
                <div class="mt-10 pt-6 border-t border-gray-200">
                    <a href="{{ route('customer.dashboard') }}" 
                       class="inline-flex items-center text-pink-600 hover:text-pink-800 font-medium">
                        ← Back to All Flowers
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // CART_KEY should match your store.js
    const CART_KEY = 'flower_cart_v1';
    
    // Function to add item to localStorage cart
    function addToCart(item) {
        const cart = getCart();
        // find by id if present; otherwise use name+price fallback
        const idx = cart.findIndex(ci => 
            (ci.id && item.id && String(ci.id) === String(item.id)) || 
            (ci.name === item.name && ci.price === item.price)
        );
        
        if (idx > -1) {
            cart[idx].qty = Number(cart[idx].qty) + Number(item.qty);
        } else {
            cart.push(item);
        }
        
        saveCart(cart);
        showNotification(item.name + ' added to cart!');
    }
    
    function getCart() {
        try {
            return JSON.parse(localStorage.getItem(CART_KEY) || '[]');
        } catch (e) {
            return [];
        }
    }
    
    function saveCart(cart) {
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
    }
    
    function showNotification(message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition transform translate-y-0';
        notification.textContent = message;
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    
    // Handle Add to Cart button
    const addToCartBtn = document.querySelector('.add-to-cart-detail');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const item = {
                id: this.dataset.id || null,
                name: this.dataset.name || 'Item',
                price: parseFloat(this.dataset.price || 0) || 0,
                qty: parseInt(this.dataset.qty || 1, 10) || 1
            };
            
            addToCart(item);
        });
    }
    
    // Handle Buy Now button
    const buyNowBtn = document.querySelector('.buy-now-btn');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            const item = {
                id: this.dataset.id || null,
                name: this.dataset.name || 'Item',
                price: parseFloat(this.dataset.price || 0) || 0,
                qty: parseInt(this.dataset.qty || 1, 10) || 1
            };
            
            addToCart(item);
            
            // Redirect to checkout
            window.location.href = '{{ route("customer.checkout") }}';
        });
    }
});
</script>
@endpush