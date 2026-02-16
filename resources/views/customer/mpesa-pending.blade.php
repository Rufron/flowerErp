@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-pink-50 to-white py-12">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-xl p-8 text-center">
        <!-- Loading Animation -->
        <div class="mb-8">
            <div class="relative">
                <!-- Spinning flower animation -->
                <svg class="w-24 h-24 mx-auto text-pink-500 animate-spin-slow" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C12 2 9 4 9 7C9 9 12 11 12 11C12 11 15 9 15 7C15 4 12 2 12 2Z"/>
                    <path d="M12 11C12 11 14 13 14 16C14 19 12 21 12 21C12 21 10 19 10 16C10 13 12 11 12 11Z"/>
                    <circle cx="12" cy="9" r="2" fill="white"/>
                </svg>
                
                <!-- Pulse effect -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-32 h-32 border-4 border-pink-200 rounded-full animate-ping opacity-25"></div>
                </div>
            </div>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-800 mb-3">Processing Payment</h2>
        
        <p class="text-gray-600 mb-6">
            Please check your phone and enter your M-PESA PIN to complete the payment.
        </p>
        
        <!-- Payment Details Card -->
        <div class="bg-green-50 rounded-xl p-6 mb-8 border border-green-100">
            <div class="flex justify-between items-center mb-4 pb-4 border-b border-green-200">
                <span class="text-green-700 font-medium">Amount:</span>
                <span class="text-2xl font-bold text-green-600" id="mpesa-amount">KES 0</span>
            </div>
            
            <div class="flex justify-between items-center mb-4">
                <span class="text-green-700 font-medium">Phone:</span>
                <span class="text-lg text-gray-700" id="mpesa-phone"></span>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="text-green-700 font-medium">Reference:</span>
                <span class="text-sm font-mono text-gray-600" id="mpesa-ref"></span>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8">
            <div id="progress-bar" class="bg-green-600 h-2.5 rounded-full transition-all duration-1000" style="width: 30%"></div>
        </div>
        
        <!-- Status Message -->
        <div id="status-message" class="text-sm text-gray-500 mb-6">
            Waiting for payment confirmation...
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4">
            <a href="{{ route('customer.checkout') }}" 
               class="text-gray-500 hover:text-gray-700 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Checkout
            </a>
            
            <button id="check-status-btn" 
                    class="text-pink-600 hover:text-pink-700 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Check Status
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 3s linear infinite;
    }
</style>

<script>
    (function() {
        console.log('🚀 Pending page loaded');
        
        // Get session data from Laravel
        const amount = "{{ session('mpesa_amount', '0') }}";
        const phone = "{{ session('mpesa_phone', '') }}";
        const reference = "{{ session('mpesa_reference', '') }}";
        
        console.log('Session data:', { amount, phone, reference });
        
        // Display payment details
        document.getElementById('mpesa-amount').textContent = 'KES ' + Number(amount).toLocaleString();
        document.getElementById('mpesa-phone').textContent = phone;
        document.getElementById('mpesa-ref').textContent = reference;
        
        let pollCount = 0;
        let maxPolls = 60; // Poll for 60 times (30 seconds if every 500ms)
        
        // Function to check payment status
        function checkPaymentStatus() {
            pollCount++;
            console.log(`🔄 Poll #${pollCount}: Checking payment status...`);
            
            // Update progress bar (30% to 90% over time)
            const progress = Math.min(30 + (pollCount * 1), 90);
            document.getElementById('progress-bar').style.width = progress + '%';
            
            fetch('{{ route("customer.mpesa.status") }}')
                .then(response => response.json())
                .then(data => {
                    console.log('Status response:', data);
                    
                    if (data.status === 'success') {
                        // Payment successful - redirect to order success
                        console.log('✅ Payment successful! Redirecting...');
                        document.getElementById('status-message').innerHTML = 
                            '<span class="text-green-600">✓ Payment successful! Redirecting...</span>';
                        
                        setTimeout(() => {
                            window.location.href = '{{ route("customer.order.success") }}';
                        }, 1500);
                        
                    } else if (data.status === 'failed') {
                        // Payment failed
                        console.log('❌ Payment failed:', data.message);
                        document.getElementById('status-message').innerHTML = 
                            '<span class="text-red-600">✗ Payment failed: ' + (data.message || 'Unknown error') + '</span>';
                        
                        // Stop polling
                        return;
                        
                    } else {
                        // Still pending
                        document.getElementById('status-message').innerHTML = 
                            '<span class="text-gray-600">Waiting for payment confirmation... (Attempt ' + pollCount + ')</span>';
                        
                        // Continue polling if under max attempts
                        if (pollCount < maxPolls) {
                            setTimeout(checkPaymentStatus, 2000); // Check every 2 seconds
                        } else {
                            document.getElementById('status-message').innerHTML = 
                                '<span class="text-orange-600">⚠️ Payment is taking longer than expected. You can check status manually.</span>';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking status:', error);
                    document.getElementById('status-message').innerHTML = 
                        '<span class="text-red-600">✗ Error checking payment status</span>';
                });
        }
        
        // Start checking after 3 seconds
        setTimeout(() => {
            console.log('Starting payment status checks...');
            checkPaymentStatus();
        }, 3000);
        
        // Manual check button
        document.getElementById('check-status-btn').addEventListener('click', function(e) {
            e.preventDefault();
            pollCount = 0; // Reset counter
            checkPaymentStatus();
        });
        
    })();
</script>
@endsection