<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
     public function index()
    {
        $products = Product::latest()->get();
        return view('product.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'number' => 'nullable|string',
            'url' => 'nullable|url',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['name', 'number', 'url', 'description', 'status']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->back()->with('success', 'Product created successfully.');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'number' => 'nullable|string',
            'url' => 'nullable|url',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['name', 'number', 'url', 'description', 'status']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    public function delete(Product $id)
    {
        // Check if the product has an image and delete it from storage
        if ($id->image && Storage::disk('public')->exists($id->image)) {
            Storage::disk('public')->delete($id->image);
        }
        $id->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
