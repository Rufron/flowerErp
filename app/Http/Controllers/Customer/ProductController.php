<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Start with query builder
        $query = Product::query();

        // initiating a search query
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('price', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(20);

        // $products = Product::paginate(20);


        return view('customer.index', compact('products'));
    }

    public function show($id)
    {
        // Just get the product WITHOUT loading employee relationship
        $product = Product::findOrFail($id);
        
        // Get related products (excluding current product)
        $relatedProducts = Product::where('id', '!=', $product->id)
                                  ->inRandomOrder()
                                  ->limit(4)
                                  ->get();
        
        return view('customer.product-detail', compact('product', 'relatedProducts'));
    }
}
