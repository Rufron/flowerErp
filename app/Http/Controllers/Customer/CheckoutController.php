<?php

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
    public function index()
    {
        // The checkout page is mostly client-driven (reads cart from localStorage),
        // but you could pre-fill shipping/payment info here.
        return view('customer.checkout');
    }

    public function placeOrder(Request $request)
    {
        // Basic validation of request payload
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

                // if product exists, check/decrement stock
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

            return response()->json(['success' => true, 'order_id' => $order->id], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

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
