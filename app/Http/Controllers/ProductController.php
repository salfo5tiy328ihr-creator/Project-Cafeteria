<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->get();

        $totalProducts   = Product::count();
        $inStock         = Product::where('quantity', '>', 0)->count();
        $outOfStock      = Product::where('quantity', '<=', 0)->count();
        $totalStockValue = Product::sum(DB::raw('price * quantity'));

        return view('products.index', compact(
            'products',
            'totalProducts',
            'inStock',
            'outOfStock',
            'totalStockValue'
        ));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'price'            => 'required|numeric|min:0',
            'quantity'         => 'required|integer|min:0',
            'category_id'      => 'nullable|exists:categories,id',
            'description'      => 'nullable|string',
            'calories'         => 'nullable|integer',
            'spicy_level'      => 'nullable|string',
            'preparation_time' => 'nullable|integer',
            'ingredients'      => 'nullable|string',
            'status'           => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'name'             => $request->name,
            'price'            => $request->price,
            'quantity'         => $request->quantity,
            'category_id'      => $request->category_id,
            'description'      => $request->description,
            'calories'         => $request->calories,
            'spicy_level'      => $request->spicy_level,
            'preparation_time' => $request->preparation_time,
            'ingredients'      => $request->ingredients,
            'status'           => $request->status,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', '✅ تم إضافة المنتج بنجاح');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'price'            => 'required|numeric|min:0',
            'quantity'         => 'required|integer|min:0',
            'category_id'      => 'nullable|exists:categories,id',
            'description'      => 'nullable|string',
            'calories'         => 'nullable|integer',
            'spicy_level'      => 'nullable|string',
            'preparation_time' => 'nullable|integer',
            'ingredients'      => 'nullable|string',
            'status'           => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'name'             => $request->name,
            'price'            => $request->price,
            'quantity'         => $request->quantity,
            'category_id'      => $request->category_id,
            'description'      => $request->description,
            'calories'         => $request->calories,
            'spicy_level'      => $request->spicy_level,
            'preparation_time' => $request->preparation_time,
            'ingredients'      => $request->ingredients,
            'status'           => $request->status,
        ];

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', '✅ تم تحديث المنتج بنجاح');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', '🗑️ تم حذف المنتج بنجاح');
    }
}