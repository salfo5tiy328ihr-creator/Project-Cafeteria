<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FoodItem;
use App\Models\Beverage;
use Illuminate\Support\Facades\Auth;

class ComparisonController extends Controller
{
    public function index()
    {
        $products = $this->getAllItems();
        return view('customer.comparison', compact('products'));
    }

    public function compare(Request $request)
    {
        $request->validate([
            'item1' => 'required',
            'item2' => 'required',
        ]);

        $item1 = $this->findItem($request->item1);
        $item2 = $this->findItem($request->item2);

        if (!$item1 || !$item2) {
            return redirect()->back()->with('success', 'Please select two valid items.');
        }

        $user = Auth::user();
        $match1 = $this->calculateMatch($user, $item1);
        $match2 = $this->calculateMatch($user, $item2);

        $products = $this->getAllItems();

        return view('customer.comparison', compact('products', 'item1', 'item2', 'match1', 'match2'));
    }

    private function findItem($value)
    {
        $parts = explode(':', $value);
        if (count($parts) !== 2) return null;

        $type = $parts[0];
        $id = $parts[1];

        switch ($type) {
            case 'product':
                $item = Product::find($id);
                if ($item) {
                    $item->type = 'Product';
                    $item->composite_key = 'product:' . $item->id;
                }
                return $item;
            case 'food':
                $item = FoodItem::find($id);
                if ($item) {
                    $item->type = 'Food';
                    $item->composite_key = 'food:' . $item->id;
                }
                return $item;
            case 'beverage':
                $item = Beverage::find($id);
                if ($item) {
                    $item->type = 'Beverage';
                    $item->composite_key = 'beverage:' . $item->id;
                }
                return $item;
        }
        return null;
    }

    private function getAllItems()
    {
        $products = Product::all()->map(function ($item) {
            $item->composite_key = 'product:' . $item->id;
            $item->type = 'Product';
            return $item;
        });

        $foodItems = FoodItem::all()->map(function ($item) {
            $item->composite_key = 'food:' . $item->id;
            $item->type = 'Food';
            return $item;
        });

        $beverages = Beverage::all()->map(function ($item) {
            $item->composite_key = 'beverage:' . $item->id;
            $item->type = 'Beverage';
            return $item;
        });

        return $products->concat($foodItems)->concat($beverages);
    }

    private function calculateMatch($user, $item)
    {
        $score = 0;
        $maxScore = 0;

        $maxScore += 30;
        if ($user->spicy_level && $item->spicy_level && $user->spicy_level == $item->spicy_level) {
            $score += 30;
        }

        $maxScore += 30;
        if ($user->price_preference && $item->price <= $user->price_preference) {
            $score += 30;
        }

        $maxScore += 20;
        if ($user->preferred_taste && stripos($item->name, $user->preferred_taste) !== false) {
            $score += 20;
        }

        $maxScore += 20;
        if (!$user->dietary_preferences || $user->dietary_preferences == 'None') {
            $score += 20;
        }

        return $maxScore > 0 ? round(($score / $maxScore) * 100) : 50;
    }
}