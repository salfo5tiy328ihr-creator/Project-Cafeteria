<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPreferenceController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $preference = $user;
        return view('customer_preferences.edit', compact('preference'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'spicy_level'          => 'nullable|in:Low,Medium,High',
            'dietary_preferences'  => 'nullable|string|max:255',
            'preferred_taste'      => 'nullable|string|max:255',
            'price_preference'     => 'nullable|numeric|min:0',
            'favorite_categories'  => 'nullable|string',
            'favorite_ingredients' => 'nullable|string',
            'disliked_ingredients' => 'nullable|string',

            // ✅ حقول جديدة
            'favorite_food_types'  => 'nullable|string',
            'favorite_beverages'   => 'nullable|string',
        ]);

        $user->update([
            'spicy_level'          => $request->spicy_level,
            'dietary_preferences'  => $request->dietary_preferences,
            'preferred_taste'      => $request->preferred_taste,
            'price_preference'     => $request->price_preference,
            'favorite_categories'  => $request->favorite_categories,
            'favorite_ingredients' => $request->favorite_ingredients,
            'disliked_ingredients' => $request->disliked_ingredients,

            // ✅ حفظ الحقول الجديدة
            'favorite_food_types'  => $request->favorite_food_types,
            'favorite_beverages'   => $request->favorite_beverages,
        ]);

        return back()->with('success', 'Preferences saved successfully!');
    }
}