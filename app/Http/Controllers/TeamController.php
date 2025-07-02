<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
     public function index()
    {
        $teams = Team::latest()->get();
        return view('admin.team.index', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'nullable',
            'company' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'status' => 'required|in:active,inactive',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teams', 'public');
        }

        Team::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'company' => $request->company,
            'message' => $request->message,
            'status' => $request->status,
            'image' => $imagePath,
            'facebook' => $request->facebook,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'github' => $request->github,
            'whatsapp' => $request->whatsapp,
        ]);

        return redirect()->back()->with('success', 'Team member added successfully.');
    }

    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            if ($team->image && Storage::disk('public')->exists($team->image)) {
                Storage::disk('public')->delete($team->image);
            }
            $team->image = $request->file('image')->store('teams', 'public');
        }

        $team->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'company' => $request->company,
            'message' => $request->message,
            'status' => $request->status,
            'facebook' => $request->facebook,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'github' => $request->github,
            'whatsapp' => $request->whatsapp,
        ]);

        return redirect()->back()->with('success', 'Team member updated successfully.');
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        if ($team->image && Storage::disk('public')->exists($team->image)) {
            Storage::disk('public')->delete($team->image);
        }
        $team->delete();

        return redirect()->back()->with('success', 'Team member deleted successfully.');
    }
}
