<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index() {
    $packages = Package::latest()->paginate(20);
    return view('packages.index', compact('packages'));
}

public function create() {
    return view('packages.form');
}


public function show($package) {
      $package = Package::with([
                'media' => fn($q) => $q->where('status','active')->orderBy('created_at','desc'),
                'faqs'  => fn($q) => $q->where('status','active')->orderBy('created_at','desc'),
            ])
            ->where('status','active')
            ->findOrFail($package);
    return view('packages.show', compact('package'));
}

 public function store(Request $r) {
        $data = $r->validate([
            'label' => 'required|string|max:255',
            'name'  => 'required|string|max:255',
            'short_description' => 'nullable|string|max:300',
            'description' => 'nullable|string',
            'price' => 'required|string|max:50',      // aap string chaahte ho
            'sale_price' => 'nullable|numeric',
            'duration_days' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive,draft',
            'image' => 'nullable|image|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|max:1024',
        ]);

        if ($r->hasFile('image')) {
            $data['image'] = $r->file('image')->store('packages', 'public');
        }
        if ($r->hasFile('thumbnail')) {
            $data['thumbnail'] = $r->file('thumbnail')->store('packages/thumbs', 'public');
        }

        Package::create($data);

        return redirect()->route('package.index')->with('success', 'Package created.');
    }


 public function edit($package) {
    $package = Package::findOrFail($package);
    return view('packages.form', compact('package'));
 }


 public function update(Request $r, Package $package) {
        $data = $r->validate([
            'label' => 'required|string|max:255',
            'name'  => 'required|string|max:255',
            'short_description' => 'nullable|string|max:300',
            'description' => 'nullable|string',
            'price' => 'required|string|max:50',
            'sale_price' => 'nullable|numeric',
            'duration_days' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive,draft',
            'image' => 'nullable|image|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|max:1024',
        ]);

        if ($r->hasFile('image')) {
            if ($package->image) Storage::disk('public')->delete($package->image);
            $data['image'] = $r->file('image')->store('packages', 'public');
        }
        if ($r->hasFile('thumbnail')) {
            if ($package->thumbnail) Storage::disk('public')->delete($package->thumbnail);
            $data['thumbnail'] = $r->file('thumbnail')->store('packages/thumbs', 'public');
        }

        $package->update($data);

        return redirect()->route('package.index')->with('success', 'Package updated.');
    }


    public function destroy(Package $package) {
        if ($package->image) Storage::disk('public')->delete($package->image);
        if ($package->thumbnail) Storage::disk('public')->delete($package->thumbnail);
        $package->delete();
        return back()->with('success', 'Package deleted.');
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,draft',
            'price' => 'nullable|string|max:255',
        ]);
    }
}
