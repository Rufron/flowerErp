<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Example order data (replace with your real order logic)
        $orderId = 123; 
        $amount = 5000; // $50.00 in cents

        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Flower Order #' . $orderId,
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('customer.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('customer.payment.cancel'),
            'metadata' => [
                'order_id' => $orderId,
            ],
        ]);

        return redirect($checkoutSession->url);
    }

    public function success(Request $request)
    {
        return view('customer.payment.success');
    }

    public function cancel()
    {
        return view('customer.payment.cancel');
    }
}