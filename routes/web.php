<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\BeverageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerPreferenceController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use App\Models\FoodItem;
use App\Models\Beverage;
use App\Models\Category;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('dashboard');
        }
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ==================== Admin Routes ====================
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('food-items')->name('food_items.')->group(function () {
        Route::get('/', [FoodItemController::class, 'index'])->name('index');
        Route::get('/create', [FoodItemController::class, 'create'])->name('create');
        Route::post('/', [FoodItemController::class, 'store'])->name('store');
        Route::get('/{foodItem}/edit', [FoodItemController::class, 'edit'])->name('edit');
        Route::put('/{foodItem}', [FoodItemController::class, 'update'])->name('update');
        Route::delete('/{foodItem}', [FoodItemController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('beverages')->name('beverages.')->group(function () {
        Route::get('/', [BeverageController::class, 'index'])->name('index');
        Route::get('/create', [BeverageController::class, 'create'])->name('create');
        Route::post('/', [BeverageController::class, 'store'])->name('store');
        Route::get('/{beverage}/edit', [BeverageController::class, 'edit'])->name('edit');
        Route::put('/{beverage}', [BeverageController::class, 'update'])->name('update');
        Route::delete('/{beverage}', [BeverageController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');
        Route::put('/{order}/payment', [OrderController::class, 'updatePaymentStatus'])->name('updatePayment');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');

    Route::get('/admin/chat', [ChatController::class, 'adminIndex'])->name('admin.chat');
});

// ==================== Customer Routes ====================
Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return view('customer.home');
    })->name('home');

    Route::get('/menu', function (Illuminate\Http\Request $request) {
        $products = Product::query();
        $foodItems = FoodItem::query();
        $beverages = Beverage::query();

        if ($request->filled('search')) {
            $products->where('name', 'like', '%' . $request->search . '%');
            $foodItems->where('name', 'like', '%' . $request->search . '%');
            $beverages->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $products->where('category_id', $request->category);
            $foodItems->where('category_id', $request->category);
        }

        if ($request->filled('max_price')) {
            $products->where('price', '<=', $request->max_price);
            $foodItems->where('price', '<=', $request->max_price);
            $beverages->where('price', '<=', $request->max_price);
        }

        if ($request->filled('spicy_level')) {
            $products->where('spicy_level', $request->spicy_level);
            $foodItems->where('spicy_level', $request->spicy_level);
        }

        if ($request->filled('max_calories')) {
            $products->where('calories', '<=', $request->max_calories);
            $foodItems->where('calories', '<=', $request->max_calories);
            $beverages->where('calories', '<=', $request->max_calories);
        }

        if ($request->filled('ingredient')) {
            $products->where('ingredients', 'like', '%' . $request->ingredient . '%');
            $foodItems->where('ingredients', 'like', '%' . $request->ingredient . '%');
            $beverages->where('ingredients', 'like', '%' . $request->ingredient . '%');
        }

        if ($request->filled('availability')) {
            $products->where('status', $request->availability);
            $foodItems->where('status', $request->availability);
            $beverages->where('status', $request->availability);
        }

        $allItems = $products->get()->concat($foodItems->get())->concat($beverages->get());

        return view('customer.menu', ['products' => $allItems]);
    })->name('menu');

    Route::get('/recommendations', [RecommendationController::class, 'index'])->name('customer.recommendations');

    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/preferences', [CustomerPreferenceController::class, 'edit'])->name('preferences.edit');
        Route::put('/preferences', [CustomerPreferenceController::class, 'update'])->name('preferences.update');

        Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    });

    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::get('/', [FavoriteController::class, 'index'])->name('index');
        Route::post('/', [FavoriteController::class, 'store'])->name('store');
        Route::delete('/{favorite}', [FavoriteController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::delete('/remove/{item}', [CartController::class, 'remove'])->name('remove');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });

    Route::get('/my-orders', [CartController::class, 'myOrders'])->name('customer.orders.index');
    Route::put('/my-orders/{order}/cancel', [CartController::class, 'cancelOrder'])->name('customer.orders.cancel');

    Route::get('/chat', [ChatController::class, 'customerIndex'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');

    Route::get('/compare', [ComparisonController::class, 'index'])->name('comparison.index');
    Route::post('/compare', [ComparisonController::class, 'compare'])->name('comparison.compare');

    Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/smart-search', [ChatController::class, 'naturalSearch'])->name('smart.search');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});