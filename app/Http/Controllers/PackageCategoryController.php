<?php

namespace App\Http\Controllers;

use App\Models\PackageCategory;
use Illuminate\Http\Request;

class PackageCategoryController extends Controller
{
    public function index(Request $r)
    {
        
         $q = PackageCategory::query();
    if ($r->filled('q'))      $q->where('name','like','%'.$r->q.'%');
    if ($r->filled('status')) $q->where('status',$r->status);
    $categories = $q->latest()->paginate(12);

        return view('packagecategory.index', compact('categories'));
    }

    public function create()
    {
        return view('packagecategory.form');
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:255',
         'status' => 'required|in:active,inactive',
        ]);

       PackageCategory::create($request->all());

        return redirect()->route('package-categories.index')->with('success', 'Package category created successfully.');
    }

    public function edit($id)
    {
        $category = PackageCategory::findOrFail($id);
        return view('packagecategory.edit', compact('category'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $category = PackageCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('package-categories.index')->with('success', 'Package category updated successfully.');
    }


    public function destroy($id)
    {
        $category = PackageCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('package-categories.index')->with('success', 'Package category deleted successfully.');
    }   
    

}
