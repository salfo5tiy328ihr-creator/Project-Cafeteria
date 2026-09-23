@extends('layouts.customer')

@section('title', 'My Favorites')

@section('content')
    <div style="margin-bottom: 25px;">
        <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-heart" style="color: #ef4444;"></i> My Favorites
        </h2>
        <p style="color: #6b7280; margin-top: 5px;">Your favorite food and beverages in one place.</p>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
        @forelse($favorites as $favorite)
            @if($favorite->item)
                <div class="card">
                    @if($favorite->item->image)
                        <img src="{{ str_starts_with($favorite->item->image, 'http') ? $favorite->item->image : asset('storage/' . $favorite->item->image) }}" alt="{{ $favorite->item->name }}" style="width: 100%; height: 180px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 180px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                            <i class="fas fa-image fa-3x"></i>
                        </div>
                    @endif

                    <div class="card-body" style="padding: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px;">
                            <h4 style="font-weight: 700; color: #1f2937; margin: 0; flex: 1;">{{ $favorite->item->name }}</h4>
                            <i class="fas fa-heart" style="color: #ef4444; font-size: 1.1rem;"></i>
                        </div>
                        <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 15px; height: 40px; overflow: hidden;">
                            {{ $favorite->item->description ?? 'No description available.' }}
                        </p>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <span style="font-weight: 700; color: #6366f1; font-size: 1.2rem;">{{ $favorite->item->price }} EGP</span>
                            <span style="font-size: 0.85rem; color: #6b7280;">
                                <i class="fas fa-fire"></i> {{ $favorite->item->calories ?? 'N/A' }} Cal
                            </span>
                        </div>
                        
                        <div style="display: flex; gap: 8px;">
                            <form action="{{ route('cart.add', $favorite->item->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn-submit" style="padding: 10px; font-size: 0.9rem; width: 100%;">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                            <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 10px 15px; border-radius: 12px; cursor: pointer; font-weight: 600; height: 100%;" title="Remove from Favorites">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="card" style="grid-column: 1 / -1;">
                <div class="card-body" style="text-align: center; padding: 50px;">
                    <i class="fas fa-heart-broken fa-4x" style="color: #d1d5db; margin-bottom: 20px;"></i>
                    <h4 style="color: #6b7280; font-weight: 600;">Your favorites list is empty.</h4>
                    <p style="color: #9ca3af; margin-bottom: 20px;">Start adding your favorite items from the menu.</p>
                    <a href="{{ route('menu') }}" class="btn-submit" style="width: auto; padding: 12px 30px; display: inline-flex; text-decoration: none;">
                        <i class="fas fa-utensils"></i> Browse Menu
                    </a>
                </div>
            </div>
        @endforelse
    </div>
@endsection