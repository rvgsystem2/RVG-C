<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
     public function index()
    {
        $categories = BlogCategory::latest()->get();
        return view('blogcategory.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:blog_categories,name',
            'slug' => 'required|unique:blog_categories,slug',
            'status' => 'required|in:active,inactive',
        ]);

        BlogCategory::create($request->only(['name', 'slug', 'status']));
        return redirect()->back()->with('success', 'Blog category created successfully.');
    }

    public function update(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:blog_categories,name,' . $category->id,
            'slug' => 'required|unique:blog_categories,slug,' . $category->id,
            'status' => 'required|in:active,inactive',
        ]);

        $category->update($request->only(['name', 'slug', 'status']));
        return redirect()->back()->with('success', 'Blog category updated successfully.');
    }

    public function delete($id)
    {
        BlogCategory::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Blog category deleted successfully.');
    }
}
