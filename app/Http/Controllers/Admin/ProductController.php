<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function dashboard()
    {
        // Fetch all products with employee details
        $products = Product::with('employee')->latest()->paginate(3);

        return view('admin.dashboard.index', compact('products'));
    }
}
