<?php

namespace App\Http\Controllers;

use App\Models\Beverage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeverageController extends Controller
{
    public function index(Request $request)
    {
        $query = Beverage::with('category');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $beverages = $query->latest()->get();
        return view('beverages.index', compact('beverages'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('beverages.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only([
            'category_id', 'name', 'description', 'price', 'calories', 'size',
        ]);

        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('beverages', 'public');
        }

        Beverage::create($data);
        return redirect()->route('beverages.index')->with('success', 'Beverage added successfully');
    }

    public function edit(Beverage $beverage)
    {
        $categories = Category::all();
        return view('beverages.edit', compact('beverage', 'categories'));
    }

    public function update(Request $request, Beverage $beverage)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only([
            'category_id', 'name', 'description', 'price', 'calories', 'size',
        ]);

        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($beverage->image) {
                Storage::disk('public')->delete($beverage->image);
            }
            $data['image'] = $request->file('image')->store('beverages', 'public');
        }

        $beverage->update($data);
        return redirect()->route('beverages.index')->with('success', 'Beverage updated successfully');
    }

    public function destroy(Beverage $beverage)
    {
        if ($beverage->image) {
            Storage::disk('public')->delete($beverage->image);
        }
        $beverage->delete();
        return redirect()->route('beverages.index')->with('success', 'Beverage deleted successfully');
    }
}