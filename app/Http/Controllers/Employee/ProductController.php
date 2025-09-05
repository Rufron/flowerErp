<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        // Fetch only products created by the logged-in employee
        $products = Product::where('employee_id', Auth::guard('employee')->id())
            ->latest()
            ->paginate(5);


        return view('employees.products.index', compact('products'));
    }


    public function create()
    {
        return view('employees.products.create'); // your blade view
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'stock'       => $request->stock,
            'image'       => $imagePath,
            'employee_id' => Auth::guard('employee')->id(), // link product to logged-in employee
        ]);

        return redirect()->route('employees.products.index')
            ->with('success', 'Product created successfully!');
    }


    public function edit($id)
    {
        $product = Product::where('employee_id', Auth::guard('employee')->id())
            ->findOrFail($id);

        return view('employees.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('employee_id', Auth::guard('employee')->id())
            ->findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'stock'       => $request->stock,
            'image'       => $product->image,
        ]);

        return redirect()->route('employees.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::where('employee_id', Auth::guard('employee')->id())
            ->findOrFail($id);

        // Delete image from storage if it exists
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('employees.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
