<?php

// namespace App\Http\Controllers\Customer;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
// use App\Models\Order;
// use App\Models\OrderItem;
// use App\Models\Product;

// class CheckoutController extends Controller
// {
//     public function index()
//     {
//         // The checkout page is mostly client-driven (reads cart from localStorage),
//         // but you could pre-fill shipping/payment info here.
//         return view('customer.checkout');
//     }

//     public function placeOrder(Request $request)
//     {
//         // Basic validation of request payload
//         $data = $request->validate([
//             'items' => 'required|array|min:1',
//             'items.*.name' => 'required|string',
//             'items.*.price' => 'required|numeric|min:0',
//             'items.*.qty' => 'required|integer|min:1',
//             'items.*.id' => 'nullable|integer|exists:products,id',
//             'subtotal' => 'required|numeric|min:0',
//         ]);

//         $userId = Auth::id();

//         DB::beginTransaction();
//         try {
//             $order = Order::create([
//                 'user_id' => $userId,
//                 'subtotal' => $data['subtotal'],
//                 'status' => 'placed',
//             ]);

//             foreach ($data['items'] as $it) {
//                 $productId = $it['id'] ?? null;

//                 // if product exists, check/decrement stock
//                 if ($productId) {
//                     $product = Product::lockForUpdate()->find($productId);
//                     if ($product) {
//                         if ($product->stock < $it['qty']) {
//                             DB::rollBack();
//                             return response()->json([
//                                 'success' => false,
//                                 'message' => "Not enough stock for {$product->name}"
//                             ], 422);
//                         }
//                         $product->decrement('stock', $it['qty']);
//                     }
//                 }

//                 OrderItem::create([
//                     'order_id' => $order->id,
//                     'product_id' => $productId,
//                     'name' => $it['name'],
//                     'price' => $it['price'],
//                     'qty' => $it['qty'],
//                 ]);
//             }

//             DB::commit();

//             return response()->json(['success' => true, 'order_id' => $order->id], 201);
//         } catch (\Throwable $e) {
//             DB::rollBack();
//             return response()->json([
//                 'success' => false,
//                 'message' => $e->getMessage()
//             ], 500);
//         }
//     }

//     public function success(Request $request)
//     {
//         // Try to load order server-side if orderId passed and belongs to user
//         $order = null;
//         $orderId = $request->query('orderId');

//         if ($orderId && Auth::check()) {
//             $order = Order::with('items')
//                         ->where('id', $orderId)
//                         ->where('user_id', Auth::id())
//                         ->first();
//         }

//         return view('customer.order-success', compact('order'));
//     }
// }




namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    // ... your existing index() method ...
    
    public function index()
    {
        // Check if cart exists in session, if not try to get from localStorage via JavaScript
        $cart = session()->get('cart', []);
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            continue;
            // $subtotal += ($item['price'] * $item['qty']);
        }
        
        return view('customer.checkout', compact('cart', 'subtotal'));
    }

    /**
     * NEW METHOD: Add product to cart (for "Add to Cart" button)
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        
        // Check stock
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available!');
        }

        // Get current cart from session
        $cart = session()->get('cart', []);

        // Check if product already exists in cart
        if (isset($cart[$product->id])) {
            // Update quantity if product already in cart
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price ?? 25.00,
                'quantity' => $request->quantity,
                'image' => $product->image,
                'stock' => $product->stock,
            ];
        }

        // Save cart to session
        session()->put('cart', $cart);

        // Redirect back with success message
        return back()->with('success', $product->name . ' added to cart successfully!');
    }

    // ... your existing placeOrder() and success() methods ...
    
    public function placeOrder(Request $request)
    {
        // First, check if we have cart items in session
        $cart = session()->get('cart', []);
        
        // If no cart in session, use the request data (for compatibility with your existing JS)
        if (empty($cart) && $request->has('items')) {
            return $this->processOrderFromRequest($request);
        }
        
        // Process order from session cart
        return $this->processOrderFromSession($request);
    }
    
    /**
     * Process order from request (your existing logic)
     */
    private function processOrderFromRequest(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.id' => 'nullable|integer|exists:products,id',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $userId = Auth::id();

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $userId,
                'subtotal' => $data['subtotal'],
                'status' => 'placed',
            ]);

            foreach ($data['items'] as $it) {
                $productId = $it['id'] ?? null;

                if ($productId) {
                    $product = Product::lockForUpdate()->find($productId);
                    if ($product) {
                        if ($product->stock < $it['qty']) {
                            DB::rollBack();
                            return response()->json([
                                'success' => false,
                                'message' => "Not enough stock for {$product->name}"
                            ], 422);
                        }
                        $product->decrement('stock', $it['qty']);
                    }
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'name' => $it['name'],
                    'price' => $it['price'],
                    'qty' => $it['qty'],
                ]);
            }

            DB::commit();
            
            // Clear cart session after successful order
            session()->forget('cart');

            return response()->json(['success' => true, 'order_id' => $order->id], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Process order from session cart
     */
    private function processOrderFromSession(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty!'
            ], 422);
        }

        $userId = Auth::id();
        $subtotal = 0;

        // Calculate subtotal
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $userId,
                'subtotal' => $subtotal,
                'status' => 'placed',
            ]);

            foreach ($cart as $productId => $item) {
                $product = Product::lockForUpdate()->find($productId);
                
                if ($product) {
                    if ($product->stock < $item['quantity']) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => "Not enough stock for {$product->name}"
                        ], 422);
                    }
                    $product->decrement('stock', $item['quantity']);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $item['quantity'],
                ]);
            }

            DB::commit();
            
            // Clear cart session after successful order
            session()->forget('cart');

            return response()->json(['success' => true, 'order_id' => $order->id], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    // ... your existing success() method ...

    public function success(Request $request)
    {
        // Try to load order server-side if orderId passed and belongs to user
        $order = null;
        $orderId = $request->query('orderId');

        if ($orderId && Auth::check()) {
            $order = Order::with('items')
                        ->where('id', $orderId)
                        ->where('user_id', Auth::id())
                        ->first();
        }

        return view('customer.order-success', compact('order'));
    }
}
