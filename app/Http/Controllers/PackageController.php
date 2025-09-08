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

public function store(Request $r) {
    $data = $r->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required', // consider numeric/decimal in DB
        'image' => 'nullable|image|max:2048',
        'image_alt' => 'nullable|string|max:255',
        'status' => 'required|in:active,inactive,draft',
    ]);
    if ($r->hasFile('image')) {
        $data['image'] = $r->file('image')->store('packages', 'public');
    }
    Package::create($data);
    return back()->with('success', 'Package created.');
}

public function update(Request $r, $id) {
    $pkg = Package::findOrFail($id);
    $data = $r->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required',
        'image' => 'nullable|image|max:2048',
        'image_alt' => 'nullable|string|max:255',
        'status' => 'required|in:active,inactive,draft',
    ]);
    if ($r->hasFile('image')) {
        $data['image'] = $r->file('image')->store('packages', 'public');
    }
    $pkg->update($data);
    return back()->with('success', 'Package updated.');
}

    public function delete(Package $package)
    {
        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();
        return redirect()->back()->with('success', 'Package deleted successfully.');
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
