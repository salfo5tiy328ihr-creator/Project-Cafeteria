@extends('layouts.customer')

@section('title', 'Menu')

@section('content')
    <div style="margin-bottom: 25px;">
        <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-utensils" style="color: #6366f1;"></i> Our Menu
        </h2>
        <p style="color: #6b7280; margin-top: 5px;">Choose your favorite items and add them to your cart.</p>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            <ul style="list-style:none; margin:0; padding:0;">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Advanced Filter Form --}}
    <div class="card" style="margin-bottom: 25px;">
        <div class="card-body" style="padding: 20px;">
            <form action="{{ route('menu') }}" method="GET">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; align-items: end;">

                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <label style="font-weight: 600; font-size: 0.85rem; color: #6b7280;">Search</label>
                        <input type="text" name="search" placeholder="Search by name..." value="{{ request('search') }}" style="padding: 10px 15px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: 'Cairo'; outline: none; width: 100%;">
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <label style="font-weight: 600; font-size: 0.85rem; color: #6b7280;">Category</label>
                        <select name="category" style="padding: 10px 15px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: 'Cairo'; outline: none; width: 100%;">
                            <option value="">All</option>
                            @foreach(\App\Models\Category::all() as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <label style="font-weight: 600; font-size: 0.85rem; color: #6b7280;">Max Price</label>
                        <input type="number" name="max_price" placeholder="e.g. 150" value="{{ request('max_price') }}" style="padding: 10px 15px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: 'Cairo'; outline: none; width: 100%;">
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <label style="font-weight: 600; font-size: 0.85rem; color: #6b7280;">Spicy Level</label>
                        <select name="spicy_level" style="padding: 10px 15px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: 'Cairo'; outline: none; width: 100%;">
                            <option value="">All</option>
                            <option value="Low" {{ request('spicy_level') == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ request('spicy_level') == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ request('spicy_level') == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    {{-- ✅ Max Calories --}}
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <label style="font-weight: 600; font-size: 0.85rem; color: #6b7280;">Max Calories</label>
                        <input type="number" name="max_calories" placeholder="e.g. 500" value="{{ request('max_calories') }}" style="padding: 10px 15px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: 'Cairo'; outline: none; width: 100%;">
                    </div>

                    {{-- ✅ Ingredient --}}
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <label style="font-weight: 600; font-size: 0.85rem; color: #6b7280;">Ingredient</label>
                        <input type="text" name="ingredient" placeholder="e.g. cheese" value="{{ request('ingredient') }}" style="padding: 10px 15px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: 'Cairo'; outline: none; width: 100%;">
                    </div>

                    {{-- ✅ Availability --}}
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <label style="font-weight: 600; font-size: 0.85rem; color: #6b7280;">Availability</label>
                        <select name="availability" style="padding: 10px 15px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: 'Cairo'; outline: none; width: 100%;">
                            <option value="">All</option>
                            <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                        </select>
                    </div>

                    <div style="display: flex; gap: 8px;">
                        <button type="submit" class="btn-submit" style="padding: 12px 20px; width: 100%;">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('menu') }}" style="background: #f3f4f6; color: #6b7280; padding: 12px 18px; border-radius: 12px; text-decoration: none; font-weight: 600; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Products Grid --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
        @forelse($products as $product)
            @php
                $avgRating = \App\Models\Review::where('product_id', $product->id)->avg('rating') ?? 0;
                $reviewCount = \App\Models\Review::where('product_id', $product->id)->count();
            @endphp

            <div class="card">
                @if($product->image)
                    <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 180px; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 180px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                        <i class="fas fa-image fa-3x"></i>
                    </div>
                @endif
                <div class="card-body" style="padding: 20px;">
                    <h4 style="font-weight: 700; color: #1f2937; margin-bottom: 5px;">{{ $product->name }}</h4>

                    {{-- ⭐ Average Rating & Reviews --}}
                    <div style="display: flex; align-items: center; gap: 5px; margin-bottom: 10px;">
                        <span style="color: #f59e0b; font-size: 0.9rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= round($avgRating) ? '' : '-o' }}"></i>
                            @endfor
                        </span>
                        <span style="color: #6b7280; font-size: 0.8rem;">({{ number_format($avgRating, 1) }} - {{ $reviewCount }} reviews)</span>
                    </div>

                    <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 15px; height: 40px; overflow: hidden;">
                        {{ $product->description ?? 'No description available.' }}
                    </p>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span style="font-weight: 700; color: #6366f1; font-size: 1.2rem;">{{ $product->price }} EGP</span>
                        <span style="font-size: 0.85rem; color: #6b7280;"><i class="fas fa-fire"></i> {{ $product->calories ?? 'N/A' }} Cal</span>
                    </div>

                    <div style="display: flex; gap: 8px;">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            <button type="submit" class="btn-submit" style="padding: 10px; font-size: 0.95rem; width: 100%;">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                        <form action="{{ route('favorites.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $product->id }}">
                            <input type="hidden" name="item_type" value="product">
                            <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 10px 15px; border-radius: 12px; cursor: pointer; font-weight: 600; height: 100%; transition: 0.3s;" title="Add to Favorites" onmouseover="this.style.background='#ef4444'; this.style.color='white';" onmouseout="this.style.background='#fee2e2'; this.style.color='#dc2626';">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="card" style="grid-column: 1 / -1;">
                <div class="card-body" style="text-align: center; padding: 40px;">
                    <i class="fas fa-box-open fa-3x" style="color: #d1d5db; margin-bottom: 15px;"></i>
                    <h4 style="color: #6b7280;">No products found matching your filters.</h4>
                    <a href="{{ route('menu') }}" style="display: inline-block; margin-top: 15px; padding: 10px 25px; background: #6366f1; color: white; text-decoration: none; border-radius: 10px;">Clear Filters</a>
                </div>
            </div>
        @endforelse
    </div>
@endsection