<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        $signature = $request->header('Stripe-Signature');
        $payload = $request->getContent();

        try {
            $event = Webhook::constructEvent(
                $payload,
                $signature,
                $endpointSecret
            );
        } catch (SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        // 🎯 Handle events
        if ($event->type === 'checkout.session.completed') {
            // example:
            // $session = $event->data->object;
        }

        return response('Webhook received', 200);
    }
}
