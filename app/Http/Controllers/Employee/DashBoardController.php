<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $employeeId = Auth::guard('employee')->id();

        // Stats for the dashboard
        $totalProducts = Product::where('employee_id', $employeeId)->count();
        $totalStock = Product::where('employee_id', $employeeId)->sum('stock'); // optional extra stat
        $latestProducts = Product::where('employee_id', $employeeId)
                                ->latest()
                                ->take(5)
                                ->get(); // optional recent products

        return view('employees.dashboard.index', compact('totalProducts', 'totalStock', 'latestProducts'));
    }
}
