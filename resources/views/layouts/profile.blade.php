@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')
    <div style="margin-bottom: 25px;">
        <h2 style="font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-user-cog" style="color: #6366f1;"></i> Preferences Settings
        </h2>
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 style="margin: 0; display: flex; align-items: center; gap: 10px;"><i class="fas fa-sliders-h"></i> Help the AI know you better</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('customer.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Example: 01012345678">
                    </div>
                    <div class="form-group">
                        <label>Age</label>
                        <input type="number" name="age" value="{{ old('age', $user->age) }}" placeholder="Example: 25">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Spicy Level</label>
                        <select name="spicy_level">
                            <option value="">Select...</option>
                            <option value="Low" {{ $user->spicy_level == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ $user->spicy_level == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ $user->spicy_level == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dietary Preferences</label>
                        <input type="text" name="dietary_preferences" value="{{ old('dietary_preferences', $user->dietary_preferences) }}" placeholder="Vegetarian, Keto, None">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Preferred Taste</label>
                        <input type="text" name="preferred_taste" value="{{ old('preferred_taste', $user->preferred_taste) }}" placeholder="Sweet, Salty, Sour">
                    </div>
                    <div class="form-group">
                        <label>Max Price Preference</label>
                        <input type="number" name="price_preference" value="{{ old('price_preference', $user->price_preference) }}" placeholder="Example: 150">
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Preferences
                </button>
            </form>
        </div>
    </div>
@endsection