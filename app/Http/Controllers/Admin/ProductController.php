<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function dashboard()
    {
        // Fetch all products with employee details
        $products = Product::with('employee')->latest()->paginate(3);

        // displaying orders made today.
        $totalOrdersToday = Order::whereDate('created_at', Carbon::today())->count();

        // total revenue today
        $totalRevenueToday = Order::whereDate('created_at', Carbon::today())->sum('subtotal');

        // count users with at least one order
        $totalCustomers = User::whereHas('orders')->count();


        // 2.For the orders overview section, fetch the 5 most recent orders along with the associated user details.
        $orders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        // displaying recent sign ups.
        $recentSignups = User::latest()->take(3)->get();


        // Top 5 buyers by total spent
        $topBuyers = User::select('users.id', 'users.name', DB::raw('SUM(orders.subtotal) as total_spent'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_spent')
            ->take(3)
            ->get();


        ////////////////////////////////////////////////////////////////////////////////////
        // this section is for charts and graphs
        ////////////////////////////////////////////////////////////////////////////////////

        // Start of week (Monday)
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Get total revenue grouped by day
        $salesData = DB::table('orders')
            ->selectRaw('DATE(created_at) as date, SUM(subtotal) as total')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // Create labels for Mon–Sun
        $labels = [];
        $totals = [];
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        foreach ($days as $i => $day) {
            $date = $startOfWeek->copy()->addDays($i)->toDateString();
            $labels[] = $day;
            $totals[] = $salesData[$date] ?? 0; // Use 0 if no sales that day
        }

        $chartLabels = $labels;
        $chartData   = $totals;

        ///////////////////////////////////////////////////////
        // end section for charts and graphs
        ///////////////////////////////////////////////////////



        return view('admin.dashboard.index', compact('products', 'totalOrdersToday', 'totalRevenueToday', 'totalCustomers', 'orders', 'recentSignups', 'topBuyers', 'chartLabels', 'chartData'));
    }
}
