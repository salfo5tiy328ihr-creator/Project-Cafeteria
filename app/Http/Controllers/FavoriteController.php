<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\FoodItem;
use App\Models\Beverage;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)
                             ->with('item')
                             ->latest()
                             ->get();
        return view('favorites.index', compact('favorites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'item_type' => 'required|string',
        ]);

        $user = Auth::user();

        // Mapping between front-end type and Model class
        $typeMap = [
            'product' => Product::class,
            'food_item' => FoodItem::class,
            'beverage' => Beverage::class,
        ];

        if (!isset($typeMap[$request->item_type])) {
            return redirect()->back()->with('success', 'Invalid item type!');
        }

        $itemType = $typeMap[$request->item_type];

        $exists = Favorite::where('user_id', $user->id)
                          ->where('item_id', $request->item_id)
                          ->where('item_type', $itemType)
                          ->first();

        if ($exists) {
            return redirect()->back()->with('success', 'Item is already in your favorites!');
        }

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $request->item_id,
            'item_type' => $itemType,
        ]);

        return redirect()->back()->with('success', 'Item added to favorites!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $favorite = Favorite::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $favorite->delete();

        return redirect()->back()->with('success', 'Item removed from favorites!');
    }
}