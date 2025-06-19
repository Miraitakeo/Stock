<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $totalStockValue = $products->sum(function ($product) {
            return $product->price * $product->stock_quantity;
        });

        $totalOrders = Order::count();

        $totalSuppliers = Supplier::count();

        // Low stock alert
        $lowStockProducts = Product::where('stock_quantity', '<', 10)->get();

        // Income by supplier
        $incomeBySupplier = Supplier::with('orders')
            ->get()
            ->map(function ($supplier) {
                return [
                    'supplier' => $supplier->name,
                    'income' => $supplier->orders->sum('total_amount'),
                ];
            });

        // Monthly income
        $monthlyIncome = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw("SUM(total_amount) as total")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('dashboard', compact(
            'totalStockValue',
            'totalOrders',
            'totalSuppliers',
            'lowStockProducts',
            'incomeBySupplier',
            'monthlyIncome'
        ));
    }
}