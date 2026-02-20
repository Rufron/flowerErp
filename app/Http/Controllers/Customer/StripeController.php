<?php

// namespace App\Http\Controllers\Customer;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Stripe\Stripe;
// use Stripe\Checkout\Session;

// class StripeController extends Controller
// {
//     public function checkout(Request $request)
//     {
//         Stripe::setApiKey(env('STRIPE_SECRET'));

//         // Example order data (replace with your real order logic)
//         $orderId = 123; 
//         $amount = 5000; // $50.00 in cents

//         $checkoutSession = Session::create([
//             'payment_method_types' => ['card'],
//             'line_items' => [[
//                 'price_data' => [
//                     'currency' => 'usd',
//                     'product_data' => [
//                         'name' => 'Flower Order #' . $orderId,
//                     ],
//                     'unit_amount' => $amount,
//                 ],
//                 'quantity' => 1,
//             ]],
//             'mode' => 'payment',
//             'success_url' => route('customer.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
//             'cancel_url' => route('customer.payment.cancel'),
//             'metadata' => [
//                 'order_id' => $orderId,
//             ],
//         ]);

//         return redirect($checkoutSession->url);
//     }

//     public function success(Request $request)
//     {
//         return view('customer.payment.success');
//     }

//     public function cancel()
//     {
//         return view('customer.payment.cancel');
//     }
// }



namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class StripeController extends Controller
{
    public function checkout(Request $request)
{
    // Get cart data from request
    $cart = $request->input('cart', []);
    
    // If cart is empty, return error
    if (empty($cart)) {
        return response()->json([
            'success' => false, 
            'message' => 'Your cart is empty'
        ], 400);
    }

    // Calculate subtotal
    $subtotal = 0;
    foreach ($cart as $item) {
        // Make sure item has required fields
        if (!isset($item['price']) || !isset($item['qty'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid cart item format'
            ], 400);
        }
        $subtotal += ($item['price'] * $item['qty']);
    }

    // Create order in pending state
    $order = Order::create([
        'user_id' => Auth::id(),
        'subtotal' => $subtotal,
        'status' => 'pending_payment',
    ]);

    // Create order items
    foreach ($cart as $item) {
        $productId = $item['id'] ?? null;
        
        // Check stock if product exists
        if ($productId) {
            $product = Product::find($productId);
            if ($product && $product->stock < $item['qty']) {
                // Delete the pending order
                $order->delete();
                
                return response()->json([
                    'success' => false, 
                    'message' => "Not enough stock for {$product->name}"
                ], 400);
            }
        }

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $productId,
            'name' => $item['name'],
            'price' => $item['price'],
            'qty' => $item['qty'],
        ]);
    }

    // Set Stripe API key
    Stripe::setApiKey(env('STRIPE_SECRET'));

    try {
        // Create Stripe checkout session
        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Flower Order #' . $order->id,
                    ],
                    'unit_amount' => $subtotal * 100, // Convert to cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('customer.payment.success') . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order->id,
            'cancel_url' => route('customer.payment.cancel') . '?order_id=' . $order->id,
            'metadata' => [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
            ],
        ]);

        // Store Stripe session ID in order
        $order->update([
            'stripe_session_id' => $checkoutSession->id
        ]);

        // Return the Stripe checkout URL
        return response()->json([
            'success' => true, 
            'url' => $checkoutSession->url
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Stripe session creation failed: ' . $e->getMessage());
        
        // Delete the pending order
        $order->delete();
        
        return response()->json([
            'success' => false, 
            'message' => 'Could not create payment session: ' . $e->getMessage()
        ], 500);
    }
}

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $orderId = $request->get('order_id');

        // Retrieve the order
        $order = Order::where('id', $orderId)
                      ->where('user_id', Auth::id())
                      ->first();

        if ($order && $order->status === 'pending_payment') {
            DB::beginTransaction();
            try {
                // Verify payment with Stripe
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $session = Session::retrieve($sessionId);

                if ($session->payment_status === 'paid') {
                    // Update order status
                    $order->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);

                    // Decrement stock for each item
                    foreach ($order->items as $item) {
                        if ($item->product_id) {
                            $product = Product::find($item->product_id);
                            if ($product) {
                                $product->decrement('stock', $item->qty);
                            }
                        }
                    }

                    DB::commit();

                    // Clear cart - this will be handled by JavaScript
                    return view('customer.payment.success', [
                        'order' => $order,
                        'clear_cart' => true
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Stripe payment verification failed: ' . $e->getMessage());
            }
        }

        return view('customer.payment.success', ['order' => $order, 'clear_cart' => $clearCart]);
    }

    public function cancel(Request $request)
    {
        $orderId = $request->get('order_id');
        
        if ($orderId) {
            // Delete the pending order
            Order::where('id', $orderId)
                 ->where('user_id', Auth::id())
                 ->where('status', 'pending_payment')
                 ->delete();
        }

        return view('customer.payment.cancel')->with('message', 'Payment was cancelled.');
    }
}