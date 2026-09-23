<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerProfileController extends Controller
{
    // عرض صفحة البروفايل
    public function edit()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    // حفظ التعديلات
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'phone' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:10|max:100',
            'spicy_level' => 'nullable|string',
            'dietary_preferences' => 'nullable|string',
            'preferred_taste' => 'nullable|string',
            'price_preference' => 'nullable|numeric|min:0',
        ]);

        $user->update([
            'phone' => $request->phone,
            'age' => $request->age,
            'spicy_level' => $request->spicy_level,
            'dietary_preferences' => $request->dietary_preferences,
            'preferred_taste' => $request->preferred_taste,
            'price_preference' => $request->price_preference,
        ]);

        return redirect()->back()->with('success', 'تم تحديث بياناتك بنجاح! الـ AI هيرشحلك أكل على مزاجك.');
    }
}