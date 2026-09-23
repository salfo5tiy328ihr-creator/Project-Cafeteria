<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use App\Models\FoodItem;
use App\Models\Beverage;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // General Stats
        $totalOrders = Order::count();
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total_price');
        $totalCustomers = User::where('role', 'customer')->count();
        $totalProducts = Product::count() + FoodItem::count() + Beverage::count();

        // Today's Stats
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todaySales = Order::whereDate('created_at', today())
                           ->where('status', '!=', 'cancelled')
                           ->sum('total_price');

        // Order Status Breakdown
        $pendingOrders = Order::where('status', 'pending')->count();
        $preparingOrders = Order::where('status', 'preparing')->count();
        $readyOrders = Order::where('status', 'ready')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // Top Selling Products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
                                ->groupBy('product_id')
                                ->orderByDesc('total_sold')
                                ->take(5)
                                ->with('product')
                                ->get();

        // Low Stock Products
        $lowStockProducts = Product::where('quantity', '<', 10)
                                   ->orderBy('quantity', 'asc')
                                   ->take(5)
                                   ->get();

        // Recent Orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('reports.index', compact(
            'totalOrders',
            'totalSales',
            'totalCustomers',
            'totalProducts',
            'todayOrders',
            'todaySales',
            'pendingOrders',
            'preparingOrders',
            'readyOrders',
            'completedOrders',
            'cancelledOrders',
            'topProducts',
            'lowStockProducts',
            'recentOrders'
        ));
    }
}