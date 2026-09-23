<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FoodItem;
use App\Models\Beverage;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $products = Product::all();
        $foodItems = FoodItem::all();
        $beverages = Beverage::all();

        $allItems = $products->concat($foodItems)->concat($beverages);

        $previousOrders = $this->getPreviousOrdersSignal($user);

        $recommendations = $allItems->map(function ($item) use ($user, $previousOrders) {
            $item->match_percentage = $this->calculateMatch($user, $item);

            if (in_array($item->id, $previousOrders)) {
                $item->match_percentage = min(100, $item->match_percentage + 10);
                $item->is_frequent = true;
            } else {
                $item->is_frequent = false;
            }

            $item->explanation = $this->getExplanation($user, $item);

            return $item;
        });

        if ($request->filled('max_price')) {
            $recommendations = $recommendations->filter(function ($item) use ($request) {
                return $item->price <= $request->max_price;
            });
        }

        if ($request->filled('healthy')) {
            $recommendations = $recommendations->filter(function ($item) {
                return ($item->calories ?? 9999) < 400;
            })->sortBy('calories');
        }

        if ($request->filled('surprise')) {
            $recommendations = $recommendations->shuffle()->take(3);
        } elseif ($request->filled('combo')) {
            $topFood = $recommendations->sortByDesc('match_percentage')->first();

            $topDrink = $beverages->map(function ($item) use ($user, $previousOrders) {
                $item->match_percentage = $this->calculateMatch($user, $item);

                if (in_array($item->id, $previousOrders)) {
                    $item->match_percentage = min(100, $item->match_percentage + 10);
                    $item->is_frequent = true;
                } else {
                    $item->is_frequent = false;
                }

                $item->explanation = $this->getExplanation($user, $item);

                return $item;
            })->sortByDesc('match_percentage')->first();

            $recommendations = collect([$topFood, $topDrink])->filter();
        } else {
            $recommendations = $recommendations->sortByDesc('match_percentage');
        }

        return view('customer.recommendations', compact('recommendations'));
    }

    private function getPreviousOrdersSignal($user)
    {
        return \App\Models\OrderItem::whereHas('order', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->select('product_id', \DB::raw('COUNT(*) as count'))
            ->groupBy('product_id')
            ->orderByDesc('count')
            ->take(3)
            ->pluck('product_id')
            ->toArray();
    }

    private function getExplanation($user, $item)
    {
        $reasons = [];

        if ($user->spicy_level && $item->spicy_level && $user->spicy_level == $item->spicy_level) {
            $reasons[] = "matches your {$user->spicy_level} spicy preference";
        }
        if ($user->price_preference && $item->price <= $user->price_preference) {
            $reasons[] = "fits your budget ({$item->price} EGP)";
        }
        if ($user->preferred_taste && stripos($item->name, $user->preferred_taste) !== false) {
            $reasons[] = "matches your {$user->preferred_taste} taste";
        }
        if (empty($reasons)) {
            $reasons[] = "popular choice in our menu";
        }

        return "Recommended because it " . implode(' and ', $reasons) . ".";
    }

    private function calculateMatch($user, $item)
    {
        $score = 0;
        $maxScore = 0;

        // 1. Spicy Level Match (30 points)
        $maxScore += 30;
        if ($user->spicy_level && $item->spicy_level) {
            if ($user->spicy_level == $item->spicy_level) {
                $score += 30;
            } elseif (
                ($user->spicy_level == 'Medium' && in_array($item->spicy_level, ['Low', 'High'])) ||
                ($item->spicy_level == 'Medium' && in_array($user->spicy_level, ['Low', 'High']))
            ) {
                $score += 15;
            }
        }

        // 2. Price Match (30 points)
        $maxScore += 30;
        if ($user->price_preference && $item->price) {
            if ($item->price <= $user->price_preference) {
                $score += 30;
            } elseif ($item->price <= $user->price_preference * 1.2) {
                $score += 15;
            }
        }

        // 3. Taste Match (20 points)
        $maxScore += 20;
        if ($user->preferred_taste) {
            $taste = strtolower($user->preferred_taste);
            $itemName = strtolower($item->name ?? '');
            $itemDesc = strtolower($item->description ?? '');

            if (str_contains($itemName, $taste) || str_contains($itemDesc, $taste)) {
                $score += 20;
            }
        }

        // 4. Dietary Match (20 points)
        $maxScore += 20;
        if ($user->dietary_preferences) {
            $diet = strtolower($user->dietary_preferences);
            if ($diet == 'none' || $diet == '') {
                $score += 20;
            } else {
                $itemName = strtolower($item->name ?? '');
                $itemDesc = strtolower($item->description ?? '');
                if (str_contains($itemName, $diet) || str_contains($itemDesc, $diet)) {
                    $score += 20;
                }
            }
        } else {
            $score += 10;
        }

        if ($maxScore == 0) {
            return 50;
        }

        $percentage = ($score / $maxScore) * 100;

        // Boost score a bit if price fits perfectly
        if ($user->price_preference && $item->price && $item->price <= $user->price_preference) {
            $percentage = min(100, $percentage + 5);
        }

        // 5. Favorite Ingredients (Bonus)
        if ($user->favorite_ingredients) {
            $favIng = array_map('trim', explode(',', strtolower($user->favorite_ingredients)));
            $itemIng = strtolower($item->ingredients ?? '');
            foreach ($favIng as $ing) {
                if ($ing && str_contains($itemIng, $ing)) {
                    $percentage = min(100, $percentage + 5);
                    break;
                }
            }
        }

        // 6. Disliked Ingredients (Penalty)
        if ($user->disliked_ingredients) {
            $disIng = array_map('trim', explode(',', strtolower($user->disliked_ingredients)));
            $itemIng = strtolower($item->ingredients ?? '');
            foreach ($disIng as $ing) {
                if ($ing && str_contains($itemIng, $ing)) {
                    $percentage = max(0, $percentage - 20);
                    break;
                }
            }
        }

        return round($percentage);
    }
}