<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
     public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        if ($request->hasFile('thumb_image')) {
            $data['thumb_image'] = $request->file('thumb_image')->store('projects/thumbs', 'public');
        }

        if ($request->hasFile('project_images')) {
            $projectImages = [];
            foreach ($request->file('project_images') as $image) {
                $projectImages[] = $image->store('projects/gallery', 'public');
            }
            $data['project_images'] = json_encode($projectImages);
        }

        Project::create($data);
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $data = $this->validateRequest($request);

        if ($request->hasFile('thumb_image')) {
            if ($project->thumb_image) {
                Storage::disk('public')->delete($project->thumb_image);
            }
            $data['thumb_image'] = $request->file('thumb_image')->store('projects/thumbs', 'public');
        }

        if ($request->hasFile('project_images')) {
            // Optionally delete old images if needed
            $projectImages = [];
            foreach ($request->file('project_images') as $image) {
                $projectImages[] = $image->store('projects/gallery', 'public');
            }
            $data['project_images'] = json_encode($projectImages);
        }

        $project->update($data);
        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function delete($id)
    {
        $project = Project::findOrFail($id);

        if ($project->thumb_image) {
            Storage::disk('public')->delete($project->thumb_image);
        }

        if ($project->project_images) {
            foreach (json_decode($project->project_images) as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $project->delete();
        return redirect()->back()->with('success', 'Project deleted successfully.');
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'project_category_name' => 'required|string|max:255|unique:projects,project_category_name,' . $request->project_id,
            'title' => 'nullable|string|max:255',
            'sort_description' => 'required|string|max:255|unique:projects,sort_description,' . $request->project_id,
            'project_url' => 'nullable|url',
            'thumb_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'project_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    }
}
