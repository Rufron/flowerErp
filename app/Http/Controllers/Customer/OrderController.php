<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id()) // fetch only logged-in user’s orders
            ->latest()
            ->get();

        return view('customer.diso', compact('orders'));
    }
}
