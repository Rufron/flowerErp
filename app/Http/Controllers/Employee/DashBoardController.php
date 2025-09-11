<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $employeeId = Auth::guard('employees')->id();

        // count for pending orders.
        $pendingOrdersCount = Order::where('status', 'pending')->count();


        // Stats for the dashboard
        $totalProducts = Product::where('employee_id', $employeeId)->count();
        $totalStock = Product::where('employee_id', $employeeId)->sum('stock'); // optional extra stat
        $latestProducts = Product::where('employee_id', $employeeId)
            ->latest()
            ->take(5)
            ->get(); // optional recent products

        // Count how many products are low stock (< 8)
        $lowStockCount = Product::where('employee_id', $employeeId)
            ->where('stock', '<', 8)
            ->count();

        return view('employees.dashboard.index', compact('totalProducts', 'totalStock', 'latestProducts', 'lowStockCount', 'pendingOrdersCount'));
    }
}
