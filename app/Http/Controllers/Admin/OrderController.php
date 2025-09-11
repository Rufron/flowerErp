<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function update(Order $order, $status)
    {
        $allowed = ['pending', 'processing', 'completed', 'cancelled'];

        if (! in_array($status, $allowed)) {
            return back()->with('error', 'Invalid status update.');
        }

        $order->update(['status' => $status]);

        return back()->with('success', "Order #{$order->id} updated to {$status}.");
    }
}
