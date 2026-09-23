<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FoodItem;
use App\Models\Beverage;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function adminIndex()
    {
        return view('chat.admin');
    }

    public function customerIndex()
    {
        return view('chat.customer');
    }

    public function send(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);
        $user = Auth::user();
        $message = strtolower(trim($request->message));
        $response = $user->role === 'admin'
            ? $this->handleAdmin($message)
            : $this->handleCustomer($user, $message);

        return response()->json(['reply' => $response]);
    }

    // ==================== Natural Language Search ====================
    public function naturalSearch(Request $request)
    {
        $query = trim($request->input('query', ''));

        if (empty($query)) {
            return view('customer.smart_search', ['results' => null, 'query' => '']);
        }

        $lowerQuery = strtolower($query);

        $allItems = Product::all()
            ->concat(FoodItem::all())
            ->concat(Beverage::all());

        $maxPrice = null;
        if (preg_match('/(under|less than|below|تحت|اقل من)\s*(\d+)/i', $lowerQuery, $m)) {
            $maxPrice = (int)$m[2];
        } elseif (preg_match('/^\s*(\d+)\s*$/', $lowerQuery, $m)) {
            $maxPrice = (int)$m[1];
        }

        $isSpicy = str_contains($lowerQuery, 'spicy') || str_contains($lowerQuery, 'hot');
        $isCold = str_contains($lowerQuery, 'cold') || str_contains($lowerQuery, 'iced') || str_contains($lowerQuery, 'ice');
        $isHealthy = str_contains($lowerQuery, 'healthy') || str_contains($lowerQuery, 'light');
        $isCheap = str_contains($lowerQuery, 'cheap') || str_contains($lowerQuery, 'budget');
        $isDessert = str_contains($lowerQuery, 'dessert') || str_contains($lowerQuery, 'sweet') || str_contains($lowerQuery, 'cake');
        $isDrink = str_contains($lowerQuery, 'drink') || str_contains($lowerQuery, 'beverage') || str_contains($lowerQuery, 'juice');

        $hasFilter = $maxPrice !== null || $isSpicy || $isCold || $isHealthy || $isCheap || $isDessert || $isDrink;

        $keywords = array_filter(explode(' ', $lowerQuery), function ($word) {
            return strlen($word) > 2 && !in_array($word, ['under', 'less', 'than', 'below', 'the', 'and', 'for', 'with', 'i', 'want', 'me', 'show']);
        });

        $results = $allItems->filter(function ($item) use ($maxPrice, $isSpicy, $isCold, $isHealthy, $isCheap, $isDessert, $isDrink, $keywords, $hasFilter) {
            $itemName = strtolower($item->name ?? '');

            if ($maxPrice !== null && $item->price > $maxPrice) return false;
            if ($isSpicy && strtolower($item->spicy_level ?? '') !== 'high') return false;
            if ($isHealthy && ($item->calories ?? 9999) > 400) return false;
            if ($isCheap && $item->price > 100) return false;
            if ($isDessert && stripos($itemName, 'cake') === false && stripos($itemName, 'dessert') === false) return false;
            if ($isDrink && stripos($itemName, 'juice') === false && stripos($itemName, 'coffee') === false && stripos($itemName, 'tea') === false && stripos($itemName, 'cola') === false && stripos($itemName, 'drink') === false && stripos($itemName, 'monster') === false) return false;
            if ($isCold && stripos($itemName, 'cold') === false && stripos($itemName, 'ice') === false && stripos($itemName, 'juice') === false && stripos($itemName, 'cola') === false && stripos($itemName, 'monster') === false) return false;

            if (!empty($keywords)) {
                foreach ($keywords as $kw) {
                    if (stripos($itemName, $kw) !== false) return true;
                }
                if (!$hasFilter) return false;
            }

            if (!$hasFilter && empty($keywords)) return false;

            return true;
        });

        return view('customer.smart_search', compact('results', 'query'));
    }

    private function handleCustomer($user, $message)
    {
        if (preg_match('/\b(hi|hello|hey|مرحبا|اهلا|سلام)\b/u', $message)) {
            return "Hello {$user->name}! 👋 I'm your AI assistant. Ask me things like: 'recommend something spicy', 'what's under 100 EGP?', or 'suggest a cold drink'.";
        }

        if (preg_match('/(under|less than|below|تحت|اقل من)\s*(\d+)/u', $message, $m)) {
            $budget = (int)$m[2];
            $items = Product::where('price', '<=', $budget)->take(3)->get()
                ->merge(FoodItem::where('price', '<=', $budget)->take(3)->get())
                ->merge(Beverage::where('price', '<=', $budget)->take(3)->get())
                ->unique('name')->take(5);

            if ($items->isEmpty()) return "Sorry, nothing found under {$budget} EGP.";

            $list = $items->map(fn($i) => "• {$i->name} — {$i->price} EGP")->implode("\n");
            return "Here are items under {$budget} EGP:\n{$list}";
        }

        if (preg_match('/(spicy|hot|حار|سبايسي)/u', $message)) {
            $items = Product::where('spicy_level', 'High')->take(3)->get()
                ->merge(FoodItem::where('spicy_level', 'High')->take(3)->get())
                ->unique('name')->take(5);
            if ($items->isEmpty()) return "Sorry, no spicy items available right now.";
            $list = $items->map(fn($i) => "• {$i->name} — {$i->price} EGP")->implode("\n");
            return "🌶️ Spicy recommendations:\n{$list}";
        }

        if (preg_match('/(drink|beverage|juice|مشروب|عصير)/u', $message)) {
            $items = Beverage::take(5)->get();
            if ($items->isEmpty()) return "Sorry, no drinks available right now.";
            $list = $items->map(fn($i) => "• {$i->name} — {$i->price} EGP")->implode("\n");
            return "🥤 Popular drinks:\n{$list}";
        }

        if (preg_match('/(dessert|sweet|حلو|تحلية)/u', $message)) {
            $items = Product::where('name', 'like', '%cake%')->orWhere('name', 'like', '%dessert%')->take(5)->get();
            if ($items->isEmpty()) return "Sorry, no desserts available right now.";
            $list = $items->map(fn($i) => "• {$i->name} — {$i->price} EGP")->implode("\n");
            return "🍰 Desserts:\n{$list}";
        }

        // ✅ جديد: Compare / VS
        if (preg_match('/(compare|difference|vs)/i', $message)) {
            return "To compare two items, please use the Compare page from the sidebar. It shows Price, Calories, Spicy Level, and Match % side by side.";
        }

        // ✅ جديد: Healthy
        if (preg_match('/(healthy|healthiest|light)/i', $message)) {
            $healthy = Product::where('calories', '<', 400)->orWhereNull('calories')->take(5)->get();
            if ($healthy->isEmpty()) return "Sorry, no healthy items available right now.";
            $list = $healthy->map(fn($i) => "• {$i->name} — " . ($i->calories ?? 'N/A') . " Cal")->implode("\n");
            return "🥗 Healthy Recommendations:\n{$list}";
        }

        // ✅ جديد: Ingredients (مُحدّث)
        if (preg_match('/(what.*in|ingredient|contain)/i', $message)) {
            return "You can find the ingredients of any item on its product card in the Menu page. Just look under the item name.";
        }

        if (preg_match('/(recommend|suggest|what.*eat|what.*order|رشح|اقترح)/u', $message)) {
            $items = Product::take(3)->get()
                ->merge(FoodItem::take(3)->get())
                ->merge(Beverage::take(2)->get())
                ->unique('name')->take(5);
            $list = $items->map(fn($i) => "• {$i->name} — {$i->price} EGP")->implode("\n");
            return "Based on our menu, I recommend:\n{$list}";
        }

        return "I'm not sure how to answer that. Try asking:\n• 'Recommend something spicy'\n• 'What's under 100 EGP?'\n• 'Suggest a cold drink'\n• 'Show me desserts'\n• 'Compare Cola vs Juice'\n• 'I want something healthy'\n• 'What's in the burger?'";
    }

    private function handleAdmin($message)
    {
        // Total Orders
        if (preg_match('/(how many|total|عدد).*(order|طلب)/u', $message)) {
            $count = Order::count();
            $today = Order::whereDate('created_at', today())->count();
            return "📦 Total Orders: {$count}\n📅 Today's Orders: {$today}";
        }

        // Total Customers
        if (preg_match('/(how many|total|عدد).*(customer|user|عميل|مستخدم)/u', $message)) {
            $count = User::where('role', 'customer')->count();
            return "👥 Total Registered Customers: {$count}";
        }

        // Sales
        if (preg_match('/(sales|revenue|مبيعات|ايراد)/u', $message)) {
            $today = Order::whereDate('created_at', today())->where('status', '!=', 'cancelled')->sum('total_price');
            $total = Order::where('status', '!=', 'cancelled')->sum('total_price');
            return "💰 Today's Sales: " . number_format($today, 2) . " EGP\n💵 Total Sales: " . number_format($total, 2) . " EGP";
        }

        // Category with Most Items (must be BEFORE Top Selling)
        if (preg_match('/(categor).*(most|popular|top|has)/u', $message) || preg_match('/(most|which).*(categor)/u', $message)) {
            $topCat = \App\Models\Category::withCount('products')->orderByDesc('products_count')->first();
            return "📂 Category with most items: " . ($topCat->name ?? 'N/A') . " ({$topCat->products_count} items)";
        }

        // ✅ جديد: Popular Beverages (قبل Top Selling العام)
        if (preg_match('/(popular|best|top).*(drink|beverage)/i', $message)) {
            $top = Beverage::take(5)->get();
            if ($top->isEmpty()) return "No beverages yet.";
            $list = $top->map(fn($b) => "• {$b->name} — {$b->price} EGP")->implode("\n");
            return "🥤 Popular Beverages:\n{$list}";
        }

        // ✅ جديد: Most Ordered Food (قبل Top Selling العام)
        if (preg_match('/(most|top).*(ordered|popular).*(food|meal|dish)/i', $message)) {
            $top = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select('products.name', DB::raw('SUM(order_items.quantity) as total'))
                ->groupBy('products.name')
                ->orderByDesc('total')
                ->take(3)
                ->get();
            if ($top->isEmpty()) return "No food orders yet.";
            $list = $top->map(fn($t) => "• {$t->name} — {$t->total} sold")->implode("\n");
            return "🍽️ Most Ordered Food:\n{$list}";
        }

        // Top Selling
        if (preg_match('/(top|most|best|popular|الأكثر|الأفضل)/u', $message)) {
            $top = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select('products.name', DB::raw('SUM(order_items.quantity) as total'))
                ->groupBy('products.name')
                ->orderByDesc('total')
                ->take(5)
                ->get();
            if ($top->isEmpty()) return "No sales data yet.";
            $list = $top->map(fn($t) => "• {$t->name} — {$t->total} sold")->implode("\n");
            return "🔥 Top Selling Items:\n{$list}";
        }

        // Low Stock
        if (preg_match('/(low|stock|متاح|مخزون)/u', $message)) {
            $low = Product::where('quantity', '<', 10)->take(5)->get();
            if ($low->isEmpty()) return "✅ All products have enough stock.";
            $list = $low->map(fn($p) => "• {$p->name} — {$p->quantity} left")->implode("\n");
            return "⚠️ Low Stock Items:\n{$list}";
        }

        // Pending Orders
        if (preg_match('/(pending|waiting|معلق)/u', $message)) {
            $count = Order::where('status', 'pending')->count();
            return "⏳ Pending Orders: {$count}";
        }

        // Total Categories
        if (preg_match('/(how many|total|عدد).*(categor|تصنيف)/u', $message)) {
            $count = \App\Models\Category::count();
            return "📂 Total Categories: {$count}";
        }

        // Total Menu Items
        if (preg_match('/(how many|total|عدد).*(product|food|item|منتج)/u', $message)) {
            $count = Product::count() + FoodItem::count() + Beverage::count();
            return "🍽️ Total Menu Items: {$count}";
        }

        // Most Popular Meals
        if (preg_match('/(popular|best|top).*(meal|food|dish)/u', $message)) {
            $top = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select('products.name', DB::raw('SUM(order_items.quantity) as total'))
                ->groupBy('products.name')
                ->orderByDesc('total')
                ->take(3)
                ->get();
            if ($top->isEmpty()) return "No popular meals yet.";
            $list = $top->map(fn($t) => "• {$t->name} — {$t->total} sold")->implode("\n");
            return "🔥 Most Popular Meals:\n{$list}";
        }

        // Never Ordered Items
        if (preg_match('/(never|not).*(ordered)/u', $message)) {
            $orderedIds = DB::table('order_items')->pluck('product_id')->unique()->toArray();
            $neverOrdered = Product::whereNotIn('id', $orderedIds)->take(5)->get();
            if ($neverOrdered->isEmpty()) return "✅ All products have been ordered at least once.";
            $list = $neverOrdered->map(fn($p) => "• {$p->name}")->implode("\n");
            return "🆕 Items never ordered:\n{$list}";
        }

        // Greeting
        if (preg_match('/\b(hi|hello|hey)\b/u', $message)) {
            return "Hello Admin! 👋 I can help you with:\n• Total orders & sales\n• Top selling items\n• Low stock alerts\n• Customer count\n• Pending orders\n• Category with most items\n• Most popular meals\n• Never ordered items\n• Popular beverages\n• Most ordered food";
        }

        return "I can answer questions like:\n• 'How many orders today?'\n• 'What's the total sales?'\n• 'Show me top selling items'\n• 'Which products have low stock?'\n• 'How many customers do we have?'\n• 'Which category has the most items?'\n• 'Show me the most popular meals'\n• 'Which food items have never been ordered?'\n• 'What are the most popular drinks?'\n• 'Show me the most ordered food'";
    }
}