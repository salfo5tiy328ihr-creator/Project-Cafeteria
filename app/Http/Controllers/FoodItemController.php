<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodItemController extends Controller
{
    public function index(Request $request)
    {
        $query = FoodItem::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $foodItems = $query->latest()->get();

        return view('food_items.index', compact('foodItems'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('food_items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'calories'    => 'nullable|integer|min:0',
            'ingredients' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only([
            'category_id', 'name', 'description', 'price',
            'calories', 'ingredients',
        ]);

        $data['is_spicy']     = $request->has('is_spicy') ? 1 : 0;
        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('food_items', 'public');
        }

        FoodItem::create($data);

        return redirect()->route('food_items.index')
            ->with('success', '✅ Food item added successfully');
    }

    public function edit(FoodItem $foodItem)
    {
        $categories = Category::all();
        return view('food_items.edit', compact('foodItem', 'categories'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'calories'    => 'nullable|integer|min:0',
            'ingredients' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only([
            'category_id', 'name', 'description', 'price',
            'calories', 'ingredients',
        ]);

        $data['is_spicy']     = $request->has('is_spicy') ? 1 : 0;
        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($foodItem->image) {
                Storage::disk('public')->delete($foodItem->image);
            }
            $data['image'] = $request->file('image')->store('food_items', 'public');
        }

        $foodItem->update($data);

        return redirect()->route('food_items.index')
            ->with('success', '✅ Food item updated successfully');
    }

    public function destroy(FoodItem $foodItem)
    {
        if ($foodItem->image) {
            Storage::disk('public')->delete($foodItem->image);
        }

        $foodItem->delete();

        return redirect()->route('food_items.index')
            ->with('success', '🗑️ Food item deleted successfully');
    }
}