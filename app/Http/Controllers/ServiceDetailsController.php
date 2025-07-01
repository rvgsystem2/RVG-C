<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceDetailsController extends Controller
{
     public function index()
{
    $serviceDetails = ServiceDetail::with('category')->latest()->paginate(10);
    $categories = ServiceCategory::all();
    return view('servicedetail.index', compact('serviceDetails', 'categories'));
}

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('service-detail/images', 'public');
        }

        ServiceDetail::create($data);
        return redirect()->route('service-detail.index')->with('success', 'Service detail created successfully.');
    }

    public function update(Request $request, $id)
    {
        $detail = ServiceDetail::findOrFail($id);
        $data = $this->validateRequest($request);

        if ($request->hasFile('image')) {
            if ($detail->image) {
                Storage::disk('public')->delete($detail->image);
            }
            $data['image'] = $request->file('image')->store('service-detail/images', 'public');
        }

        $detail->update($data);
        return redirect()->route('service-detail.index')->with('success', 'Service detail updated successfully.');
    }

    public function destroy($id)
    {
        $detail = ServiceDetail::findOrFail($id);

        if ($detail->image) {
            Storage::disk('public')->delete($detail->image);
        }

        $detail->delete();
        return redirect()->back()->with('success', 'Service detail deleted successfully.');
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'sort_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
        ]);
    }
}
