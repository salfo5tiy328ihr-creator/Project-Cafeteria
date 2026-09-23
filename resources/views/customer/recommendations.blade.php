@extends('layouts.customer')

@section('title', 'Recommended for You')

@section('content')
    <div style="margin-bottom: 25px;">
        <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-magic" style="color: #6366f1;"></i> Recommended for You
        </h2>
        <p style="color: #6b7280; margin-top: 5px;">Based on your preferences, here are our top picks for you.</p>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="card" style="margin-bottom: 25px;">
        <div class="card-body" style="padding: 20px;">
            <form action="{{ route('customer.recommendations') }}" method="GET">
                <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                    <input type="number" name="max_price" placeholder="Max price (EGP)" value="{{ request('max_price') }}" style="padding: 10px 15px; border: 2px solid #e5e7eb; border-radius: 10px; font-family: 'Cairo'; outline: none; width: 200px;">
                    <button type="submit" class="btn-submit" style="padding: 10px 20px; width: auto;">Refresh</button>
                    <button type="submit" name="combo" value="1" class="btn-submit" style="padding: 10px 20px; width: auto; background: linear-gradient(135deg, #8b5cf6, #6d28d9);">Suggest Combo</button>
                    <button type="submit" name="surprise" value="1" class="btn-submit" style="padding: 10px 20px; width: auto; background: linear-gradient(135deg, #ec4899, #be185d);">Surprise Me</button>
                    <button type="submit" name="healthy" value="1" class="btn-submit" style="padding: 10px 20px; width: auto; background: linear-gradient(135deg, #10b981, #047857);">Healthy</button>
                </div>
            </form>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
        @forelse($recommendations as $product)
            <div class="card">
                @if($product->image)
                    <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 180px; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 180px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                        <i class="fas fa-image fa-3x"></i>
                    </div>
                @endif
                <div class="card-body" style="padding: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <h4 style="font-weight: 700; color: #1f2937; margin-bottom: 5px;">
                            {{ $product->name }}
                            @if($product->is_frequent ?? false)
                                <span style="background: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 12px; font-size: 0.7rem; font-weight: 700; margin-left: 5px;">⭐ You ordered this</span>
                            @endif
                        </h4>
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; white-space: nowrap;">
                            {{ round($product->match_percentage ?? 0) }}% Match
                        </span>
                    </div>

                    <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 10px; height: 40px; overflow: hidden;">
                        {{ $product->description ?? 'No description available.' }}
                    </p>

                    <p style="color: #6366f1; font-size: 0.85rem; font-style: italic; margin-bottom: 12px; background: #eef2ff; padding: 8px 12px; border-radius: 8px;">
                        <i class="fas fa-lightbulb"></i> {{ $product->explanation ?? '' }}
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
                            <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 10px 15px; border-radius: 12px; cursor: pointer; font-weight: 600; height: 100%;" title="Add to Favorites">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="card" style="grid-column: 1 / -1;">
                <div class="card-body" style="text-align: center; padding: 50px;">
                    <i class="fas fa-robot fa-4x" style="color: #c7d2fe; margin-bottom: 20px;"></i>
                    <h4 style="color: #6b7280;">No recommendations available yet.</h4>
                    <p style="color: #9ca3af;">Go to your preferences and set your food preferences to get personalized recommendations.</p>
                    <a href="{{ route('customer.preferences.edit') }}" class="btn-submit" style="width: auto; padding: 12px 30px; display: inline-flex; text-decoration: none; margin-top: 15px;">
                        <i class="fas fa-user-cog"></i> Set Preferences
                    </a>
                </div>
            </div>
        @endforelse
    </div>
@endsection