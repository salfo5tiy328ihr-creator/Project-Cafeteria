<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items.product');

        if ($request->filled('search')) {
            $query->where('customer_name', 'like', '%' . $request->search . '%');
        }

        $orders = $query->latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'      => 'required|string|max:255',
            'status'             => 'required|in:pending,preparing,completed,cancelled',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $totalPrice = 0;

            $order = Order::create([
                'customer_name' => $request->customer_name,
                'status'        => $request->status,
                'total_price'   => 0,
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $totalPrice += $subtotal;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ]);
            }

            $order->update(['total_price' => $totalPrice]);
        });

        return redirect()->route('orders.index')
            ->with('success', '✅ Order created successfully');
    }

    public function edit(Order $order)
    {
        $products = Product::all();
        $order->load('items.product');
        return view('orders.edit', compact('order', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_name'      => 'required|string|max:255',
            'status'             => 'required|in:pending,preparing,completed,cancelled',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $order) {
            $order->update([
                'customer_name' => $request->customer_name,
                'status'        => $request->status,
            ]);

            $order->items()->delete();

            $totalPrice = 0;

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $totalPrice += $subtotal;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ]);
            }

            $order->update(['total_price' => $totalPrice]);
        });

        return redirect()->route('orders.index')
            ->with('success', '✅ Order updated successfully');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', '🗑️ Order deleted successfully');
    }
}