<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{

    public function index()
    {
        $banners = Banner::latest()->paginate(10);
        return view('banners.index', compact('banners'));
    }

    public function create()
    {
        return view('banners.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateBanner($request);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request->file('image'));
        }

        Banner::create($data);
        return redirect()->route('banner.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('banners.create', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $this->validateBanner($request);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $this->storeImage($request->file('image'));
        }

        $banner->update($data);
        return redirect()->route('banner.index')->with('success', 'Banner updated successfully.');
    }

    public function delete(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();
        return redirect()->back()->with('success', 'Banner deleted successfully.');
    }

    // 🔧 Private helper methods
    private function validateBanner(Request $request): array
    {
        return $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'img_alt_text' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,draft'
        ]);
    }

    private function storeImage($file): string
    {
        return $file->store('banners', 'public');
    }
}
