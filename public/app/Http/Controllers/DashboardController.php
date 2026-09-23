<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\FoodItem;
use App\Models\Beverage;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $productsCount = Product::count();
        $categoriesCount = Category::count();
        $foodItemsCount = FoodItem::count();
        $beveragesCount = Beverage::count();
        $ordersCount = Order::count();

        return view('dashboard', compact(
            'productsCount',
            'categoriesCount',
            'foodItemsCount',
            'beveragesCount',
            'ordersCount'
        ));
    }
}