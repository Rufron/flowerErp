@extends('layouts.checkout')

<script>
    // This MUST be set before any other scripts
    window.csrfToken = "{{ csrf_token() }}";
    window.routes = {
        placeOrder: "{{ route('customer.checkout.place') }}",
        orderSuccess: "{{ route('customer.order.success') }}",
        mpesaStkPush: "{{ route('customer.mpesa.stk-push') }}",
        mpesaCallback: "{{ route('customer.mpesa.callback') }}",
        checkout: "{{ route('customer.checkout') }}"
    };
    
    console.log('✅ Routes initialized:', window.routes);
    console.log('✅ CSRF Token initialized:', !!window.csrfToken);
</script>

<div class="p-8 bg-white rounded-2xl shadow-lg max-w-3xl mx-auto mt-8">
    <!-- Header -->
    <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center">
        🛍️ <span class="ml-2">Checkout</span>
    </h2>

    <!-- Cart Summary -->
    <table class="w-full border mb-6">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left">Product</th>
                <th class="px-4 py-2 text-left">Price</th>
                <th class="px-4 py-2 text-left">Qty</th>
                <th class="px-4 py-2 text-left">Total</th>
            </tr>
        </thead>
        <tbody data-order-table></tbody>
    </table>

    <!-- Subtotal -->
    <div class="text-right mt-4 mb-8">
        <strong class="text-lg">Subtotal: </strong>
        <span class="text-xl font-bold text-pink-600" data-order-subtotal>$0.00</span>
        <span class="hidden" data-order-subtotal-kes>0</span>
    </div>

    <!-- Payment Methods -->
    <div class="mb-8 border rounded-lg p-6 bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Select Payment Method</h3>
        
        <div class="space-y-4">
            <!-- Stripe Option (USD) -->
            <div class="flex items-center p-4 border rounded-lg bg-white hover:border-pink-300 transition cursor-pointer payment-option" data-method="stripe">
                <input type="radio" name="payment_method" id="payment_stripe" value="stripe" class="h-5 w-5 text-pink-600 focus:ring-pink-500" checked>
                <label for="payment_stripe" class="ml-3 flex items-center cursor-pointer">
                    <svg class="h-8 w-auto mr-2" viewBox="0 0 40 20">
                        <path fill="#6772E5" d="M35 0H5C2.2 0 0 2.2 0 5v10c0 2.8 2.2 5 5 5h30c2.8 0 5-2.2 5-5V5c0-2.8-2.2-5-5-5z"/>
                        <path fill="#FFF" d="M15.5 8.2v2.6c0 .7.5 1.2 1.2 1.2h1.2c.7 0 1.2-.5 1.2-1.2V8.2h1.8v2.6c0 1.7-1.3 3-3 3h-1.2c-1.7 0-3-1.3-3-3V8.2h1.8zM24 8.2v6h-1.8v-6H24zM27.3 14.2v-6H29v6h-1.7z"/>
                    </svg>
                    <span class="font-medium">Pay with Card (Stripe) - USD</span>
                </label>
            </div>

            <!-- MPESA Option (KES) -->
            <div class="flex items-center p-4 border rounded-lg bg-white hover:border-green-300 transition cursor-pointer payment-option" data-method="mpesa">
                <input type="radio" name="payment_method" id="payment_mpesa" value="mpesa" class="h-5 w-5 text-green-600 focus:ring-green-500">
                <label for="payment_mpesa" class="ml-3 flex items-center cursor-pointer">
                    <div class="h-8 w-8 mr-2 bg-green-600 rounded flex items-center justify-center text-white font-bold text-xs">
                        MPESA
                    </div>
                    <span class="font-medium">M-PESA (Mobile Money) - KES</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Payment Method Sections -->
    <div id="stripe-section" class="mb-4">
        <button id="stripe-pay-button" class="w-full bg-pink-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-pink-700 transition transform hover:scale-[1.02]">
            Pay with Card (Stripe) - USD $<span data-stripe-amount>0.00</span>
        </button>
    </div>

    <!-- MPESA Section -->
    <div id="mpesa-section" class="mb-8 p-6 border border-green-200 rounded-lg bg-green-50 hidden">
        <h3 class="text-lg font-semibold text-green-800 mb-4">M-PESA Payment Details</h3>
        
        <form id="mpesa-payment-form" method="POST">
            @csrf
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    M-PESA Phone Number
                </label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                       placeholder="254712345678"
                       pattern="254[0-9]{9}"
                       title="Please enter a valid Safaricom number starting with 254"
                       required>
                <p class="mt-2 text-sm text-gray-500">
                    Enter your M-PESA registered phone number (Format: 254712345678)
                </p>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Amount to Pay (KES)
                </label>
                <div class="text-3xl font-bold text-green-600" id="mpesa-amount-display">
                    KES 0
                </div>
                <input type="hidden" name="amount" id="mpesa-amount-input" value="">
                <input type="hidden" name="usd_amount" id="usd-amount-input" value="">
            </div>

            <button type="submit" 
                    id="mpesa-submit-btn"
                    class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition transform hover:scale-[1.02] flex items-center justify-center space-x-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <span>Pay with M-PESA</span>
            </button>
        </form>
        
        <p class="mt-4 text-xs text-gray-500 text-center">
            You will receive an STK push prompt on your phone. Enter your PIN to complete payment.
        </p>
    </div>
</div>

<!-- Exchange Rate -->
<script>
    window.exchangeRate = {{ env('USD_TO_KES_RATE', 130) }};
</script>

<!-- Main Checkout Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stripeSection = document.getElementById('stripe-section');
    const mpesaSection = document.getElementById('mpesa-section');
    const stripeRadio = document.getElementById('payment_stripe');
    const mpesaRadio = document.getElementById('payment_mpesa');
    const stripeButton = document.getElementById('stripe-pay-button');
    const mpesaForm = document.getElementById('mpesa-payment-form');
    const mpesaAmountDisplay = document.getElementById('mpesa-amount-display');
    const mpesaAmountInput = document.getElementById('mpesa-amount-input');
    const usdAmountInput = document.getElementById('usd-amount-input');
    
    // Function to get subtotal
    function getSubtotal() {
        const subtotalElement = document.querySelector('[data-order-subtotal]');
        if (subtotalElement) {
            const subtotalText = subtotalElement.textContent;
            const match = subtotalText.match(/[\d.]+/);
            return match ? parseFloat(match[0]) : 0;
        }
        return 0;
    }

    // Convert USD to KES
    function usdToKes(usdAmount) {
        return Math.round(usdAmount * window.exchangeRate);
    }

    // Update amounts
    function updateAmounts() {
        const usdAmount = getSubtotal();
        const kesAmount = usdToKes(usdAmount);
        
        // Update Stripe amount
        const stripeAmountSpan = document.querySelector('[data-stripe-amount]');
        if (stripeAmountSpan) {
            stripeAmountSpan.textContent = usdAmount.toFixed(2);
        }
        
        // Update MPESA amounts
        if (mpesaAmountDisplay) {
            mpesaAmountDisplay.textContent = 'KES ' + kesAmount.toLocaleString();
        }
        if (mpesaAmountInput) {
            mpesaAmountInput.value = kesAmount;
        }
        if (usdAmountInput) {
            usdAmountInput.value = usdAmount;
        }
        
        // Update KES hidden element
        const kesElement = document.querySelector('[data-order-subtotal-kes]');
        if (kesElement) {
            kesElement.textContent = kesAmount;
        }
    }

    // Toggle payment method sections
    function togglePaymentMethod() {
        if (stripeRadio.checked) {
            stripeSection.classList.remove('hidden');
            mpesaSection.classList.add('hidden');
        } else {
            stripeSection.classList.add('hidden');
            mpesaSection.classList.remove('hidden');
            updateAmounts(); // Update amounts when switching to MPESA
        }
    }
    
    // Event listeners for radio buttons
    stripeRadio.addEventListener('change', togglePaymentMethod);
    mpesaRadio.addEventListener('change', togglePaymentMethod);
    
    // Initial toggle
    togglePaymentMethod();
    updateAmounts();

    // Stripe payment handler
    stripeButton.addEventListener('click', async function() {
        const button = this;
        const originalText = button.textContent;
        
        try {
            // Get cart from localStorage
            const cart = JSON.parse(localStorage.getItem('flower_cart_v1') || '[]');
            
            if (cart.length === 0) {
                alert('Your cart is empty');
                return;
            }
            
            // Disable button
            button.disabled = true;
            button.textContent = 'Processing...';
            button.classList.add('opacity-50', 'cursor-not-allowed');
            
            // Send to server
            const response = await fetch('{{ route("customer.stripe.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    cart: cart,
                    payment_method: 'stripe'
                })
            });
            
            const data = await response.json();
            
            if (response.ok && data.url) {
                window.location.href = data.url;
            } else {
                throw new Error(data.message || 'Error processing payment');
            }
        } catch (error) {
            console.error('Stripe error:', error);
            alert('Error: ' + error.message);
            button.disabled = false;
            button.textContent = originalText;
            button.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    });

    // MPESA form handler
    mpesaForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const cart = JSON.parse(localStorage.getItem('flower_cart_v1') || '[]');
        
        if (cart.length === 0) {
            alert('Your cart is empty');
            return;
        }
        
        const phone = document.getElementById('phone').value;
        if (!phone || !phone.match(/254[0-9]{9}/)) {
            alert('Please enter a valid phone number (Format: 254712345678)');
            return;
        }
        
        const submitBtn = document.getElementById('mpesa-submit-btn');
        const originalBtnText = submitBtn.innerHTML;
        
        try {
            // Disable button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span>Processing...</span>';
            
            // Prepare form data
            const formData = new FormData(this);
            formData.append('cart_data', JSON.stringify(cart));
            
            // Send MPESA request
            const response = await fetch('{{ route("customer.mpesa.stk-push") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                // Show success message
                alert('STK Push sent! Please check your phone and enter your PIN to complete payment.');
                
                // You might want to redirect to a waiting page or show a status
              
            } else {
                throw new Error(data.message || 'Error processing MPESA payment');
            }
        } catch (error) {
            console.error('MPESA error:', error);
            alert('Error: ' + error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });

    
    
    // Listen for cart updates
    function observeCartChanges() {
        const subtotalElement = document.querySelector('[data-order-subtotal]');
        if (subtotalElement) {
            const observer = new MutationObserver(updateAmounts);
            observer.observe(subtotalElement, { 
                childList: true, 
                characterData: true, 
                subtree: true 
            });
        }
        
        document.addEventListener('cartUpdated', updateAmounts);
        setInterval(updateAmounts, 2000); // Fallback
    }
    
    observeCartChanges();
});
</script>

<!-- Include your existing scripts -->
<script src="/js/store.js"></script>
<script src="/js/order/order.js"></script>