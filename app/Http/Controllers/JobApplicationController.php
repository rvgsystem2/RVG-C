<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'position' => 'nullable|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5048', // Accept only docs up to 5MB
            'career_id' => 'nullable|exists:careers,id',
        ]);

        // Handle the resume upload
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        // Create job application
        JobApplication::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'career_id' => $request->career_id,
            'resume' => $resumePath ?? null,
        ]);

        return redirect()->back()->with('success', 'Your application has been submitted successfully.');
    }

    public function index(){
        $applications = JobApplication::all();
        return view('applications.index', compact('applications'));
    }

}
