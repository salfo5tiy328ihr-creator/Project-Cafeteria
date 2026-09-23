@extends('layouts.customer')

@section('title', 'Smart Search')

@section('content')
    <div style="margin-bottom: 25px;">
        <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-search-plus" style="color: #6366f1;"></i> Smart AI Search
        </h2>
        <p style="color: #6b7280; margin-top: 5px;">Search using natural language. Example: "spicy food under 150 EGP"</p>
    </div>

    <div class="card" style="margin-bottom: 25px;">
        <div class="card-body">
            <form action="{{ route('smart.search') }}" method="GET">
                <div style="display: flex; gap: 10px;">
                    <input type="text" name="query" value="{{ $query ?? '' }}" placeholder='Try: "spicy food under 150 EGP"' style="flex: 1; padding: 14px 18px; border: 2px solid #e5e7eb; border-radius: 12px; font-family: 'Cairo'; outline: none;">
                    <button type="submit" class="btn-submit" style="width: auto; padding: 14px 25px; margin: 0;">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($results))
        <h4 style="margin-bottom: 15px; font-weight: 700;">{{ $results->count() }} results for "{{ $query }}"</h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            @forelse($results as $item)
                <div class="card">
                    @if($item->image)
                        <img src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" style="width: 100%; height: 180px; object-fit: cover;">
                    @endif
                    <div class="card-body" style="padding: 20px;">
                        <h4 style="font-weight: 700;">{{ $item->name }}</h4>
                        <p style="color: #6b7280; font-size: 0.9rem; margin: 10px 0;">{{ $item->description ?? 'No description.' }}</p>
                        <div style="font-weight: 700; color: #6366f1; font-size: 1.2rem; margin-bottom: 15px;">{{ $item->price }} EGP</div>
                        <form action="{{ route('cart.add', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-submit" style="padding: 10px; font-size: 0.9rem;">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="card" style="grid-column: 1 / -1;">
                    <div class="card-body" style="text-align: center; padding: 40px;">
                        <i class="fas fa-search fa-3x" style="color: #d1d5db; margin-bottom: 15px;"></i>
                        <h4 style="color: #6b7280;">No results found. Try different keywords.</h4>
                    </div>
                </div>
            @endforelse
        </div>
    @endif
@endsection