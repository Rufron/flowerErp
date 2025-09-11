<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Get all orders with user relationship and items
        $orders = Order::with(['user', 'items.product'])
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);

        return view('employees.orders.index', compact('orders'));
    }
}
