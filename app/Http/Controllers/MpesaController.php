<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class MpesaController extends Controller
{
    protected $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    /**
     * Initiate STK Push
     */
   public function stkPush(Request $request)
{
    Log::info('========== MPESA STK PUSH CONTROLLER ==========');
    Log::info('Request data:', $request->all());
    
    try {
        $request->validate([
            'phone' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'cart_data' => 'required|json' // Add this validation
        ]);

        // Get cart from the request instead of session
        $cart = json_decode($request->cart_data, true);
        
        if (empty($cart)) {
            Log::warning('Cart is empty in request data');
            return redirect()->back()
                ->with('error', 'Your cart is empty')
                ->withInput();
        }

        Log::info('Cart from request:', ['count' => count($cart), 'items' => $cart]);
        
        // Store cart in session for later use
        session()->put('cart', $cart);
        session()->put('mpesa_cart', $cart);

        // Rest of your code...
        $amount = (int) $request->amount;
        $reference = 'ORDER_' . time();
        
        session()->put('mpesa_reference', $reference);
        session()->put('mpesa_amount', $amount);
        session()->put('mpesa_phone', $request->phone);

        $result = $this->mpesaService->stkPush(
            $request->phone,
            $amount,
            $reference,
            'Flower Purchase'
        );

        if ($result['success']) {
            session()->put('mpesa_checkout_request_id', $result['data']['CheckoutRequestID']);
            
            return redirect()->route('customer.mpesa.pending')
                ->with('success', 'STK Push sent. Please check your phone.');
        } else {
            return redirect()->back()
                ->with('error', 'Failed to initiate payment: ' . ($result['message'] ?? 'Unknown error'));
        }
        
    } catch (\Exception $e) {
        Log::error('Exception: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Error: ' . $e->getMessage())
            ->withInput();
    }
}



    /**
     * M-PESA Callback URL
     */

    // public function callback(Request $request)
    // {
    //     // Log EVERYTHING
    //     Log::info('========== MPESA CALLBACK RECEIVED ==========');
    //     Log::info('Full callback data:', $request->all());
    //     Log::info('Raw content: ' . $request->getContent());
        
    //     try {
    //         $callbackData = $request->all();
            
    //         if (isset($callbackData['Body']['stkCallback'])) {
    //             $stkCallback = $callbackData['Body']['stkCallback'];
    //             $checkoutRequestID = $stkCallback['CheckoutRequestID'];
    //             $resultCode = $stkCallback['ResultCode'];
    //             $resultDesc = $stkCallback['ResultDesc'];
                
    //             Log::info('Callback details:', [
    //                 'CheckoutRequestID' => $checkoutRequestID,
    //                 'ResultCode' => $resultCode,
    //                 'ResultDesc' => $resultDesc
    //             ]);
                
    //             // IMPORTANT: The callback comes from M-PESA, not from the user's browser
    //             // So it doesn't have the session cookie!
    //             // We need to find the session by the CheckoutRequestID
                
    //             // Instead of using session(), we need to store payment status
    //             // in a way that can be accessed without the session
                
    //             if ($resultCode == 0) {
    //                 // Payment successful
    //                 $callbackMetadata = $stkCallback['CallbackMetadata']['Item'] ?? [];
                    
    //                 $transactionDetails = [];
    //                 foreach ($callbackMetadata as $item) {
    //                     $transactionDetails[$item['Name']] = $item['Value'] ?? null;
    //                 }
                    
    //                 Log::info('Payment successful!', $transactionDetails);
                    
    //                 // STORE IN DATABASE OR CACHE WITH THE CHECKOUT REQUEST ID
    //                 // Option 1: Use Cache (simpler)
    //                 Cache::put('mpesa_' . $checkoutRequestID, [
    //                     'success' => true,
    //                     'transaction' => $transactionDetails
    //                 ], now()->addMinutes(10));
                    
    //                 // Option 2: You could also create the order here
    //                 // $this->createOrder($checkoutRequestID, $transactionDetails);
                    
    //             } else {
    //                 Log::error('Payment failed:', [
    //                     'code' => $resultCode,
    //                     'desc' => $resultDesc
    //                 ]);
                    
    //                 Cache::put('mpesa_' . $checkoutRequestID, [
    //                     'success' => false,
    //                     'reason' => $resultDesc
    //                 ], now()->addMinutes(10));
    //             }
    //         }
            
    //     } catch (\Exception $e) {
    //         Log::error('Callback exception: ' . $e->getMessage());
    //         Log::error($e->getTraceAsString());
    //     }
        
    //     return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    // }

    public function callback(Request $request)
{
    // Log EVERYTHING
    Log::info('========== MPESA CALLBACK RECEIVED ==========');
    Log::info('Full callback data:', $request->all());
    Log::info('Raw content: ' . $request->getContent());
    
    try {
        $callbackData = $request->all();
        
        if (isset($callbackData['Body']['stkCallback'])) {
            $stkCallback = $callbackData['Body']['stkCallback'];
            $checkoutRequestID = $stkCallback['CheckoutRequestID'];
            $resultCode = $stkCallback['ResultCode'];
            $resultDesc = $stkCallback['ResultDesc'];
            
            Log::info('Callback details:', [
                'CheckoutRequestID' => $checkoutRequestID,
                'ResultCode' => $resultCode,
                'ResultDesc' => $resultDesc
            ]);
            
            // Store the callback data in cache
            Cache::put('mpesa_callback_' . $checkoutRequestID, [
                'result_code' => $resultCode,
                'result_desc' => $resultDesc,
                'timestamp' => now()
            ], now()->addMinutes(30));
            
            // Handle different result codes
            switch ($resultCode) {
                case 0:
                    // Payment successful
                    $this->handleSuccessfulPayment($stkCallback, $checkoutRequestID);
                    break;
                    
                case 1032:
                    // Transaction cancelled by user
                    Log::warning('Transaction cancelled by user: ' . $resultDesc);
                    Cache::put('mpesa_' . $checkoutRequestID, [
                        'success' => false,
                        'reason' => 'Transaction cancelled by user',
                        'result_desc' => $resultDesc
                    ], now()->addMinutes(10));
                    break;
                    
                case 1037:
                    // DS timeout user cannot be reached
                    Log::error('DS timeout - user cannot be reached: ' . $resultDesc);
                    Cache::put('mpesa_' . $checkoutRequestID, [
                        'success' => false,
                        'reason' => 'Payment timeout - please try again',
                        'result_desc' => $resultDesc
                    ], now()->addMinutes(10));
                    break;
                    
                case 1031:
                    // Transaction expired
                    Log::error('Transaction expired: ' . $resultDesc);
                    Cache::put('mpesa_' . $checkoutRequestID, [
                        'success' => false,
                        'reason' => 'Payment expired - please try again',
                        'result_desc' => $resultDesc
                    ], now()->addMinutes(10));
                    break;
                    
                default:
                    // Other errors
                    Log::error('Payment failed with code ' . $resultCode . ': ' . $resultDesc);
                    Cache::put('mpesa_' . $checkoutRequestID, [
                        'success' => false,
                        'reason' => 'Payment failed: ' . $resultDesc,
                        'result_code' => $resultCode,
                        'result_desc' => $resultDesc
                    ], now()->addMinutes(10));
                    break;
            }
        }
        
    } catch (\Exception $e) {
        Log::error('Callback exception: ' . $e->getMessage());
        Log::error($e->getTraceAsString());
    }
    
    // Always return success to M-PESA
    return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
}

  

    /**
     * Payment pending page
     */
    public function pending()
    {
        Log::info('Rendering pending page', [
            'mpesa_reference' => session()->get('mpesa_reference'),
            'mpesa_amount' => session()->get('mpesa_amount'),
            'mpesa_phone' => session()->get('mpesa_phone')
        ]);
        
        return view('customer.mpesa-pending');
    }

    /**
     * Check payment status (for AJAX polling)
     */
   

    // public function status()
    // {
    //     $success = session()->get('mpesa_payment_success', false);
    //     $failed = session()->get('mpesa_payment_failed', false);
        
    //     Log::info('Status check:', [
    //         'success' => $success,
    //         'failed' => $failed,
    //         'session_id' => session()->getId()
    //     ]);
        
    //     if ($success) {
    //         $transaction = session()->get('mpesa_transaction', []);
    //         $amount = session()->get('mpesa_amount', 0);
            
    //         // Store in session for success page
    //         session()->put('payment_method', 'M-PESA');
    //         session()->put('order_total', 'KES ' . number_format($amount));
            
    //         return response()->json([
    //             'status' => 'success',
    //             'transaction' => $transaction,
    //             'message' => 'Payment completed successfully!'
    //         ]);
    //     }
        
    //     if ($failed) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => session()->get('mpesa_failure_reason', 'Payment failed')
    //         ]);
    //     }
        
    //     return response()->json([
    //         'status' => 'pending',
    //         'message' => 'Waiting for payment confirmation...'
    //     ]);
    // }

    public function status()
    {
        $checkoutRequestID = session()->get('mpesa_checkout_request_id');
        
        Log::info('Status check:', [
            'checkoutRequestID' => $checkoutRequestID,
            'session_id' => session()->getId()
        ]);
        
        if (!$checkoutRequestID) {
            return response()->json([
                'status' => 'error',
                'message' => 'No pending payment found'
            ]);
        }
        
        // Check cache for payment result
        $paymentResult = Cache::get('mpesa_' . $checkoutRequestID);
        
        if ($paymentResult) {
            if ($paymentResult['success']) {
                // Clear cache and session
                Cache::forget('mpesa_' . $checkoutRequestID);
                
                // Store in session for success page
                session()->put('payment_method', 'M-PESA');
                session()->put('order_total', 'KES ' . number_format(session()->get('mpesa_amount', 0)));
                session()->put('mpesa_payment_success', true);
                
                return response()->json([
                    'status' => 'success',
                    'transaction' => $paymentResult['transaction']
                ]);
            } else {
                Cache::forget('mpesa_' . $checkoutRequestID);
                
                return response()->json([
                    'status' => 'failed',
                    'message' => $paymentResult['reason'] ?? 'Payment failed'
                ]);
            }
        }
        
        return response()->json([
            'status' => 'pending',
            'message' => 'Waiting for payment confirmation...'
        ]);
    }
    
    /**
     * Create order from cart after successful payment
     */
    private function createOrderFromCart($transactionDetails)
    {
        try {
            $cart = session()->get('mpesa_cart_backup', []);
            
            if (empty($cart)) {
                Log::warning('No cart backup found for order creation');
                return;
            }
            
            // TODO: Create order in database
            // This is where you'd create your order
            
            // Clear the cart
            session()->forget('cart');
            session()->forget('mpesa_cart_backup');
            
            Log::info('Order created successfully');
            
        } catch (\Exception $e) {
            Log::error('Failed to create order: ' . $e->getMessage());
        }
    }
}