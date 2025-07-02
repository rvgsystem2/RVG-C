<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->latest()->get();
        $categories = BlogCategory::where('status', 'active')->get();
        return view('blog.index', compact('blogs', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required|unique:blogs,slug',
            'category_id' => 'required',
        ]);

        $blog = new Blog();
        $this->saveData($blog, $request);

        return redirect()->back()->with('success', 'Blog created successfully.');
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string',
            'slug' => 'required|unique:blogs,slug,' . $blog->id,
            'category_id' => 'required',
        ]);

        $this->saveData($blog, $request);

        return redirect()->back()->with('success', 'Blog updated successfully.');
    }

    public function delete($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->back()->with('success', 'Blog deleted successfully.');
    }

    private function saveData($blog, $request)
    {
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->slug);
        $blog->category_id = $request->category_id;
        $blog->author = $request->author;
        $blog->sort_content = $request->sort_content;
        $blog->content = $request->content;
        $blog->thumbnail_img_alt = $request->thumbnail_img_alt;
        $blog->image_alt = $request->image_alt;

        if ($request->hasFile('thumbnail_img')) {
            $blog->thumbnail_img = $request->thumbnail_img->store('blog/thumbnail', 'public');
        }

        if ($request->hasFile('image')) {
            $blog->image = $request->image->store('blog/main', 'public');
        }

        $blog->save();
    }
}
