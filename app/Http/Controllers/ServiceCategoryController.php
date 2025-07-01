<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    
    public function index()
    {
        $categories = ServiceCategory::latest()->paginate(10);
        return view('servicecategory.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('service-category/icons', 'public');
        }

        $data['slug'] = Str::slug($request->name);
        ServiceCategory::create($data);

        return redirect()->route('service-category.index')->with('success', 'Service Category added successfully.');
    }

    public function update(Request $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);
        $data = $this->validateData($request);

        if ($request->hasFile('icon')) {
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
            $data['icon'] = $request->file('icon')->store('service-category/icons', 'public');
        }

        $data['slug'] = Str::slug($request->name);
        $category->update($data);

        return redirect()->route('service-category.index')->with('success', 'Service Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = ServiceCategory::findOrFail($id);

        if ($category->icon) {
            Storage::disk('public')->delete($category->icon);
        }

        $category->delete();
        return redirect()->back()->with('success', 'Service Category deleted successfully.');
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable',
            'status' => 'required|in:active,inactive,draft',
        ]);
    }
}
