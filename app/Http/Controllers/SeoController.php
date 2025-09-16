<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Package;
use App\Models\Seo;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
     public function index()
    {
        $seos = Seo::with(['blog', 'serviceDetail'])->latest()->paginate(20);
        return view('seo.index', compact('seos'));
    }


      public function create()
    {
        $blogs = Blog::select('id', 'title')->get();
        $packages = Package::select('id', 'name')->get();
        // $services = ServiceDetail::select('id', 'title')->get();
        $services = ServiceDetail::with('category')->get();


        return view('seo.form', [
            'seo' => null,
            'blogs' => $blogs,
            'services' => $services,
            'packages' => $packages,
        ]);
    }



    // Update SEO
       public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
              'title' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
           
            'canonical_url' => 'nullable|url',
            'robots' => 'nullable|string|max:100',

            // Open Graph
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
           
            'og_type' => 'nullable|string|max:100',
            'og_url' => 'nullable|url',

            // Twitter
            'twitter_card' => 'nullable|string|max:50',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
           
            'twitter_site' => 'nullable|string|max:255',
            'twitter_creator' => 'nullable|string|max:255',

            // Schema
            'schema_type' => 'nullable|string|max:100',
            'structured_data_json' => 'nullable|json',

            // Focus Keyword & Meta Tags
            'focus_keyword' => 'nullable|string|max:255',
            'meta_tags' => 'nullable|string',

            // Breadcrumb / Author / Content Info
            'breadcrumb_title' => 'nullable|string|max:255',
            'content_type' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:100',
            'published_at' => 'nullable|date',
            'updated_at_override' => 'nullable|date',

            // Sitemap
            'priority' => 'nullable|numeric|between:0.1,1.0',
            'changefreq' => 'nullable|in:daily,weekly,monthly,yearly,always,never',

            // Page Info
            'page_type' => 'nullable|string|max:100',
            'locale' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'timezone' => 'nullable|string|max:100',

            'blog_id' => 'nullable|exists:blogs,id',
            'service_id' => 'nullable|exists:service_details,id',
            'package_id' => 'nullable|exists:packages,id',

            // File validation
            'meta_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'og_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'twitter_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $seo = new Seo($validated);

        // Handle image uploads
        if ($request->hasFile('meta_image_file')) {
            $seo->meta_image = $request->file('meta_image_file')->store('seo/meta', 'public');
        }

        if ($request->hasFile('og_image_file')) {
            $seo->og_image = $request->file('og_image_file')->store('seo/og', 'public');
        }

        if ($request->hasFile('twitter_image_file')) {
            $seo->twitter_image = $request->file('twitter_image_file')->store('seo/twitter', 'public');
        }

        $seo->save();

        return redirect()->route('seo.index')->with('success', 'SEO record created successfully.');
    }

    public function edit(Seo $seo)
    {
        $blogs = Blog::select('id', 'title')->get();
        $services = ServiceDetail::with('category')->get();
        $packages = Package::select('id', 'name')->get();

        return view('seo.form', [
            'seo' => $seo,
            'blogs' => $blogs,
            'services' => $services,
            'packages' => $packages,
        ]);
    }

    public function update(Request $request, Seo $seo)
    {
        $validated = $request->validate([
                 'title' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
           
            'canonical_url' => 'nullable|url',
            'robots' => 'nullable|string|max:100',

            // Open Graph
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
           
            'og_type' => 'nullable|string|max:100',
            'og_url' => 'nullable|url',

            // Twitter
            'twitter_card' => 'nullable|string|max:50',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
           
            'twitter_site' => 'nullable|string|max:255',
            'twitter_creator' => 'nullable|string|max:255',

            // Schema
            'schema_type' => 'nullable|string|max:100',
            'structured_data_json' => 'nullable|json',

            // Focus Keyword & Meta Tags
            'focus_keyword' => 'nullable|string|max:255',
            'meta_tags' => 'nullable|string',

            // Breadcrumb / Author / Content Info
            'breadcrumb_title' => 'nullable|string|max:255',
            'content_type' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:100',
            'published_at' => 'nullable|date',
            'updated_at_override' => 'nullable|date',

            // Sitemap
            'priority' => 'nullable|numeric|between:0.1,1.0',
            'changefreq' => 'nullable|in:daily,weekly,monthly,yearly,always,never',

            // Page Info
            'page_type' => 'nullable|string|max:100',
            'locale' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'timezone' => 'nullable|string|max:100',

            'blog_id' => 'nullable|exists:blogs,id',
            'service_id' => 'nullable|exists:service_details,id',
            'package_id' => 'nullable|exists:packages,id',


            // File validation
            'meta_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'og_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'twitter_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $seo->fill($validated);

        // Handle image updates
        if ($request->hasFile('meta_image_file')) {
            if ($seo->meta_image) Storage::disk('public')->delete($seo->meta_image);
            $seo->meta_image = $request->file('meta_image_file')->store('seo/meta', 'public');
        }

        if ($request->hasFile('og_image_file')) {
            if ($seo->og_image) Storage::disk('public')->delete($seo->og_image);
            $seo->og_image = $request->file('og_image_file')->store('seo/og', 'public');
        }

        if ($request->hasFile('twitter_image_file')) {
            if ($seo->twitter_image) Storage::disk('public')->delete($seo->twitter_image);
            $seo->twitter_image = $request->file('twitter_image_file')->store('seo/twitter', 'public');
        }

        $seo->save();

        return redirect()->route('seo.index')->with('success', 'SEO record updated successfully.');
    }

    public function delete(Seo $seo)
    {
        // Delete attached images
        if ($seo->meta_image) Storage::disk('public')->delete($seo->meta_image);
        if ($seo->og_image) Storage::disk('public')->delete($seo->og_image);
        if ($seo->twitter_image) Storage::disk('public')->delete($seo->twitter_image);

        $seo->delete();

        return redirect()->route('seo.index')->with('success', 'SEO record deleted.');
    }
}
