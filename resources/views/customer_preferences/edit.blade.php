@extends('layouts.customer')

@section('title', 'My Preferences')

@section('content')
    <div style="margin-bottom: 25px;">
        <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-sliders-h" style="color: #6366f1;"></i> Preference Settings
        </h2>
        <p style="color: #6b7280; margin-top: 5px;">Help the AI know you better by setting your food preferences.</p>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-danger" style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            <ul style="list-style:none; margin:0; padding:0;">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-robot"></i> Let AI Know You Better
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('customer.preferences.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Spicy Level</label>
                        <select name="spicy_level">
                            <option value="">Choose...</option>
                            <option value="Low"    {{ old('spicy_level', $preference->spicy_level ?? '') == 'Low'    ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ old('spicy_level', $preference->spicy_level ?? '') == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High"   {{ old('spicy_level', $preference->spicy_level ?? '') == 'High'   ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Food Preferences (Dietary)</label>
                        <input type="text" name="dietary_preferences" value="{{ old('dietary_preferences', $preference->dietary_preferences ?? '') }}" placeholder="Vegetarian, Keto, None">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Preferred Taste</label>
                        <input type="text" name="preferred_taste" value="{{ old('preferred_taste', $preference->preferred_taste ?? '') }}" placeholder="Sweet, Salty, Sour">
                    </div>
                    <div class="form-group">
                        <label>Maximum Budget (Price Preference)</label>
                        <input type="number" name="price_preference" value="{{ old('price_preference', $preference->price_preference ?? '') }}" placeholder="Example: 150">
                    </div>
                </div>

                {{-- ✅ الحقول الإضافية --}}
                <div class="form-row">
                    <div class="form-group">
                        <label>Favorite Categories</label>
                        <input type="text" name="favorite_categories" value="{{ old('favorite_categories', $preference->favorite_categories ?? '') }}" placeholder="Pizza, Burgers, Coffee">
                    </div>
                    <div class="form-group">
                        <label>Favorite Ingredients</label>
                        <input type="text" name="favorite_ingredients" value="{{ old('favorite_ingredients', $preference->favorite_ingredients ?? '') }}" placeholder="Chicken, Cheese, Tomato">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label>Disliked Ingredients</label>
                        <input type="text" name="disliked_ingredients" value="{{ old('disliked_ingredients', $preference->disliked_ingredients ?? '') }}" placeholder="Onion, Garlic, Mushroom">
                    </div>
                </div>

                {{-- ✅ حقول جديدة: Favorite Food Types + Favorite Beverages --}}
                <div class="form-row">
                    <div class="form-group">
                        <label>Favorite Food Types</label>
                        <input type="text" name="favorite_food_types" value="{{ old('favorite_food_types', $preference->favorite_food_types ?? '') }}" placeholder="Pizza, Burgers, Pasta">
                    </div>
                    <div class="form-group">
                        <label>Favorite Beverages</label>
                        <input type="text" name="favorite_beverages" value="{{ old('favorite_beverages', $preference->favorite_beverages ?? '') }}" placeholder="Coffee, Juice, Tea">
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Preferences
                </button>
            </form>
        </div>
    </div>
@endsection