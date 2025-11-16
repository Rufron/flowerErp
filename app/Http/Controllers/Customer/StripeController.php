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

        
//         $orderId = 123; 
//         $amount = 5000; 

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
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Get the real order
        $orderId = $request->input('order_id') ?? $request->query('order_id');
        $order = Order::with('items')->findOrFail($orderId);

        // Stripe requires amount in cents
        $amountInCents = intval($order->subtotal * 100);

        // Create line items based on actual order items
        $lineItems = [];
        foreach ($order->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => intval($item->price * 100),
                ],
                'quantity' => $item->qty,
            ];
        }

        // Create checkout session
        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('customer.payment.success') . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $orderId,
            'cancel_url' => route('customer.payment.cancel'),
            'metadata' => [
                'order_id' => $orderId,
            ],
        ]);

        return redirect($checkoutSession->url);
    }

    public function success(Request $request)
    {
        $orderId = $request->query('order_id');

        // Mark order as paid
        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->status = 'paid';
                $order->save();
            }
        }

        return view('customer.payment.success');
    }

    public function cancel()
    {
        return view('customer.payment.cancel');
    }
}