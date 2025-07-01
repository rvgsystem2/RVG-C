<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::latest()->paginate(10);
        return view('abouts.index', compact('abouts'));
    }

    public function create()
    {
        return view('abouts.create');
    }

    public function edit(About $about)
    {
        return view('abouts.edit', compact('about'));
    }
    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('abouts', 'public');
        }

        About::create($data);
        return redirect()->route('about.index')->with('success', 'About added successfully.');
    }

    public function update(Request $request, About $about)
    {
        $data = $this->validateRequest($request);

        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $request->file('image')->store('abouts', 'public');
        }

        $about->update($data);
        return redirect()->route('about.index')->with('success', 'About updated successfully.');
    }

    public function delete(About $about)
    {
        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }

        $about->delete();
        return redirect()->back()->with('success', 'About deleted successfully.');
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,draft'
        ]);
    }
}
