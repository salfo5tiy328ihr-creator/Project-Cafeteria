<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerPreferenceController extends Controller
{
    public function edit()
    {
        $preference = auth()->user()->customerPreference;

        return view('customer_preferences.edit', compact('preference'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'favorite_food' => 'nullable|string|max:255',
            'favorite_beverage' => 'nullable|string|max:255',
            'dietary_preference' => 'nullable|string|max:255',
        ]);

        auth()->user()->customerPreference()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'favorite_food' => $request->favorite_food,
                'favorite_beverage' => $request->favorite_beverage,
                'likes_spicy' => $request->has('likes_spicy'),
                'dietary_preference' => $request->dietary_preference,
            ]
        );

        return back()->with('success', 'Preferences updated successfully.');
    }
}
