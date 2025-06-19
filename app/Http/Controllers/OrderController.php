<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    // Display all orders with supplier info
    public function index()
    {
        $orders = Order::with('supplier')->get();
        return view('orders.index', compact('orders'));
    }

    // Show form to create a new order
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('orders.create', compact('suppliers', 'products'));
    }

    // Store a new order and its order items (with stock validation)
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'quantities' => 'required|array',
        ]);

        $quantities = array_filter($request->input('quantities'), fn($q) => $q > 0);
        if (empty($quantities)) {
            return back()->withErrors(['quantities' => 'Please enter quantity for at least one product'])->withInput();
        }

        // Validate stock availability
        foreach ($quantities as $productId => $qty) {
            $product = Product::findOrFail($productId);
            if ($qty > $product->stock_quantity) {
                throw ValidationException::withMessages([
                    "quantities.$productId" => "Cannot order more than available stock for {$product->name}.",
                ]);
            }
        }

        DB::transaction(function () use ($request, $quantities) {
            $order = Order::create([
                'supplier_id' => $request->supplier_id,
                'status' => 'pending',
                'total_amount' => 0,
            ]);

            $totalAmount = 0;

            foreach ($quantities as $productId => $qty) {
                $product = Product::findOrFail($productId);
                $price = $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $price,
                ]);

                $totalAmount += $price * $qty;
            }

            $order->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
    }

    // Show details of a specific order
    public function show(Order $order)
    {
        $order->load('supplier', 'orderItems.product');
        return view('orders.show', compact('order'));
    }

    // Show form to edit an existing order
    public function edit(Order $order)
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $order->load('orderItems');
        return view('orders.edit', compact('order', 'suppliers', 'products'));
    }

    // Update an existing order, with stock validation and stock adjustment
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:pending,completed,cancelled',
            'quantities' => 'required|array',
        ]);

        $quantities = array_filter($request->input('quantities'), fn($q) => $q > 0);
        if (empty($quantities)) {
            return back()->withErrors(['quantities' => 'Please enter quantity for at least one product'])->withInput();
        }

        // Validate stock availability (considering stock if status is completed)
        foreach ($quantities as $productId => $qty) {
            $product = Product::findOrFail($productId);

            // If order is changing to completed or already completed,
            // consider that the previous order items have reserved stock
            // so calculate stock + previous quantity in order.
            $previousQty = $order->orderItems()->where('product_id', $productId)->value('quantity') ?? 0;
            $availableStock = $product->stock_quantity;

            // If order status is completed, stock was already reduced before
            // so add previousQty back temporarily to available stock check
            if ($order->status === 'completed') {
                $availableStock += $previousQty;
            }

            if ($qty > $availableStock) {
                throw ValidationException::withMessages([
                    "quantities.$productId" => "Cannot order more than available stock for {$product->name}.",
                ]);
            }
        }

        DB::transaction(function () use ($request, $order, $quantities) {
            $previousStatus = $order->status;

            // If previously completed, revert stock first (undo deduction)
            if ($previousStatus === 'completed') {
                foreach ($order->orderItems as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->stock_quantity += $item->quantity;
                        $product->save();
                    }
                }
            }

            // Update order basic info
            $order->update([
                'supplier_id' => $request->supplier_id,
                'status' => $request->status,
            ]);

            // Delete old order items
            $order->orderItems()->delete();

            $totalAmount = 0;

            // Create new order items
            foreach ($quantities as $productId => $qty) {
                $product = Product::findOrFail($productId);
                $price = $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $price,
                ]);

                $totalAmount += $price * $qty;
            }

            $order->update(['total_amount' => $totalAmount]);

            // Deduct stock if new status is completed
            if ($request->status === 'completed') {
                foreach ($order->orderItems as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->stock_quantity -= $item->quantity;
                        if ($product->stock_quantity < 0) {
                            $product->stock_quantity = 0; // prevent negative stock
                        }
                        $product->save();
                    }
                }
            }
        });

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    // Delete an order and its items
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

    // Mark order as completed and restock products
    public function restock(Order $order)
    {
        if ($order->status === 'completed') {
            return redirect()->back()->with('warning', 'This order is already completed.');
        }

        DB::transaction(function () use ($order) {
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock_quantity += $item->quantity;
                    $product->save();
                }
            }

            $order->update(['status' => 'completed']);
        });

        return redirect()->route('orders.show', $order->id)->with('success', 'Order completed and stock updated.');
    }
}