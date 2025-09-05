<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class InventoryController extends Controller
{
    /**
     * Show latest inventory (paginated).
     */
    public function index()
    {
        // Eager load 'employee' to avoid N+1 queries and show who inserted each product
        $products = Product::with('employee')->latest()->paginate(15);

        return view('admin.inventory.index', compact('products'));
    }
}
